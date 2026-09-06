<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resident;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ResidentController
{
    /**
     * Display a listing of residents
     */
    public function index(Request $request): View
    {
        $query = Resident::with('family');

        // Search by NIK, name, or KK number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('family', function ($fq) use ($search) {
                      $fq->where('kk_number', 'like', "%{$search}%");
                  });
            });
        }

        $residents = $query->paginate(15);
        return view('admin.residents.index', compact('residents'));
    }

    /**
     * Show the form for creating a new resident
     */
    public function create(): View
    {
        $families = Family::all();
        return view('admin.residents.create', compact('families'));
    }

    /**
     * Store a newly created resident
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'family_id' => 'required|exists:families,id',
            'nik' => 'required|string|unique:residents',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'relationship_to_head' => 'nullable|string|max:100',
            'status' => 'required|in:hidup,meninggal,pindah',
        ]);

        Resident::create($validated);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Penduduk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing resident
     */
    public function edit(Resident $resident): View
    {
        $families = Family::all();
        return view('admin.residents.edit', compact('resident', 'families'));
    }

    /**
     * Update the resident
     */
    public function update(Request $request, Resident $resident): RedirectResponse
    {
        $validated = $request->validate([
            'family_id' => 'required|exists:families,id',
            'nik' => 'required|string|unique:residents,nik,' . $resident->id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'relationship_to_head' => 'nullable|string|max:100',
            'status' => 'required|in:hidup,meninggal,pindah',
        ]);

        $resident->update($validated);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Penduduk berhasil diperbarui.');
    }

    /**
     * Delete the resident
     */
    public function destroy(Resident $resident): RedirectResponse
    {
        $resident->delete();

        return redirect()->route('admin.residents.index')
            ->with('success', 'Penduduk berhasil dihapus.');
    }

    /**
     * Search residents via API (for autocomplete)
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->query('q', '');

        $residents = Resident::where('status', 'hidup')
            ->where(function ($query) use ($search) {
                $query->where('nik', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'nik', 'name', 'family_id']);

        return response()->json($residents);
    }
}
