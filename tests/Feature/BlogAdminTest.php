<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\SupabaseCmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class BlogAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_blog_displays_published_posts_and_hides_drafts(): void
    {
        $this->mock(SupabaseCmsService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPublishedPosts')
                ->once()
                ->andReturn([
                    [
                        'title' => 'Telescopic Wheel Loader - Field Demo',
                        'slug' => 'wheel-loader-demo',
                        'excerpt' => 'A published equipment guide.',
                        'category' => 'Buyer Guides',
                        'featured_image' => null,
                        'featured_image_alt' => null,
                        'author' => 'The Power Loader',
                        'publish_date' => '2026-05-27',
                    ],
                ]);

            $mock->shouldReceive('getPostBySlug')
                ->with('wheel-loader-demo')
                ->once()
                ->andReturn([
                    'title' => 'Telescopic Wheel Loader - Field Demo',
                    'slug' => 'wheel-loader-demo',
                    'excerpt' => 'A published equipment guide.',
                    'category' => 'Buyer Guides',
                    'content' => "## Field Notes\n\nPublished CMS body.",
                    'featured_image' => null,
                    'featured_image_alt' => null,
                    'author' => 'The Power Loader',
                    'publish_date' => '2026-05-27',
                    'seo_title' => null,
                    'seo_description' => null,
                ]);

            $mock->shouldReceive('getPostBySlug')
                ->with('internal-draft-article')
                ->once()
                ->andReturn(null);
        });

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('Telescopic Wheel Loader - Field Demo')
            ->assertDontSee('Internal Draft Article');

        $this->get(route('blog.show', 'wheel-loader-demo'))
            ->assertOk()
            ->assertSee('Telescopic Wheel Loader - Field Demo')
            ->assertSee('Field Notes');

        $this->get(route('blog.show', 'internal-draft-article'))->assertNotFound();
    }

    public function test_admin_blog_pages_require_an_admin_account(): void
    {
        $this->get(route('admin.blog.index'))->assertRedirect(route('admin.login'));

        $nonAdmin = User::factory()->create(['is_admin' => false]);

        $this->actingAs($nonAdmin)
            ->get(route('admin.blog.index'))
            ->assertForbidden();
    }

    public function test_admin_can_log_in_create_publish_update_and_delete_post(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@skoop.test',
            'password' => 'secure-password',
            'is_admin' => true,
        ]);

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'secure-password',
        ])->assertRedirect(route('admin.blog.index'));

        $this->post(route('admin.blog.store'), [
            'title' => 'Loader Maintenance Checklist',
            'slug' => '',
            'excerpt' => 'Daily inspection steps for reliable loader operation.',
            'content' => "Inspect tires and fluid levels.\n\nCheck attachment locking points.",
            'image_url' => 'https://example.com/loader-maintenance.jpg',
            'is_published' => '1',
        ])->assertRedirect();

        $post = BlogPost::where('slug', 'loader-maintenance-checklist')->firstOrFail();

        $this->assertTrue($post->is_published);
        $this->assertSame('Inspect tires and fluid levels.', str($post->content)->before("\n\n")->toString());

        $this->actingAs($admin)
            ->put(route('admin.blog.update', $post), [
                'title' => 'Loader Maintenance Checklist Updated',
                'slug' => 'loader-maintenance-checklist',
                'excerpt' => 'Revised inspection steps.',
                'content' => 'Updated maintenance guidance.',
            ])
            ->assertRedirect(route('admin.blog.edit', $post));

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Loader Maintenance Checklist Updated',
            'is_published' => false,
        ]);

        $post->refresh();
        $this->assertNull($post->published_at);

        $this->actingAs($admin)
            ->delete(route('admin.blog.destroy', $post))
            ->assertRedirect(route('admin.blog.index'));

        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    public function test_admin_can_change_password(): void
    {
        $admin = User::factory()->create([
            'password' => 'initial-password',
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'initial-password',
                'password' => 'new-secure-password',
                'password_confirmation' => 'new-secure-password',
            ])
            ->assertRedirect(route('admin.password.edit'));

        $this->post(route('admin.logout'));

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'initial-password',
        ])->assertSessionHasErrors('email');

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'new-secure-password',
        ])->assertRedirect(route('admin.blog.index'));
    }

    public function test_admin_can_manage_taxonomy_and_assign_it_to_a_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), ['name' => 'Maintenance', 'slug' => ''])
            ->assertRedirect(route('admin.categories.index'));
        $this->actingAs($admin)
            ->post(route('admin.tags.store'), ['name' => 'Hydraulics', 'slug' => ''])
            ->assertRedirect(route('admin.tags.index'));

        $category = Category::where('slug', 'maintenance')->firstOrFail();
        $tag = Tag::where('slug', 'hydraulics')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.blog.store'), [
                'title' => 'Hydraulic Inspection Guide',
                'excerpt' => 'Maintenance guidance for hydraulic systems.',
                'content' => 'Inspect hoses and couplings before operation.',
                'category_id' => $category->id,
                'tags' => [$tag->id],
                'is_published' => '1',
            ])
            ->assertRedirect();

        $post = BlogPost::where('slug', 'hydraulic-inspection-guide')->firstOrFail();

        $this->assertSame($admin->id, $post->user_id);
        $this->assertSame($category->id, $post->category_id);
        $this->assertTrue($post->tags->contains($tag));

        $this->actingAs($admin)
            ->get(route('admin.blog.edit', $post))
            ->assertOk()
            ->assertSee('Maintenance')
            ->assertSee('Hydraulics');

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'category_id' => null]);
    }
}
