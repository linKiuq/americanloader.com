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
            [
                'id' => 'legacy-attachments-wheel-loader',
                'title' => 'Wheel Loader Attachments Guide',
                'slug' => 'attachments-wheel-loader',
                'excerpt' => 'A practical guide to common wheel loader attachments, including buckets, forks, grapples, sweepers, snow tools, and material handling options.',
                'category' => 'Wheel Loader Insights',
                'category_slug' => 'wheel-loader-insights',
                'content' => <<<'MARKDOWN'
Wheel loader attachments turn one machine into a more flexible jobsite tool. With the right attachment, a wheel loader can dig, scoop, grade, lift pallets, clear snow, sweep paved areas, handle brush, move loose material, and support cleanup work across farms, yards, warehouses, construction sites, and landscaping operations.

Choosing attachments is not just about buying more tools. The attachment has to match the loader's hydraulic capacity, operating weight, quick coupler, lift height, tire setup, and daily workload. A well-matched attachment improves productivity and protects the machine. A poor match can slow the operator down, overload components, or create unsafe handling.

Standard Buckets

The standard bucket is the most common wheel loader attachment because it handles the everyday work: loading dirt, gravel, mulch, sand, feed, and other loose material. It is a strong choice for general material movement when the job does not require specialized cutting, gripping, or high-volume snow handling.

Bucket size matters. A bucket that is too small wastes cycle time, while a bucket that is too large can overload the machine and reduce stability. Match bucket capacity to the material weight, not just the bucket's physical size. Light mulch can use more volume than wet soil, gravel, or packed material.

Light Material Buckets

Light material buckets are built for high-volume, lower-density materials such as mulch, wood chips, grain, compost, and snow. They let the operator move more volume per pass without exceeding the loader's rated capacity.

These buckets are useful in landscaping supply yards, agricultural operations, and snow cleanup where volume matters more than digging force. They are not the best choice for dense rock, heavy wet clay, or aggressive excavation.

Pallet Forks

Pallet forks make a wheel loader useful for lifting and transporting palletized materials, bagged products, lumber, pipe, concrete blocks, attachments, and jobsite supplies. They are especially helpful when the loader needs to unload trucks, organize a yard, or move materials across rough ground where a forklift may struggle.

Operators should keep loads low while traveling and confirm that the fork rating, load center, and machine capacity match the object being lifted. Fork work becomes safer and more productive when the operator has clear visibility and uses smooth steering and braking.

Grapple Attachments

Grapple buckets and grapple forks help secure irregular material that can roll, shift, or spill from a standard bucket. They are useful for brush, logs, demolition debris, scrap, storm cleanup, nursery work, and mixed waste.

The gripping arm gives the operator more control over awkward material, reducing dropped loads and extra cleanup. Before choosing a grapple, confirm hydraulic flow requirements and coupler compatibility.

Snow Attachments

Wheel loaders are strong snow machines when paired with the right attachment. Snow pushers move large volumes across lots, snow buckets load and stack material, and snow blowers help when there is limited room to pile snow.

For open lots, a snow pusher can clear wide areas quickly. For tight spaces or hauling snow away, a bucket may be better. The best snow setup depends on the property layout, snowfall volume, stacking space, and whether trucks will haul snow off site.

Sweepers and Brooms

Pickup brooms and angle brooms help clean paved yards, parking lots, warehouses, streets, and construction areas. They remove dust, gravel, leaves, light snow, and jobsite debris faster than manual cleanup.

When choosing a broom, consider working width, bristle type, hydraulic requirements, dust control, and whether the job needs a collection hopper. A broom can protect tires and reduce slip hazards by keeping traffic areas cleaner.

Material Handling and Specialty Tools

Some wheel loader jobs need more specialized tools, such as bale spears, jib booms, concrete buckets, side-dump buckets, rock buckets, high-dump buckets, and dozer blades. These attachments can make sense when a job has a repeated task that standard buckets or forks cannot perform efficiently.

Specialty tools should be chosen carefully because they can change machine balance and handling. Always check rated capacity, hydraulic needs, attachment weight, and the loader manufacturer's limits.

How to Choose the Right Attachment

Start with the task you do most often. If the loader spends most of the day moving loose material, choose the right bucket. If it unloads pallets and supplies, forks may matter more. If it clears snow every winter, snow pushers or snow buckets can quickly pay for themselves. If it handles brush or debris, a grapple can save hours of manual cleanup.

Next, confirm compatibility. Check the coupler system, hydraulic flow, operating weight, lift capacity, tire traction, and visibility from the cab. The best attachment is not the largest one; it is the one the machine can use safely and efficiently all day.

Conclusion

Wheel loader attachments expand what one machine can do, but each attachment should solve a real jobsite need. Buckets, forks, grapples, snow tools, sweepers, and specialty tools all have a place when they match the loader and the work. By choosing attachments around your daily tasks, material weight, hydraulic setup, and safety limits, you can get more productive hours from the same machine while keeping operators in control.
MARKDOWN,
                'featured_image' => 'https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg',
                'featured_image_alt' => 'Wheel loader attachment guide',
                'author' => 'Admin',
                'publish_date' => '2026-07-04',
                'seo_title' => 'Wheel Loader Attachments Guide',
                'seo_description' => 'A practical guide to common wheel loader attachments, including buckets, forks, grapples, sweepers, snow tools, and material handling options.',
            ],
        ];
    }
}
