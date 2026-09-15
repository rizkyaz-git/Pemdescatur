<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:news_categories,name'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori dengan nama ini sudah ada.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category = NewsCategory::create([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['name']),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'category' => $category,
            ]);
        }

        return redirect()->back()->with('success', 'Kategori "' . $category->name . '" berhasil ditambahkan!');
    }

    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        $isUsed = News::where('category', $newsCategory->name)->exists();

        if ($isUsed) {
            return redirect()->back()->with('error', 'Kategori "' . $newsCategory->name . '" tidak dapat dihapus karena masih digunakan oleh berita.');
        }

        $newsCategory->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
