<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficialRequest;
use App\Http\Requests\UpdateOfficialRequest;
use App\Models\Official;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OfficialController extends Controller
{
    public function index(): View
    {
        $officials = Official::orderBy('order', 'asc')->get();
        return view('admin.officials.index', compact('officials'));
    }

    public function reorder(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:officials,id'],
        ]);

        foreach ($request->input('order') as $index => $id) {
            Official::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan susunan perangkat desa berhasil diperbarui.',
        ]);
    }

    public function create(): View
    {
        return view('admin.officials.create');
    }

    public function store(StoreOfficialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (!isset($data['order']) || $data['order'] === null) {
            $data['order'] = (Official::max('order') ?? 0) + 1;
        }

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('officials', 'public');
        }

        Official::create($data);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan!');
    }

    public function edit(Official $official): View
    {
        return view('admin.officials.edit', compact('official'));
    }

    public function update(UpdateOfficialRequest $request, Official $official): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($official->photo_path && Storage::disk('public')->exists($official->photo_path)) {
                Storage::disk('public')->delete($official->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('officials', 'public');
        }

        $official->update($data);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui!');
    }

    public function destroy(Official $official): RedirectResponse
    {
        if ($official->photo_path && Storage::disk('public')->exists($official->photo_path)) {
            Storage::disk('public')->delete($official->photo_path);
        }

        $official->delete();

        return redirect()->route('admin.officials.index')
            ->with('success', 'Data perangkat desa berhasil dihapus!');
    }
}
