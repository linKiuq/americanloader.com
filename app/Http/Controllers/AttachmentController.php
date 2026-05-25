<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AttachmentController extends Controller
{
    public function index(Request $request, ProductCatalog $catalog): View
    {
        return $this->renderCatalog(
            $request,
            $catalog,
            'Equipment Attachments',
            'Shop buckets, augers, grapples, breakers, grading tools, and worksite attachment packages built for compact equipment.',
            $this->attachments($catalog)
        );
    }

    public function miniExcavators(Request $request, ProductCatalog $catalog, string $size): View
    {
        $content = [
            'all' => [
                'title' => 'Mini Excavator Attachments',
                'description' => 'Shop buckets, breakers, augers, grapples, couplers, and attachment packages for compact excavator jobs.',
            ],
            '2-5-tons' => [
                'title' => 'Mini Excavator Attachments - 2.5 Tons',
                'description' => 'Shop buckets, breakers, augers, grapples, and couplers compatible with heavy-duty compact excavator workflows.',
            ],
            '2-tons-and-below' => [
                'title' => 'Mini Excavator Attachments - 2 Tons and Below',
                'description' => 'Shop maneuverable excavation attachments for landscaping, trenching, material handling, and site cleanup.',
            ],
        ];

        abort_unless(isset($content[$size]), 404);

        return $this->renderCatalog(
            $request,
            $catalog,
            $content[$size]['title'],
            $content[$size]['description'],
            $catalog->all()->where('category', 'Mini Excavator Attachments')->values()
        );
    }

    public function skidSteer(Request $request, ProductCatalog $catalog, ?string $series = null): View
    {
        $content = match ($series) {
            null => [
                'title' => 'Skid Steer Attachments',
                'description' => 'Shop high-performance skid steer implements for loading, grading, trenching, landscaping, and land clearing.',
            ],
            'compact-series' => [
                'title' => 'Skid Steer Compact Series Attachments',
                'description' => 'Shop versatile attachments for compact skid steer loader work in tight jobsites and material handling applications.',
            ],
            'standard-series' => [
                'title' => 'Skid Steer Standard Series Attachments',
                'description' => 'Shop heavy-duty buckets, grapples, tillers, trenchers, mulchers, and site-preparation attachments.',
            ],
            default => abort(404),
        };

        return $this->renderCatalog(
            $request,
            $catalog,
            $content['title'],
            $content['description'],
            $catalog->all()->where('category', 'Skid Steer Attachments')->values()
        );
    }

    private function attachments(ProductCatalog $catalog): Collection
    {
        return $catalog->all()
            ->whereIn('category', ['Mini Excavator Attachments', 'Skid Steer Attachments'])
            ->values();
    }

    private function renderCatalog(
        Request $request,
        ProductCatalog $catalog,
        string $title,
        string $description,
        Collection $products
    ): View {
        $attachmentCounts = $this->attachments($catalog)->countBy('category');
        $search = trim((string) $request->query('search'));
        $sort = (string) $request->query('sort', 'featured');

        if ($search !== '') {
            $products = $products->filter(function (array $product) use ($search): bool {
                return str_contains(
                    mb_strtolower($product['name'].' '.($product['desc'] ?? '')),
                    mb_strtolower($search)
                );
            });
        }

        $products = match ($sort) {
            'price-low' => $products->sortBy('price'),
            'price-high' => $products->sortByDesc('price'),
            'name' => $products->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
            default => $products,
        };

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;
        $paginatedProducts = new LengthAwarePaginator(
            $products->forPage($page, $perPage)->values(),
            $products->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('attachments.category', [
            'title' => $title,
            'description' => $description,
            'products' => $paginatedProducts,
            'productCount' => $products->count(),
            'attachmentCounts' => $attachmentCounts,
            'search' => $search,
            'sort' => $sort,
        ]);
    }
}
