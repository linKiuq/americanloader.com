<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_blog_displays_published_posts_and_hides_drafts(): void
    {
        BlogPost::query()->delete();

        $category = Category::firstOrCreate([
            'slug' => 'buyer-guides',
        ], [
            'name' => 'Buyer Guides',
        ]);

        $published = BlogPost::create([
            'title' => 'Telescopic Wheel Loader - Field Demo',
            'slug' => 'wheel-loader-demo',
            'excerpt' => 'A published equipment guide.',
            'content' => "## Field Notes\n\nPublished CMS body.",
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

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
            ->assertDontSee('Internal Draft Article');

        $this->get(route('blog.show', 'wheel-loader-demo'))
            ->assertOk()
            ->assertSee('Telescopic Wheel Loader - Field Demo')
            ->assertSee('Field Notes')
            ->assertSee('/blog/category/buyer-guides', escape: false);

        $this->get(route('blog.category', 'buyer-guides'))
            ->assertOk()
            ->assertSee('Buyer Guides')
            ->assertSee('Telescopic Wheel Loader - Field Demo');

        $this->get(route('blog.show', 'internal-draft-article'))->assertNotFound();
    }

    public function test_public_blog_turns_pasted_image_urls_into_images_and_keeps_markdown_headings(): void
    {
        $post = BlogPost::create([
            'title' => 'Attachment Image Article',
            'slug' => 'attachment-image-article',
            'excerpt' => 'A post with pasted image URLs.',
            'content' => "Beyond Moving Dirt: Versatile Ways to Use Your Wheel Loader\n\nhttps://img.miniexcavator.org/ebay/Website-Team/class3-4-July/4-july/b9-02.webp Grass grapples bring a specialized capability.\n\n### Pallet Forks\n\nOriginal paragraph text stays here.\n\nMaterial Handling and Logistics",
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee('<h2>Beyond Moving Dirt: Versatile Ways to Use Your Wheel Loader</h2>', escape: false)
            ->assertSee('<img src="https://img.miniexcavator.org/ebay/Website-Team/class3-4-July/4-july/b9-02.webp" alt="Article image" />', escape: false)
            ->assertSee('Grass grapples bring a specialized capability.')
            ->assertSee('<h3>Pallet Forks</h3>', escape: false)
            ->assertSee('Original paragraph text stays here.')
            ->assertSee('<h2>Material Handling and Logistics</h2>', escape: false);
    }

    public function test_admin_blog_pages_require_an_admin_account(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get(route('admin.dashboard.show'))->assertRedirect(route('admin.login'));
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
        ])->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Admin Dashboard')
            ->assertSee('New Post');

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
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_root_opens_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Admin Dashboard')
            ->assertSee('Recent Articles');
    }

    public function test_admin_can_upload_blog_content_images(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)
            ->postJson(route('admin.blog.images.store'), [
                'image' => UploadedFile::fake()->image('loader-service.jpg', 900, 600),
            ]);

        $response->assertOk()
            ->assertJsonStructure(['url']);

        $url = $response->json('url');
        $this->assertStringStartsWith('/storage/blog-images/', $url);

        Storage::disk('public')->assertExists(str_replace('/storage/', '', $url));
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
