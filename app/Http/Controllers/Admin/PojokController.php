<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\Pojok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PojokController extends Controller
{
    /**
     * Display a listing of 5 Pojok Pemberdayaan.
     */
    public function index(): View
    {
        $pojoks = Pojok::withCount(['kegiatans', 'kurikulums'])
            ->with(['kurikulums' => fn($q) => $q->latest()])
            ->orderBy('id')
            ->get();

        return view('admin.pojoks.index', compact('pojoks'));
    }

    /**
     * Show the form for editing the specified Pojok and managing its kurikulum.
     */
    public function edit(Pojok $pojok): View
    {
        $pojok->load(['kurikulums.uploader', 'kegiatans' => fn($q) => $q->latest('tanggal_kegiatan')]);

        return view('admin.pojoks.edit', compact('pojok'));
    }

    /**
     * Update the specified Pojok info.
     */
    public function update(Request $request, Pojok $pojok): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi_singkat' => ['required', 'string'],
        ], [
            'nama.required' => 'Nama Pojok wajib diisi.',
            'deskripsi_singkat.required' => 'Deskripsi singkat Pojok wajib diisi.',
        ]);

        $pojok->update($validated);

        return back()->with('success', 'Deskripsi ' . $pojok->nama . ' berhasil diperbarui.');
    }

    /**
     * Store a new curriculum document for the Pojok.
     */
    public function storeKurikulum(Request $request, Pojok $pojok): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip,rar', 'max:15360'],
        ], [
            'judul.required' => 'Judul modul/kurikulum wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'file.required' => 'File kurikulum wajib diunggah.',
            'file.mimes' => 'Format file yang didukung: PDF, DOC, DOCX, PPT, PPTX, ZIP, RAR.',
            'file.max' => 'Ukuran file kurikulum maksimal 15MB.',
        ]);

        $uploadedFile = $request->file('file');
        $filePath = $uploadedFile->store('ppko/kurikulum', 'public');

        $pojok->kurikulums()->create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_path' => $filePath,
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_size' => $uploadedFile->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Kurikulum "' . $validated['judul'] . '" berhasil ditambahkan ke ' . $pojok->nama . '.');
    }

    /**
     * Remove the specified curriculum document from storage and database.
     */
    public function destroyKurikulum(Kurikulum $kurikulum): RedirectResponse
    {
        $pojokNama = $kurikulum->pojok->nama ?? 'Pojok';

        if ($kurikulum->file_path && Storage::disk('public')->exists($kurikulum->file_path)) {
            Storage::disk('public')->delete($kurikulum->file_path);
        }

        $kurikulum->delete();

        return back()->with('success', 'Kurikulum berhasil dihapus dari ' . $pojokNama . '.');
    }

    /**
     * Update the photo/image for the specified Pojok directly.
     */
    public function updateFoto(Request $request, Pojok $pojok): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'foto.required' => 'Pilih file foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar yang didukung: JPG, PNG, WEBP.',
            'foto.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($pojok->gambar && Storage::disk('public')->exists($pojok->gambar)) {
            Storage::disk('public')->delete($pojok->gambar);
        }

        $path = $request->file('foto')->store('ppko/pojok', 'public');
        $pojok->update(['gambar' => $path]);

        return back()->with('success', 'Foto ' . $pojok->nama . ' berhasil diperbarui.');
    }
}
