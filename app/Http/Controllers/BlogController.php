<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = $this->publishedPosts();

        return view('blog', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->first();

        if (! $post) {
            $legacyPost = $this->legacyPost($slug);
            abort_if(! $legacyPost, 404);

            return view('blog-post', ['post' => $legacyPost]);
        }

        return view('blog-post', ['post' => $this->postToArray($post)]);
    }

    public function category(string $categoryName): View
    {
        $category = Category::where('slug', $categoryName)
            ->orWhere('name', $categoryName)
            ->first();
        $categorySlug = $category?->slug ?? $categoryName;
        $posts = $this->publishedPosts()
            ->filter(fn (array $post): bool => ($post['category_slug'] ?? null) === $categorySlug || ($post['category'] ?? null) === $categoryName)
            ->values();

        return view('blog', [
            'posts' => $posts,
            'activeCategory' => $category?->name ?? $categoryName,
        ]);
    }

    private function publishedPosts(): Collection
    {
        $databasePosts = BlogPost::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->get()
            ->map(fn ($post) => $this->postToArray($post))
            ->values();

        return $databasePosts
            ->merge(collect($this->legacyPosts())->reject(fn (array $post): bool => $databasePosts->contains('slug', $post['slug'])))
            ->sortByDesc('publish_date')
            ->values();
    }

    private function postToArray(BlogPost $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'category' => $post->category?->name,
            'category_slug' => $post->category?->slug,
            'content' => $post->content,
            'featured_image' => $post->image_url,
            'featured_image_alt' => $post->title,
            'author' => $post->author?->name ?? 'Admin',
            'publish_date' => $post->published_at?->toDateString(),
            'seo_title' => $post->title,
            'seo_description' => $post->excerpt,
        ];
    }

    private function legacyPost(string $slug): ?array
    {
        return collect($this->legacyPosts())->firstWhere('slug', $slug);
    }

    private function legacyPosts(): array
    {
        return [
            [
                'id' => 'legacy-wheel-loader-vs-tractor-loader-performance',
                'title' => 'Wheel Loader vs. Tractor Loader Performance',
                'slug' => 'wheel-loader-vs-tractor-loader-performance',
                'excerpt' => 'Compare wheel loader and tractor loader performance for lifting, loading, traction, maneuverability, attachments, and daily jobsite productivity.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
Wheel loaders and tractor loaders can both move loose material, lift pallets, carry attachments, and help crews finish outdoor work faster. They are not built for the same kind of performance, though. A wheel loader is designed around loading efficiency, hydraulic strength, visibility, and repeated material-handling cycles. A tractor loader is usually built around mixed agricultural or utility work, where the loader is one of several tools mounted to the machine.

Understanding that difference matters before you buy or assign equipment to a job. The right machine can reduce cycle time, protect the operator, and keep the work moving. The wrong one can spend the day underpowered, unstable, or constantly repositioning.

Wheel Loader Strengths

A wheel loader usually delivers stronger dedicated loading performance. Its frame, lift arms, hydraulic system, counterweight, and operator position are all arranged around scooping, carrying, lifting, and dumping material. That makes it a strong fit for gravel yards, feed handling, snow removal, landscaping supply, construction cleanup, and jobs where the machine repeats the same load-and-carry cycle many times per day.

Wheel loaders also tend to offer better forward visibility to the bucket and work area. The operator sits in a cab designed for material handling, with controls positioned for frequent lift, tilt, and travel adjustments. When productivity depends on clean bucket fills and accurate dumping, that dedicated layout makes a real difference.

Tractor Loader Strengths

A tractor loader is useful when the job requires more than loading. It can be a good fit for farms, acreage maintenance, mowing, grading, light material movement, and chores where PTO-driven implements or rear attachments are just as important as the front bucket. For owners who need one machine to perform several moderate-duty tasks, the tractor loader can be practical and cost-effective.

The tradeoff is that the loader is often an added function rather than the core purpose of the machine. Lift height, breakout force, hydraulic speed, stability under heavy loads, and cycle time may not match a purpose-built wheel loader.

Loading Speed and Cycle Time

For repeated loading work, cycle time is one of the clearest performance differences. A wheel loader is built to enter a pile, fill the bucket, reverse, travel, lift, dump, and return with smooth rhythm. The steering geometry, drivetrain, bucket linkage, and hydraulic response are designed around that pattern.

A tractor loader can handle lighter loading tasks, but it may need more repositioning and more careful handling when the material is heavy or the loading target is high. Over a long workday, those extra seconds in each cycle can add up to less material moved and more operator fatigue.

Lift Capacity and Stability

Wheel loaders generally have an advantage when carrying heavier loads because their weight distribution and counterweight are designed for loader work. The machine stays more planted when the bucket is full, especially when traveling across uneven yards or lifting into trucks, bins, or hoppers.

Tractor loaders can lift and carry effectively within their rated limits, but operators need to be more aware of rear ballast, slope, tire setup, and load height. A tractor carrying a raised bucket without proper ballast can become unstable quickly. Always follow the manufacturer's rated operating capacity for either machine.

Traction and Jobsite Ground Conditions

Wheel loaders perform well on compacted yards, gravel lots, construction sites, snow lots, and material handling areas where traction and pushing power matter. Articulated steering and heavy tires help the machine stay productive while carrying dense materials.

Tractor loaders are useful on farms and open properties, especially where the machine also needs to pull implements. In softer ground, tire choice, ballast, and machine weight become important. If the job is mostly loading, hauling, and dumping, the wheel loader is usually the stronger dedicated option. If the job mixes loader work with mowing, tilling, grading, or pulling, the tractor loader may make more sense.

Attachment Flexibility

Both machines can use attachments, but the best choice depends on the attachment workload. Wheel loaders are commonly paired with buckets, forks, grapple buckets, snow pushers, brooms, and material-handling tools. These attachments support repeated lifting, loading, cleanup, and transport work.

Tractor loaders can also use buckets and forks, while the tractor itself can run rear implements and PTO-powered tools. That makes it more versatile for property maintenance, but less specialized for high-volume loader productivity.

Which Machine Should You Choose?

Choose a wheel loader when the main job is moving, lifting, loading, stacking, or clearing material every day. It is the better fit when cycle time, lift height, operator visibility, hydraulic power, and stability under load are the deciding factors.

Choose a tractor loader when you need one machine for varied property, farm, or utility tasks and loader work is only part of the schedule. It can be the better value when mowing, pulling, rear implements, and lighter bucket work all matter.

The simplest way to decide is to look at your most common work, not the occasional task. If most hours are spent loading and carrying material, the wheel loader is usually the stronger performance choice. If most hours are split across many types of maintenance work, the tractor loader may be the more flexible machine.
MARKDOWN,
                'featured_image' => 'https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg',
                'featured_image_alt' => 'Wheel loader with front bucket',
                'author' => 'Admin',
                'publish_date' => '2026-07-11',
                'seo_title' => 'Wheel Loader vs. Tractor Loader Performance',
                'seo_description' => 'Compare wheel loader and tractor loader performance for lifting, loading, traction, maneuverability, attachments, and daily jobsite productivity.',
            ],
        ];
    }
}
