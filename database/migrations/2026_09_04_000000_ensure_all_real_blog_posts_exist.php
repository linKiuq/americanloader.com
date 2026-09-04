<?php

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        $categoryWheelLoader = Category::firstOrCreate(
            ['slug' => 'wheel-loader-insights'],
            ['name' => 'Wheel Loader Insights']
        );

        $posts = [
            [
                'slug' => 'wheel-loader',
                'title' => 'A Guide to Understanding Wheel Loader Lift Heights',
                'excerpt' => 'Understand lift height, dump height, forward reach, loading performance, safety margins, and maintenance when choosing a wheel loader.',
                'category_id' => $categoryWheelLoader->id,
                'image_url' => 'https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-01.webp',
                'published_at' => '2026-06-30 00:00:00',
                'content' => <<<'MARKDOWN'
https://img.miniexcavator.org/ebay/Website-Team/Class3-4June/30-june/b9-01.webp

A wheel loader may appear powerful, yet it will fall short if its lift height does not match the demands of the job. Insufficient clearance or inadequate reach can lead to material spillage, extra repositioning, and reduced productivity. For professionals handling dirt, gravel, feed, or other bulk materials, lift height is a key specification that directly influences loading efficiency and overall jobsite performance.

This guide explains what wheel loader lift height really means and why it plays such an important role in everyday operations. You'll learn the difference between lift height and dump height, how these specifications affect loading performance, how to match them to your applications, and the maintenance practices that help preserve lifting performance over time.
MARKDOWN,
            ],
            [
                'slug' => 'news-wheel-loader',
                'title' => 'How to Safely Operate a Wheel Loader on Uneven Terrain',
                'excerpt' => 'Learn the inspection, load handling, speed control, slope travel, and stability habits that keep a wheel loader safer on rough ground.',
                'category_id' => $categoryWheelLoader->id,
                'image_url' => 'https://img.miniexcavator.org/ebay/Website-Team/Class1-27June/01.webp',
                'published_at' => '2026-06-27 00:00:00',
                'content' => <<<'MARKDOWN'
https://img.miniexcavator.org/ebay/Website-Team/Class1-27June/01.webp

A wheel loader moves serious weight, and that strength becomes a liability the moment the ground beneath it stops cooperating. Uneven terrain tests both the machine and the operator, demanding sharp awareness, smart planning, and disciplined technique on every pass.
MARKDOWN,
            ],
            [
                'slug' => 'wheel-loader-bucket-spillage-prevention',
                'title' => 'How to Reduce Your Wheel Loader Bucket Spillage During Material Transport',
                'excerpt' => 'Stop losing profit to wheel loader bucket spillage. Master these 5 vital adjustments to travel speeds, bucket angles, and operator loading techniques.',
                'category_id' => $categoryWheelLoader->id,
                'image_url' => 'https://img.miniexcavator.org/ebay/Website-Team/class3-4July/14-july/b9-01.webp',
                'published_at' => '2026-07-14 00:00:00',
                'content' => <<<'MARKDOWN'
## Wheel Loader Bucket Spillage: 5 Vital Ways to Stop Costly Loss

Extra cleanup, repeated passes, and added wear all chip away at your productivity and your budget over the course of a shift. Most bucket spillage comes down to a handful of controllable factors.
MARKDOWN,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'category_id' => $post['category_id'],
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'image_url' => $post['image_url'],
                    'is_published' => true,
                    'published_at' => Carbon::parse($post['published_at']),
                ]
            );
        }
    }

    public function down(): void
    {
    }
};
