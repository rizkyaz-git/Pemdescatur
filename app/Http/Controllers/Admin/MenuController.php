<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::with('parent')->orderBy('order', 'asc')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        $parents = Menu::orderBy('label', 'asc')->get();
        return view('admin.menus.create', compact('parents'));
    }

    public function store(StoreMenuRequest $request): RedirectResponse
    {
        Menu::create($request->validated());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Item menu baru berhasil ditambahkan!');
    }

    public function edit(Menu $menu): View
    {
        $parents = Menu::where('id', '!=', $menu->id)->orderBy('label', 'asc')->get();
        return view('admin.menus.edit', compact('menu', 'parents'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $menu->update($request->validated());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Item menu berhasil diperbarui!');
    }

    public function toggleActive(Menu $menu): RedirectResponse
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Status visibilitas menu berhasil diubah!');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Item menu berhasil dihapus!');
    }
}
