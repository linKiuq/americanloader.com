<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->replacementImages() as $slug => $images) {
            DB::table('blog_posts')
                ->where('slug', $slug)
                ->update(['image_url' => $images['replacement']]);
        }
    }

    public function down(): void
    {
        foreach ($this->replacementImages() as $slug => $images) {
            DB::table('blog_posts')
                ->where('slug', $slug)
                ->update(['image_url' => $images['original']]);
        }
    }

    private function replacementImages(): array
    {
        return [
            'how-to-choose-a-skid-steer-loader-in-2026' => [
                'original' => 'https://kaaekveaaoriacwzzrnf.supabase.co/storage/v1/object/public/cms-media/1d463b79-438f-4f2b-9e88-acd42a324c27/blog/1780967930721-klacwci-task-image-2026-06-09T0118.webp',
                'replacement' => 'https://wheelloader.org/wp-content/uploads/2026/07/5894215154.jpg',
            ],
            'skid-steer-buying-guide' => [
                'original' => 'https://kaaekveaaoriacwzzrnf.supabase.co/storage/v1/object/public/cms-media/1d463b79-438f-4f2b-9e88-acd42a324c27/blog/1780718111583-1riiy92-task-image-2026-06-06T0355.webp',
                'replacement' => 'https://wheelloader.org/wp-content/uploads/2026/07/5894148737.jpg',
            ],
            'what-is-a-skid-steer-loader' => [
                'original' => 'https://kaaekveaaoriacwzzrnf.supabase.co/storage/v1/object/public/cms-media/1d463b79-438f-4f2b-9e88-acd42a324c27/blog/1780708169059-9po1y8r-task-image-2026-06-06T0109.webp',
                'replacement' => 'https://wheelloader.org/wp-content/uploads/2026/07/5927664001.jpg',
            ],
            'typhon-stomp-x1300-mini-skid-steer-loader-best-mini-skid-steer-for-small-property-work' => [
                'original' => 'https://kaaekveaaoriacwzzrnf.supabase.co/storage/v1/object/public/cms-media/1d463b79-438f-4f2b-9e88-acd42a324c27/blog/1781313219042-lhlfp0y-task-image-2026-06-13T0113.webp',
                'replacement' => 'https://wheelloader.org/wp-content/uploads/2026/07/1-37.webp',
            ],
            'best-mini-skid-steer-for-small-property-work' => [
                'original' => 'https://kaaekveaaoriacwzzrnf.supabase.co/storage/v1/object/public/cms-media/1d463b79-438f-4f2b-9e88-acd42a324c27/blog/1781313371315-xlt83s6-task-image-2026-06-13T0116.webp',
                'replacement' => 'https://wheelloader.org/wp-content/uploads/2026/07/1-37.webp',
            ],
        ];
    }
};
