<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PasswordController as AdminPasswordController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Services\SupabaseCmsService;
use App\Support\ProductCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nDisallow: /admin\nDisallow: /store/checkout\nDisallow: /store/cart\n\nSitemap: " . rtrim(config('seo.site_url'), '/') . "/sitemap.xml\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8']
    );
})->name('robots');

Route::get('/sitemap.xml', function (ProductCatalog $catalog, SupabaseCmsService $cms) {
    $siteUrl = rtrim(config('seo.site_url'), '/');
    $today = now()->toDateString();
    $url = fn (string $path): string => $siteUrl . ($path === '/' ? '/' : '/' . ltrim($path, '/'));
    $urls = collect([
        ['loc' => $url('/'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 1.0],
        ['loc' => $url('/equipment'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.9],
        ['loc' => $url('/attachments'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.8],
        ['loc' => $url('/attachments/mini-excavator'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/x2-attachments'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/xxv-attachments'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/mini-excavators-2-5-tons'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/mini-excavators-2-tons-and-below'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/skid-steer'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/skid-steer/compact-series'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/attachments/skid-steer/standard-series'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.75],
        ['loc' => $url('/store'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.8],
        ['loc' => $url('/about'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.6],
        ['loc' => $url('/contact'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.6],
        ['loc' => $url('/blog'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => 0.7],
        ['loc' => $url('/topics'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.7],
        ['loc' => $url('/topics/buy-guides'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.7],
        ['loc' => $url('/topics/features'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.7],
        ['loc' => $url('/topics/workspace'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.7],
        ['loc' => $url('/topics/safety'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => 0.7],
    ]);

    $productUrls = $catalog->all()
        ->map(fn (array $product): array => [
            'loc' => $url('/product/' . $product['slug']),
            'lastmod' => $today,
            'changefreq' => 'weekly',
            'priority' => 0.8,
        ]);

    try {
        $blogUrls = collect($cms->getPublishedPosts())
            ->filter(fn (array $post): bool => ! empty($post['slug']))
            ->map(fn (array $post): array => [
                'loc' => $url('/blog/' . $post['slug']),
                'lastmod' => \Illuminate\Support\Carbon::parse($post['updated_at'] ?? $post['publish_date'] ?? $today)->toDateString(),
                'changefreq' => 'monthly',
                'priority' => 0.7,
            ]);
    } catch (\Throwable) {
        $blogUrls = collect();
    }

    return response()
        ->view('sitemap', ['urls' => $urls->merge($productUrls)->merge($blogUrls)->values()])
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

// Home/Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Equipment Page
Route::get('/equipment', function () {
    return view('equipment');
})->name('equipment');

// Attachments Pages
Route::get('/attachments', [AttachmentController::class, 'index'])->name('attachments.index');
Route::get('/attachments/mini-excavator', [AttachmentController::class, 'miniExcavators'])
    ->defaults('size', 'all')
    ->name('attachments.mini-excavator');
Route::get('/attachments/x2-attachments', [AttachmentController::class, 'miniExcavators'])
    ->defaults('size', 'x2')
    ->name('attachments.x2');
Route::get('/attachments/xxv-attachments', [AttachmentController::class, 'miniExcavators'])
    ->defaults('size', 'xxv')
    ->name('attachments.xxv');
Route::get('/attachments/mini-excavators-2-5-tons', [AttachmentController::class, 'miniExcavators'])
    ->defaults('size', '2-5-tons')
    ->name('attachments.mini-excavators-2-5-tons');
Route::get('/attachments/mini-excavators-2-tons-and-below', [AttachmentController::class, 'miniExcavators'])
    ->defaults('size', '2-tons-and-below')
    ->name('attachments.mini-excavators-2-tons-and-below');
Route::get('/attachments/skid-steer', [AttachmentController::class, 'skidSteer'])->name('attachments.skid-steer');
Route::get('/attachments/skid-steer/{series}', [AttachmentController::class, 'skidSteer'])
    ->whereIn('series', ['compact-series', 'standard-series'])
    ->name('attachments.skid-steer.series');

// Ecwid Store Page
Route::get('/store', function () {
    return view('store');
})->name('store');

// Product Detail Page
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Laravel cart and checkout pages use store-prefixed URLs.
Route::get('/store/cart', [CartController::class, 'index'])->name('cart');
Route::post('/store/cart/add', [CartController::class, 'store'])->name('cart.items.store');
Route::patch('/store/cart/update', [CartController::class, 'update'])->name('cart.items.update');
Route::delete('/store/cart/remove', [CartController::class, 'destroy'])->name('cart.items.destroy');
Route::delete('/store/cart', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/store/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/store/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Us Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Blog index and posts
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Blog administration
Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    Route::get('/password', [AdminPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [AdminPasswordController::class, 'update'])->name('password.update');
    Route::post('/blog/images', [AdminBlogPostController::class, 'storeImage'])->name('blog.images.store');
    Route::resource('blog', AdminBlogPostController::class)
        ->parameters(['blog' => 'post'])
        ->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('tags', AdminTagController::class)->except(['show']);
});

Route::get('/topics', function () {
    return view('topics.index');
})->name('topics.index');

Route::get('/topics/{topic}', function (string $topic) {
    if ($topic === 'buy-guides') {
        return view('topics.buy-guides');
    }

    if ($topic === 'features') {
        return view('topics.features');
    }

    if ($topic === 'workspace') {
        return view('topics.workspace');
    }

    if ($topic === 'safety') {
        return view('topics.safety');
    }

    $topics = [
        'safety' => [
            'title' => 'Safety',
            'description' => 'Practical safety guidance for operators, crews, and maintenance teams.',
            'highlights' => [
                'Follow pre-start inspection best practices.',
                'Use attachments safely and securely.',
                'Keep the worksite clear and communication strong.',
            ],
        ],
    ];

    if (! array_key_exists($topic, $topics)) {
        abort(404);
    }

    return view('topics.detail', array_merge(['topic' => $topic], $topics[$topic]));
})->name('topics.show');
