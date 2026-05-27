<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
Route::get('/blog', function () {
    return view('blog');
})->name('blog.index');

Route::get('/blog/{slug}', function (string $slug) {
    return view('blog-post', ['slug' => $slug]);
})->name('blog.show');

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
