<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        Schema::create('blog_post_tag', function (Blueprint $table): void {
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['blog_post_id', 'tag_id']);
        });

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Wheel Loader Insights',
            'slug' => 'wheel-loader-insights',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('blog_posts')->update(['category_id' => $categoryId]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
    }
};
