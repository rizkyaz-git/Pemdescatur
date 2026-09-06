<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $query->orderBy('published_at', 'asc');
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $newsList = $query->paginate(6)->withQueryString();
        $categories = News::where('status', 'published')->distinct()->pluck('category')->filter()->values();

        return view('public.news.index', compact('newsList', 'categories'));
    }

    public function show(string $slug): View
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count per session visit
        $viewKey = 'viewed_news_' . $news->id;
        if (!session()->has($viewKey)) {
            $news->increment('views_count');
            session()->put($viewKey, true);
        }

        $recentNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $categories = News::where('status', 'published')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('public.news.show', compact('news', 'recentNews', 'categories'));
    }

    public function like(string $slug)
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $likeKey = 'liked_news_' . $news->id;
        $isLiked = session()->has($likeKey);

        if ($isLiked) {
            if ($news->likes_count > 0) {
                $news->decrement('likes_count');
            }
            session()->forget($likeKey);
            $isLiked = false;
        } else {
            $news->increment('likes_count');
            session()->put($likeKey, true);
            $isLiked = true;
        }

        $news->refresh();

        return response()->json([
            'success' => true,
            'likes_count' => (int) $news->likes_count,
            'is_liked' => $isLiked,
        ]);
    }
}
