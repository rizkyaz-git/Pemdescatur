<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use App\Models\Pojok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Kegiatan::with(['pojok', 'creator'])
            ->withCount('galeriFotos')
            ->latest('tanggal_kegiatan');

        if ($request->filled('pojok_id')) {
            $query->where('pojok_id', $request->pojok_id);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $kegiatans = $query->paginate(10)->withQueryString();
        $pojoks = Pojok::orderBy('id')->get();

        return view('admin.kegiatans.index', compact('kegiatans', 'pojoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pojoks = Pojok::orderBy('id')->get();

        return view('admin.kegiatans.create', compact('pojoks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKegiatanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('ppko/kegiatans', 'public');
        }

        $kegiatan = Kegiatan::create($data);

        return redirect()
            ->route('admin.kegiatans.show', $kegiatan)
            ->with('success', 'Kegiatan PPKO berhasil ditambahkan! Anda sekarang dapat menambahkan foto dokumentasi ke galeri kegiatan.');
    }

    /**
     * Display the specified resource with its gallery.
     */
    public function show(Kegiatan $kegiatan): View
    {
        $kegiatan->load(['pojok', 'creator', 'galeriFotos.uploader']);

        return view('admin.kegiatans.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan): View
    {
        $pojoks = Pojok::orderBy('id')->get();

        return view('admin.kegiatans.edit', compact('kegiatan', 'pojoks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($kegiatan->thumbnail && Storage::disk('public')->exists($kegiatan->thumbnail)) {
                Storage::disk('public')->delete($kegiatan->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('ppko/kegiatans', 'public');
        }

        $kegiatan->update($data);

        return redirect()
            ->route('admin.kegiatans.index')
            ->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        // Delete thumbnail if exists
        if ($kegiatan->thumbnail && Storage::disk('public')->exists($kegiatan->thumbnail)) {
            Storage::disk('public')->delete($kegiatan->thumbnail);
        }

        // Delete all associated gallery photo files
        foreach ($kegiatan->galeriFotos as $foto) {
            if ($foto->file_path && Storage::disk('public')->exists($foto->file_path)) {
                Storage::disk('public')->delete($foto->file_path);
            }
        }

        $kegiatan->delete();

        return redirect()
            ->route('admin.kegiatans.index')
            ->with('success', 'Kegiatan beserta seluruh dokumentasi galeri berhasil dihapus.');
    }
}
