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
                'filter' => fn (Collection $products): Collection => $products,
            ],
            'x2' => [
                'title' => 'X2 Attachments',
                'description' => 'Browse high-performance machinery and professional attachment solutions in the X2 Attachments collection.',
                'filter' => fn (Collection $products): Collection => $this->matchingNames($products, ['x2']),
            ],
            'xxv' => [
                'title' => 'XXV Attachments',
                'description' => 'Browse professional mini excavator attachment solutions built for Terror XXV machines and worksite upgrades.',
                'filter' => fn (Collection $products): Collection => $this->matchingNames($products, ['xxv']),
            ],
            '2-5-tons' => [
                'title' => 'XXV Attachments',
                'description' => 'Shop buckets, breakers, augers, grapples, and couplers compatible with heavy-duty compact excavator workflows.',
                'filter' => fn (Collection $products): Collection => $this->matchingNames($products, ['xxv']),
            ],
            '2-tons-and-below' => [
                'title' => '2 Ton and Below Attachments',
                'description' => 'Shop maneuverable excavation attachments for landscaping, trenching, material handling, and site cleanup.',
                'filter' => fn (Collection $products): Collection => $this->miniExcavatorTwoTonsAndBelow($products),
            ],
        ];

        abort_unless(isset($content[$size]), 404);

        return $this->renderCatalog(
            $request,
            $catalog,
            $content[$size]['title'],
            $content[$size]['description'],
            $content[$size]['filter'](
                $catalog->all()->where('category', 'Mini Excavator Attachments')->values()
            )
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
                'title' => 'Compact Series 501-507 Attachments',
                'description' => 'Shop versatile attachments for compact skid steer loader work in tight jobsites and material handling applications.',
                'filter' => fn (Collection $products): Collection => $products->reject(
                    fn (array $product): bool => $this->productNameContains($product, ['x1300', '509', 'stomp'])
                )->values(),
            ],
            'standard-series' => [
                'title' => 'Standard Series (X1300-509) Attachments',
                'description' => 'Shop heavy-duty buckets, grapples, tillers, trenchers, mulchers, and site-preparation attachments.',
                'filter' => fn (Collection $products): Collection => $this->matchingNames($products, ['x1300', '509', 'stomp']),
            ],
            default => abort(404),
        };

        return $this->renderCatalog(
            $request,
            $catalog,
            $content['title'],
            $content['description'],
            ($content['filter'] ?? fn (Collection $products): Collection => $products)(
                $catalog->all()->where('category', 'Skid Steer Attachments')->values()
            )
        );
    }

    private function attachments(ProductCatalog $catalog): Collection
    {
        return $catalog->all()
            ->whereIn('category', ['Mini Excavator Attachments', 'Skid Steer Attachments'])
            ->values();
    }

    private function matchingNames(Collection $products, array $needles): Collection
    {
        return $products
            ->filter(fn (array $product): bool => $this->productNameContains($product, $needles))
            ->values();
    }

    private function productNameContains(array $product, array $needles): bool
    {
        $name = mb_strtolower((string) ($product['name'] ?? ''));

        foreach ($needles as $needle) {
            if (str_contains($name, mb_strtolower($needle))) {
                return true;
            }
        }

        return false;
    }

    private function miniExcavatorTwoTonsAndBelow(Collection $products): Collection
    {
        return $products
            ->filter(function (array $product): bool {
                $name = mb_strtolower((string) ($product['name'] ?? ''));

                return str_contains($name, '0.8-2 ton')
                    || str_contains($name, '2ton')
                    || preg_match('/(^|[^0-9.])2\s*ton([^s]|$)/', $name) === 1;
            })
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
