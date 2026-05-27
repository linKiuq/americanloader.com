<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_blog_displays_published_posts_and_hides_drafts(): void
    {
        $draft = BlogPost::create([
            'title' => 'Internal Draft Article',
            'slug' => 'internal-draft-article',
            'excerpt' => 'A draft description.',
            'content' => 'Draft body.',
            'is_published' => false,
        ]);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('Telescopic Wheel Loader - Field Demo')
            ->assertDontSee($draft->title);

        $this->get(route('blog.show', 'wheel-loader-demo'))
            ->assertOk()
            ->assertSee('Telescopic Wheel Loader - Field Demo');

        $this->get(route('blog.show', $draft->slug))->assertNotFound();
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
        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee('Loader Maintenance Checklist')
            ->assertSee('Inspect tires and fluid levels.');

        $this->actingAs($admin)
            ->put(route('admin.blog.update', $post), [
                'title' => 'Loader Maintenance Checklist Updated',
                'slug' => 'loader-maintenance-checklist',
                'excerpt' => 'Revised inspection steps.',
                'content' => 'Updated maintenance guidance.',
            ])
            ->assertRedirect(route('admin.blog.edit', $post));

        $this->get(route('blog.show', $post->slug))->assertNotFound();

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

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee('Maintenance')
            ->assertSee('Hydraulics');

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'category_id' => null]);
    }
}
