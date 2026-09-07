<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\Pojok;
use App\Models\PpkoProgramDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PpkoSettingController extends Controller
{
    /**
     * Display a dashboard listing of the 5 Pojok Pemberdayaan & Program Details.
     */
    public function index(): View
    {
        $pojoks = Pojok::withCount(['kurikulums'])
            ->with(['kurikulums' => fn($q) => $q->latest()])
            ->orderBy('id')
            ->get();

        $programDetails = PpkoProgramDetail::orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('admin.ppko.index', compact('pojoks', 'programDetails'));
    }

    /**
     * Show the management form for a specific Pojok (cover photo, downloadable files, details).
     */
    public function edit(Pojok $pojok): View
    {
        $pojok->load(['kurikulums' => fn($q) => $q->latest()]);

        return view('admin.ppko.edit', compact('pojok'));
    }

    /**
     * Update the name and brief description of the Pojok.
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

        return back()->with('success', 'Informasi ' . $pojok->nama . ' berhasil diperbarui.');
    }

    /**
     * Update or upload the cover photo for the Pojok.
     */
    public function updateFoto(Request $request, Pojok $pojok): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'foto.required' => 'Silakan pilih file foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar yang didukung: JPG, PNG, WEBP.',
            'foto.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($pojok->gambar && Storage::disk('public')->exists($pojok->gambar)) {
            Storage::disk('public')->delete($pojok->gambar);
        }

        $path = $request->file('foto')->store('ppko/pojok', 'public');
        $pojok->update(['gambar' => $path]);

        return back()->with('success', 'Foto sampul ' . $pojok->nama . ' berhasil diperbarui.');
    }

    /**
     * Delete the custom cover photo and revert to default.
     */
    public function deleteFoto(Pojok $pojok): RedirectResponse
    {
        if ($pojok->gambar && Storage::disk('public')->exists($pojok->gambar)) {
            Storage::disk('public')->delete($pojok->gambar);
        }

        $pojok->update(['gambar' => null]);

        return back()->with('success', 'Foto sampul ' . $pojok->nama . ' berhasil direset ke foto bawaan.');
    }

    /**
     * Store a new downloadable file for the Pojok (complete with name, description, and document).
     */
    public function storeFile(Request $request, Pojok $pojok): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar', 'max:51200'],
        ], [
            'judul.required' => 'Nama / Judul file unduhan wajib diisi.',
            'judul.max' => 'Nama file maksimal 255 karakter.',
            'file.required' => 'File dokumen wajib diunggah.',
            'file.mimes' => 'Format file yang didukung: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR.',
            'file.max' => 'Ukuran file dokumen maksimal 50MB.',
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

        return back()->with('success', 'File unduhan "' . $validated['judul'] . '" berhasil ditambahkan ke ' . $pojok->nama . '.');
    }

    /**
     * Remove the specified downloadable file from storage and database.
     */
    public function destroyFile(Kurikulum $kurikulum): RedirectResponse
    {
        $pojokNama = $kurikulum->pojok->nama ?? 'Pojok';
        $judulFile = $kurikulum->judul;

        if ($kurikulum->file_path && Storage::disk('public')->exists($kurikulum->file_path)) {
            Storage::disk('public')->delete($kurikulum->file_path);
        }

        $kurikulum->delete();

        return back()->with('success', 'File unduhan "' . $judulFile . '" berhasil dihapus dari ' . $pojokNama . '.');
    }

    /**
     * Store a new detail program entry.
     */
    public function storeProgramDetail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aspek' => ['required', 'string', 'max:150'],
            'keterangan' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'aspek.required' => 'Nama aspek/program wajib diisi.',
            'aspek.max' => 'Nama aspek maksimal 150 karakter.',
            'keterangan.required' => 'Keterangan detail program wajib diisi.',
        ]);

        PpkoProgramDetail::create([
            'aspek' => $validated['aspek'],
            'keterangan' => $validated['keterangan'],
            'urutan' => $validated['urutan'] ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Baris detail program "' . $validated['aspek'] . '" berhasil ditambahkan.');
    }

    /**
     * Update the specified detail program entry.
     */
    public function updateProgramDetail(Request $request, PpkoProgramDetail $detail): RedirectResponse
    {
        $validated = $request->validate([
            'aspek' => ['required', 'string', 'max:150'],
            'keterangan' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'aspek.required' => 'Nama aspek/program wajib diisi.',
            'aspek.max' => 'Nama aspek maksimal 150 karakter.',
            'keterangan.required' => 'Keterangan detail program wajib diisi.',
        ]);

        $detail->update([
            'aspek' => $validated['aspek'],
            'keterangan' => $validated['keterangan'],
            'urutan' => $validated['urutan'] ?? $detail->urutan,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return back()->with('success', 'Detail program "' . $detail->aspek . '" berhasil diperbarui.');
    }

    /**
     * Remove the specified detail program entry.
     */
    public function destroyProgramDetail(PpkoProgramDetail $detail): RedirectResponse
    {
        $aspek = $detail->aspek;
        $detail->delete();

        return back()->with('success', 'Detail program "' . $aspek . '" berhasil dihapus.');
    }
}
