<?php

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $jsonPath = database_path('data/supabase_posts.json');
        if (! file_exists($jsonPath)) {
            return;
        }

        $posts = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($posts)) {
            return;
        }

        foreach ($posts as $postData) {
            $category = null;
            if (! empty($postData['category'])) {
                $category = Category::firstOrCreate([
                    'name' => $postData['category'],
                ], [
                    'slug' => Str::slug($postData['category']),
                ]);
            }

            BlogPost::firstOrCreate([
                'slug' => $postData['slug'],
            ], [
                'title' => $postData['title'],
                'excerpt' => $postData['excerpt'] ?? '',
                'content' => $postData['content'] ?? '',
                'image_url' => $postData['featured_image'] ?? null,
                'is_published' => true,
                'published_at' => isset($postData['publish_date']) 
                    ? Carbon::parse($postData['publish_date']) 
                    : now(),
                'category_id' => $category?->id,
            ]);
        }
    }

    public function down(): void
    {
        // No down action needed to avoid destructive loss of content
    }
};
