<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Models\Statistic;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function index(): View
    {
        $statistics = Statistic::orderBy('category')->orderBy('order', 'asc')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create(): View
    {
        return view('admin.statistics.create');
    }

    public function store(StoreStatisticRequest $request): RedirectResponse
    {
        Statistic::create($request->validated());

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Data statistik berhasil ditambahkan!');
    }

    public function edit(Statistic $statistic): View
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(UpdateStatisticRequest $request, Statistic $statistic): RedirectResponse
    {
        $statistic->update($request->validated());

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Data statistik berhasil diperbarui!');
    }

    public function destroy(Statistic $statistic): RedirectResponse
    {
        $statistic->delete();

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Data statistik berhasil dihapus!');
    }
}
