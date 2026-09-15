<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlPurifierHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        $query = News::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $newsList = $query->latest()->paginate(10)->withQueryString();

        return view('admin.news.index', compact('newsList', 'categories'));
    }

    public function create(): View
    {
        $categories = NewsCategory::orderBy('name')->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);

        // Sanitasi konten Quill untuk mencegah Stored XSS
        $data['content'] = HtmlPurifierHelper::clean($data['content']);

        // Fallback otomatis excerpt dari konten jika tidak ada input ringkasan
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita baru berhasil ditambahkan!');
    }

    public function edit(News $news): View
    {
        $categories = NewsCategory::orderBy('name')->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();

        // Sanitasi konten Quill untuk mencegah Stored XSS
        $data['content'] = HtmlPurifierHelper::clean($data['content']);

        // Fallback otomatis excerpt dari konten jika tidak ada input ringkasan
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

        if ($news->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        }

        if ($request->hasFile('image')) {
            if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->image_path && Storage::disk('public')->exists($news->image_path)) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
