<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatCategory;
use App\Models\VillageStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageStatController extends Controller
{
    public function index(): View
    {
        $categories = StatCategory::with('stats')->orderBy('order')->get();
        return view('admin.village_stats.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = StatCategory::orderBy('label')->get();
        return view('admin.village_stats.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:village_stat_categories,id'],
            'label'       => ['required', 'string', 'max:255'],
            'value'       => ['required', 'numeric'],
            'year'        => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'sub_group'   => ['nullable', 'string', 'max:100'],
            'order'       => ['nullable', 'integer'],
        ]);

        VillageStat::create($data);

        return redirect()->route('admin.village-stats.index')
            ->with('success', 'Data statistik infografis berhasil ditambahkan!');
    }

    public function edit(VillageStat $villageStat): View
    {
        $categories = StatCategory::orderBy('label')->get();
        return view('admin.village_stats.edit', compact('villageStat', 'categories'));
    }

    public function update(Request $request, VillageStat $villageStat): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:village_stat_categories,id'],
            'label'       => ['required', 'string', 'max:255'],
            'value'       => ['required', 'numeric'],
            'year'        => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'sub_group'   => ['nullable', 'string', 'max:100'],
            'order'       => ['nullable', 'integer'],
        ]);

        $villageStat->update($data);

        return redirect()->route('admin.village-stats.index')
            ->with('success', 'Data statistik infografis berhasil diperbarui!');
    }

    public function destroy(VillageStat $villageStat): RedirectResponse
    {
        $villageStat->delete();

        return redirect()->route('admin.village-stats.index')
            ->with('success', 'Data statistik infografis berhasil dihapus!');
    }
}
