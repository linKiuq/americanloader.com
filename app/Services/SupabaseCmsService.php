<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseCmsService
{
    private string $baseUrl;

    private string $key;

    private int $cacheTtl = 300;

    private const LIST_COLUMNS = 'id,title,slug,excerpt,category,featured_image,featured_image_alt,author,publish_date,published_at,updated_at';

    private const FULL_COLUMNS = 'id,title,slug,excerpt,category,content,featured_image,featured_image_alt,author,publish_date,seo_title,seo_description,published_at,updated_at';

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.supabase.url'), '/');
        $this->key = (string) config('services.supabase.anon_key');
    }

    public function getPublishedPosts(): array
    {
        return Cache::remember('cms_blog_posts:all', $this->cacheTtl, function (): array {
            return $this->query([
                'select' => self::LIST_COLUMNS,
                'status' => 'eq.published',
                'order' => 'publish_date.desc',
            ]);
        });
    }

    public function getPostBySlug(string $slug): ?array
    {
        $cacheKey = 'cms_blog_posts:slug:' . sha1($slug);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($slug): ?array {
            $rows = $this->query([
                'select' => self::FULL_COLUMNS,
                'slug' => 'eq.' . $slug,
                'status' => 'eq.published',
                'limit' => 1,
            ]);

            return $rows[0] ?? null;
        });
    }

    public function getPostsByCategory(string $category): array
    {
        $cacheKey = 'cms_blog_posts:cat:' . sha1($category);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($category): array {
            return $this->query([
                'select' => self::LIST_COLUMNS,
                'status' => 'eq.published',
                'category' => 'eq.' . $category,
                'order' => 'publish_date.desc',
            ]);
        });
    }

    public function flushCache(): void
    {
        Cache::forget('cms_blog_posts:all');
    }

    private function headers(): array
    {
        return [
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
        ];
    }

    private function query(array $params): array
    {
        if ($this->baseUrl === '' || $this->key === '') {
            Log::warning('[SupabaseCms] Missing Supabase URL or anon key in config.');

            return [];
        }

        try {
            $response = Http::withHeaders($this->headers())
                ->timeout(10)
                ->retry(2, 200)
                ->get("{$this->baseUrl}/rest/v1/cms_blog_posts", $params);

            if ($response->failed()) {
                Log::warning('[SupabaseCms] Request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [];
            }

            return $response->json() ?? [];
        } catch (\Throwable $exception) {
            Log::warning('[SupabaseCms] Request threw exception', [
                'error' => $exception->getMessage(),
            ]);

            return [];
        }
    }
}
