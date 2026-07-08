<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalPosts' => BlogPost::count(),
            'publishedPosts' => BlogPost::where('is_published', true)->count(),
            'draftPosts' => BlogPost::where('is_published', false)->count(),
            'categoryCount' => Category::count(),
            'tagCount' => Tag::count(),
            'recentPosts' => BlogPost::with(['author', 'category'])
                ->latest('updated_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
