<?php

namespace App\Http\Controllers\Admin;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FamilyController
{
    /**
     * Display a listing of families
     */
    public function index(): View
    {
        $families = Family::with('residents')->paginate(15);
        return view('admin.families.index', compact('families'));
    }

    /**
     * Show the form for creating a new family
     */
    public function create(): View
    {
        return view('admin.families.create');
    }

    /**
     * Store a newly created family
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kk_number' => 'required|string|unique:families',
            'head_of_family' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        Family::create($validated);

        return redirect()->route('admin.families.index')
            ->with('success', 'Keluarga berhasil ditambahkan.');
    }

    /**
     * Show the form for editing family
     */
    public function edit(Family $family): View
    {
        return view('admin.families.edit', compact('family'));
    }

    /**
     * Update the family
     */
    public function update(Request $request, Family $family): RedirectResponse
    {
        $validated = $request->validate([
            'kk_number' => 'required|string|unique:families,kk_number,' . $family->id,
            'head_of_family' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $family->update($validated);

        return redirect()->route('admin.families.index')
            ->with('success', 'Keluarga berhasil diperbarui.');
    }

    /**
     * Delete the family
     */
    public function destroy(Family $family): RedirectResponse
    {
        $family->delete();

        return redirect()->route('admin.families.index')
            ->with('success', 'Keluarga dan anggotanya berhasil dihapus.');
    }
}
