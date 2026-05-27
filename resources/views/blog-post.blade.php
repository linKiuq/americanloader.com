<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Blog Post - Typhon Machinery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    <main class="flex-grow">
        <div class="max-w-4xl mx-auto px-4 py-12">
            <?php
            $slug = $slug ?? '';
            $posts = [
                'wheel-loader-demo' => [
                    'title' => 'Telescopic Wheel Loader — Field Demo',
                    'date' => 'May 12, 2026',
                    'image' => 'https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg',
                    'content' => '<p>In this demo, we take the Telescopic Wheel Loader through a typical day of work. The Kubota D1105 engine provides reliable power and the telescopic reach enables safer loading.</p>'
                ],
                'thunder-vi-review' => [
                    'title' => 'TYPHON Thunder VI — Compact Review',
                    'date' => 'Apr 8, 2026',
                    'image' => 'https://machinery.online/wp-content/uploads/2025/03/TYPHON-Thunder-VI-23hp-EPA-BS-Engine-Wheel-Loader-scaled-1.webp',
                    'content' => '<p>We review the Thunder VI for compact jobsite scenarios. Small footprint, big performance.</p>'
                ],
                'typhon-terror-usecase' => [
                    'title' => 'TYPHON TERROR Use Cases',
                    'date' => 'Mar 18, 2026',
                    'image' => 'https://machinery.online/wp-content/uploads/2025/03/Brand-New-TYPHON-TERROR-4WD-Backhoe-Loader-USA.webp',
                    'content' => '<p>Examples of jobsite tasks where the TYPHON TERROR excels: digging, loading, and hauling.</p>'
                ]
            ];
            $post = $posts[$slug] ?? null;
            if (!$post) {
                echo '<h1 class="text-3xl font-black">Post not found</h1><p class="text-gray-600 mt-4">The requested article could not be found.</p>';
            } else {
                echo "<article class=\"prose lg:prose-xl\">";
                echo "<img src=\"{$post['image']}\" alt=\"{$post['title']}\" class=\"w-full h-64 object-cover rounded-lg mb-6\">";
                echo "<h1 class=\"text-3xl font-black mb-2\">{$post['title']}</h1>";
                echo "<div class=\"text-sm text-gray-500 mb-6\">{$post['date']}</div>";
                echo $post['content'];
                echo "</article>";
            }
            ?>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
