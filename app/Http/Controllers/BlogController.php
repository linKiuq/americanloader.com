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
                'id' => 'legacy-wheel-loader',
                'title' => 'A Guide to Understanding Wheel Loader Lift Heights',
                'slug' => 'wheel-loader',
                'excerpt' => 'Understand lift height, dump height, forward reach, loading performance, safety margins, and maintenance when choosing a wheel loader.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-01.webp

A wheel loader may appear powerful, yet it will fall short if its lift height does not match the demands of the job. Insufficient clearance or inadequate reach can lead to material spillage, extra repositioning, and reduced productivity. For professionals handling dirt, gravel, feed, or other bulk materials, lift height is a key specification that directly influences loading efficiency and overall jobsite performance.

This guide explains what wheel loader lift height really means and why it plays such an important role in everyday operations. You'll learn the difference between lift height and dump height, how these specifications affect loading performance, how to match them to your applications, and the maintenance practices that help preserve lifting performance over time.

Defining Wheel Loader Lift Height Specifications

Before evaluating equipment, it is essential to understand the technical data provided in specification sheets. Wheel loader lift height involves several distinct measurements that should not be confused. Lift height refers to the maximum vertical distance reached by the bucket hinge pin when the lift arms are fully extended. Dump height measures the distance from the ground to the lowest edge of the bucket when it is raised to its maximum height and fully tipped forward.

Impact of Lift Height on Jobsite Performance

https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-02.webp

Understanding lift height specifications is the foundation for improving real-world jobsite performance. Lift height directly affects loading efficiency, cycle times, safety margins, and the variety of tasks a wheel loader can perform. Selecting the right specification helps maximize productivity while reducing unnecessary machine movement.

Matching Lift Height to Your Specific Application

https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-03.webp

Selecting the ideal lift height begins with an honest assessment of your day-to-day operations. Evaluate your most common loading tasks rather than selecting a machine based only on occasional requirements. Consider the height of your trucks, trailers, hoppers, and storage bins, then choose a loader that can service these targets comfortably without operating at its maximum mechanical limits on every cycle.

Maintaining Lift Performance and Reliability

https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-04.webp

Maintaining a wheel loader's rated lift performance requires consistent maintenance and regular inspections. Regular inspections of the hydraulic system, lift arms, cylinders, hoses, and linkage components help identify leaks, wear, or loose pivot points before they affect machine performance.

Conclusion

