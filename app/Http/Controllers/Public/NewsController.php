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

        $newsList = $query->paginate(12)->withQueryString();
        $categories = News::where('status', 'published')->distinct()->pluck('category')->filter()->values();

        // 1. Berita Disarankan (Acak per sesi)
        $suggestedIds = session()->get('suggested_news_ids', []);
        if (!is_array($suggestedIds) || empty($suggestedIds)) {
            $suggestedIds = News::where('status', 'published')
                ->inRandomOrder()
                ->take(3)
                ->pluck('id')
                ->toArray();
            session()->put('suggested_news_ids', $suggestedIds);
        }

        $suggestedNews = News::where('status', 'published')
            ->whereIn('id', $suggestedIds)
            ->get();

        if ($suggestedNews->count() > 0) {
            $suggestedNews = $suggestedNews->sortBy(function ($item) use ($suggestedIds) {
                return array_search($item->id, $suggestedIds);
            })->values();
        }

        if ($suggestedNews->count() < 3) {
            $fallbackSuggested = News::where('status', 'published')
                ->whereNotIn('id', $suggestedNews->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(3 - $suggestedNews->count())
                ->get();
            $suggestedNews = $suggestedNews->concat($fallbackSuggested);
        }

        // 2. Berita Utama (Dapat di-set admin via pengaturan/tabel berita)
        $featuredId = \App\Models\Setting::get('featured_news_id');
        $latestNews = null;
        if ($featuredId) {
            $latestNews = News::where('status', 'published')->find($featuredId);
        }
        if (!$latestNews) {
            $latestNews = News::where('status', 'published')
                ->orderBy('published_at', 'desc')
                ->first();
        }

        // 3. Berita Sering Dilihat (Bagian kanan, urut views_count)
        $popularNews = News::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $weather = app(\App\Services\BmkgWeatherService::class)->getCurrentWeather();

        return view('public.news.index', compact('newsList', 'categories', 'suggestedNews', 'latestNews', 'popularNews', 'weather'));
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

        // Fetch up to 4 related news (same category first, backfill with latest if needed)
        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->when($news->category, function ($query, $cat) {
                return $query->where('category', $cat);
            })
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        if ($relatedNews->count() < 4) {
            $fallback = News::where('status', 'published')
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(4 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->concat($fallback);
        }

        // Fetch 5 recent news for sidebar
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

        return view('public.news.show', compact('news', 'relatedNews', 'recentNews', 'categories'));
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
