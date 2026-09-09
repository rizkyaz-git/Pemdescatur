<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display visual gallery populated with photos from published village news articles.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');
        $sort = $request->query('sort', 'latest');

        $query = News::query()
            ->where('status', 'published')
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '');

        if ($selectedCategory) {
            $query->where('category', $selectedCategory);
        }

        if ($sort === 'popular') {
            $query->orderByDesc('views_count');
        } else {
            $query->orderByDesc('published_at');
        }

        $galleries = $query->paginate(12)->withQueryString();

        // Pluck distinct categories from news that have photos for filter options
        $categories = News::query()
            ->where('status', 'published')
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('public.gallery', compact('galleries', 'categories', 'selectedCategory', 'sort'));
    }
}
