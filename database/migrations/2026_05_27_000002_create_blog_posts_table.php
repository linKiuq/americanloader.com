<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image_url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        DB::table('blog_posts')->insert([
            [
                'title' => 'Telescopic Wheel Loader - Field Demo',
                'slug' => 'wheel-loader-demo',
                'excerpt' => 'See how the new Telescopic Wheel Loader performs on-site with Kubota power and extra reach.',
                'content' => 'In this demo, we take the Telescopic Wheel Loader through a typical day of work. The Kubota D1105 engine provides reliable power and the telescopic reach enables safer loading.',
                'image_url' => 'https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg',
                'is_published' => true,
                'published_at' => '2026-05-12 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TYPHON Thunder VI - Compact Review',
                'slug' => 'thunder-vi-review',
                'excerpt' => 'An operator-focused review of the Thunder VI and why crews choose it for tight-site work.',
                'content' => 'We review the Thunder VI for compact jobsite scenarios. Small footprint, big performance.',
                'image_url' => 'https://machinery.online/wp-content/uploads/2025/03/TYPHON-Thunder-VI-23hp-EPA-BS-Engine-Wheel-Loader-scaled-1.webp',
                'is_published' => true,
                'published_at' => '2026-04-08 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TYPHON TERROR Use Cases',
                'slug' => 'typhon-terror-usecase',
                'excerpt' => 'How the TERROR 4WD handles heavy-duty yard work, digging, and loading across industries.',
                'content' => 'Examples of jobsite tasks where the TYPHON TERROR excels: digging, loading, and hauling.',
                'image_url' => 'https://machinery.online/wp-content/uploads/2025/03/Brand-New-TYPHON-TERROR-4WD-Backhoe-Loader-USA.webp',
                'is_published' => true,
                'published_at' => '2026-03-18 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