Lift height is one of the most important specifications when selecting a wheel loader because it directly influences loading efficiency, productivity, and the range of tasks the machine can perform. Understanding the differences between lift height, dump height, and forward reach allows you to evaluate equipment more accurately and choose a loader that matches your daily operating requirements.
MARKDOWN,
                'featured_image' => 'https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-01.webp',
                'featured_image_alt' => 'A Guide to Understanding Wheel Loader Lift Heights',
                'author' => 'Admin',
                'publish_date' => '2026-06-30',
                'seo_title' => 'A Guide to Understanding Wheel Loader Lift Heights',
                'seo_description' => 'Understand lift height, dump height, forward reach, loading performance, safety margins, and maintenance when choosing a wheel loader.',
            ],
            [
                'id' => 'legacy-news-wheel-loader',
                'title' => 'How to Safely Operate a Wheel Loader on Uneven Terrain',
                'slug' => 'news-wheel-loader',
                'excerpt' => 'Learn the inspection, load handling, speed control, slope travel, and stability habits that keep a wheel loader safer on rough ground.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
https://img.miniexcavator.org/ebay/Website-Team/Class1-27June/01.webp

A wheel loader moves serious weight, and that strength becomes a liability the moment the ground beneath it stops cooperating. Uneven terrain tests both the machine and the operator, demanding sharp awareness, smart planning, and disciplined technique on every pass.

Conducting Pre-Shift Ground Inspections

Safe operation starts long before you climb into the cab, and a thorough walk of the work area is the foundation everything else rests on. Uneven terrain hides hazards that can turn a routine task into a rollover, so you need to physically survey the path the loader will travel rather than judging it from the seat.

Maintaining a Low Center of Gravity

The single most important habit for stability on uneven ground is keeping the loader's center of gravity as low as possible. Carry the bucket low while traveling, point the load uphill on inclines, avoid raising the load during turns, and match load size to the ground conditions.

Mastering Controlled Speed and Braking

https://img.miniexcavator.org/ebay/Website-Team/Class1-27June/02.webp

Smooth, deliberate control is what separates safe operation on uneven ground from a series of near misses. Rough terrain punishes sudden inputs, because every abrupt acceleration, sharp turn, or hard stop sends shock through the machine.

Traversing Slopes and Inclines Correctly

Slopes present the greatest stability challenge a wheel loader faces. Always travel straight up or straight down a grade, never across it. Keep the load low and uphill, lower the bucket immediately if unstable, and reduce speed on the descent.

Utilizing Machine Stability Features and Techniques

Modern wheel loaders come equipped with features designed to help you stay stable on rough ground. Ride control can dampen boom motion and reduce the bounce that uneven terrain sends through the machine. Combine machine aids with wide, gradual turns and properly maintained tires.

Conclusion

Operating a wheel loader on uneven terrain comes down to preparation, awareness, and disciplined technique working together on every pass. When you walk the ground before each shift, keep your load low, manage speed and braking smoothly, respect the fall line on slopes, and use stability features correctly, you build layers of protection that keep both operator and equipment safer.
MARKDOWN,
                'featured_image' => 'https://img.miniexcavator.org/ebay/Website-Team/Class1-27June/01.webp',
                'featured_image_alt' => 'How to Safely Operate a Wheel Loader on Uneven Terrain',
                'author' => 'Admin',
                'publish_date' => '2026-06-27',
                'seo_title' => 'How to Safely Operate a Wheel Loader on Uneven Terrain',
                'seo_description' => 'Learn the inspection, load handling, speed control, slope travel, and stability habits that keep a wheel loader safer on rough ground.',
            ],
            [
                'id' => 'legacy-attachments-wheel-loader',
                'title' => 'Wheel Loader Attachments Guide',
                'slug' => 'attachments-wheel-loader',
                'excerpt' => 'A practical guide to common wheel loader attachments, including buckets, forks, grapples, sweepers, snow tools, and material handling options.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
Wheel loader attachments make one machine useful for many different jobs. The right tool can help a loader scoop, lift, carry, clear, sweep, stack, and handle material more efficiently.

Common Wheel Loader Attachments

Standard buckets are the everyday choice for dirt, gravel, mulch, feed, sand, and other loose material. Light material buckets are useful when the job involves high-volume, low-density material such as mulch, compost, grain, wood chips, or snow.

Pallet forks help move bagged products, lumber, pipe, palletized material, attachments, and jobsite supplies. Grapple attachments help secure brush, logs, demolition debris, scrap, and irregular loads that can shift or spill from a standard bucket.

Snow Attachments

Snow pushers, snow buckets, and snow blowers can turn a wheel loader into a strong winter cleanup machine. Open lots may benefit from a snow pusher, while tight sites or haul-off work may need a bucket. The best snow attachment depends on the site layout, snowfall volume, stacking space, and hauling plan.

Sweepers and Cleanup Tools

Angle brooms and pickup brooms clean paved yards, warehouses, parking lots, streets, and construction areas. They remove dust, gravel, leaves, light snow, and debris faster than hand cleanup and help keep traffic areas safer.

Choosing the Right Attachment

Start with the work the loader does most often. Match the attachment to the material, hydraulic setup, quick coupler, lift capacity, visibility, and working space. The best attachment is not always the largest one; it is the one the loader can use safely and efficiently all day.

Conclusion

Wheel loader attachments expand what a single machine can do. Buckets, forks, grapples, snow tools, sweepers, and specialty tools all have a place when they match the loader and the job. Choose attachments around real daily tasks, not just occasional needs, and always stay within the machine's rated limits.
MARKDOWN,
                'featured_image' => 'https://img.miniexcavator.org/ebay/Website-Team/class3-4July/4-july/b9-01.webp',
                'featured_image_alt' => 'Wheel Loader Attachments Guide',
                'author' => 'Admin',
                'publish_date' => '2026-07-04',
                'seo_title' => 'Wheel Loader Attachments Guide',
                'seo_description' => 'A practical guide to common wheel loader attachments, including buckets, forks, grapples, sweepers, snow tools, and material handling options.',
            ],
            [
                'id' => 'legacy-wheel-loader-vs-tractor-loader-performance',
                'title' => 'Wheel Loader vs. Tractor Loader Performance',
                'slug' => 'wheel-loader-vs-tractor-loader-performance',
                'excerpt' => 'Compare wheel loader and tractor loader performance for lifting, loading, traction, maneuverability, attachments, and daily jobsite productivity.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
Wheel loaders and tractor loaders can both move material, lift supplies, and support outdoor work. They are not built for the same performance profile. A wheel loader is designed around loading, carrying, lifting, dumping, and repeated material handling. A tractor loader is usually a multi-purpose machine where the front loader is one part of a broader utility setup.

Wheel Loader Performance

A wheel loader usually has the advantage when the main job is moving material all day. Its frame, lift arms, hydraulic system, counterweight, cab position, and steering are designed for efficient loading cycles. That makes it a strong fit for gravel yards, feed handling, snow removal, landscape supply yards, construction cleanup, and stockpile work.

Tractor Loader Performance

A tractor loader can be a good fit when the machine needs to handle mixed farm, property, or utility jobs. It can use rear implements and PTO-powered tools, so it may be more flexible for mowing, grading, pulling, light loader work, and acreage maintenance.

The tradeoff is that a tractor loader may not match a dedicated wheel loader in cycle speed, lift height, breakout force, visibility, or stability under heavy repeated bucket work.

Cycle Time and Productivity

For repeated loading, cycle time matters. A wheel loader is built to enter a pile, fill the bucket, reverse, travel, lift, dump, and return with a smooth rhythm. A tractor loader can do lighter loading work, but it may need more careful positioning and slower handling with dense material or high loading targets.

Lift Capacity and Stability

Wheel loaders are generally stronger for heavy carry-and-load tasks because their weight distribution and counterweight are designed for loader work. Tractor loaders can lift effectively within their rated limits, but rear ballast, tire setup, slope, and load height become especially important.

Which One Fits Best?

Choose a wheel loader when most hours are spent loading, carrying, stacking, clearing, or handling material. Choose a tractor loader when the work is split across many property or farm tasks and loader work is only part of the schedule.

Conclusion

The best machine depends on the job you do most often. If productivity depends on loader cycle time, lift strength, visibility, and stable material handling, a wheel loader is usually the stronger performance choice. If the job requires one machine for varied utility work, a tractor loader may be the more flexible option.
MARKDOWN,
                'featured_image' => 'https://img.miniexcavator.org/ebay/Website-Team/class3-4July/11-july/b9-01.webp',
                'featured_image_alt' => 'Wheel Loader vs. Tractor Loader Performance',
                'author' => 'Admin',
                'publish_date' => '2026-07-11',
                'seo_title' => 'Wheel Loader vs. Tractor Loader Performance',
                'seo_description' => 'Compare wheel loader and tractor loader performance for lifting, loading, traction, maneuverability, attachments, and daily jobsite productivity.',
            ],
        ];
    }
}
