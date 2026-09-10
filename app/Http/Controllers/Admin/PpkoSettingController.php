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
     * Show the management form for a specific Pojok (redirects to tabbed index).
     */
    public function edit(Pojok $pojok): RedirectResponse
    {
        return redirect()->route('admin.ppko.index', ['tab' => $pojok->id]);
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

        return redirect()->route('admin.ppko.index', ['tab' => $pojok->id])
            ->with('success', 'Informasi ' . $pojok->nama . ' berhasil diperbarui.');
    }

    /**
     * Update or upload the cover photo & description for the Pojok (supports slot 1, 2, 3).
     */
    public function updateFoto(Request $request, Pojok $pojok): RedirectResponse
    {
        $slot = (int) $request->input('slot', 1);
        $field = match($slot) {
            2 => 'gambar_2',
            3 => 'gambar_3',
            default => 'gambar',
        };
        $descField = match($slot) {
            2 => 'deskripsi_gambar_2',
            3 => 'deskripsi_gambar_3',
            default => 'deskripsi_gambar',
        };

        $request->validate([
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar yang didukung: JPG, PNG, WEBP.',
            'foto.max' => 'Ukuran gambar maksimal 5MB.',
            'deskripsi.max' => 'Deskripsi gambar maksimal 500 karakter.',
        ]);

        $updates = [];

        if ($request->hasFile('foto')) {
            if ($pojok->$field && Storage::disk('public')->exists($pojok->$field)) {
                Storage::disk('public')->delete($pojok->$field);
            }

            $path = $request->file('foto')->store('ppko/pojok', 'public');
            $updates[$field] = $path;
        }

        if ($request->has('deskripsi')) {
            $updates[$descField] = $request->input('deskripsi');
        }

        if (empty($updates)) {
            return redirect()->route('admin.ppko.index', ['tab' => $pojok->id])
                ->withErrors(['foto' => 'Silakan pilih file foto atau isi deskripsi gambar terlebih dahulu.']);
        }

        $pojok->update($updates);

        $slotLabel = $slot > 1 ? " (Foto ke-{$slot})" : " (Foto ke-1)";
        return redirect()->route('admin.ppko.index', ['tab' => $pojok->id])
            ->with('success', 'Foto dan deskripsi ' . $pojok->nama . $slotLabel . ' berhasil disimpan.');
    }

    /**
     * Delete the custom photo and set slot to empty.
     */
    public function deleteFoto(Request $request, Pojok $pojok): RedirectResponse
    {
        $slot = (int) $request->input('slot', 1);
        $field = match($slot) {
            2 => 'gambar_2',
            3 => 'gambar_3',
            default => 'gambar',
        };
        $descField = match($slot) {
            2 => 'deskripsi_gambar_2',
            3 => 'deskripsi_gambar_3',
            default => 'deskripsi_gambar',
        };

        if ($pojok->$field && Storage::disk('public')->exists($pojok->$field)) {
            Storage::disk('public')->delete($pojok->$field);
        }

        $pojok->update([
            $field => null,
            $descField => null,
        ]);

        $slotLabel = $slot > 1 ? " foto ke-{$slot}" : " foto ke-1";
        return redirect()->route('admin.ppko.index', ['tab' => $pojok->id])
            ->with('success', 'Foto ' . $pojok->nama . $slotLabel . ' berhasil dihapus.');
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

        return redirect()->route('admin.ppko.index', ['tab' => $pojok->id])
            ->with('success', 'File unduhan "' . $validated['judul'] . '" berhasil ditambahkan ke ' . $pojok->nama . '.');
    }

    /**
     * Remove the specified downloadable file from storage and database.
     */
    public function destroyFile(Kurikulum $kurikulum): RedirectResponse
    {
        $pojokId = $kurikulum->pojok_id;
        $pojokNama = $kurikulum->pojok->nama ?? 'Pojok';
        $judulFile = $kurikulum->judul;

        if ($kurikulum->file_path && Storage::disk('public')->exists($kurikulum->file_path)) {
            Storage::disk('public')->delete($kurikulum->file_path);
        }

        $kurikulum->delete();

        return redirect()->route('admin.ppko.index', ['tab' => $pojokId])
            ->with('success', 'File unduhan "' . $judulFile . '" berhasil dihapus dari ' . $pojokNama . '.');
    }

    /**
     * Store a new detail program entry (Super Admin only).
     */
    public function storeProgramDetail(Request $request): RedirectResponse
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Bagian pengeditan Tabel Detail Program PPKO hanya dapat diakses oleh Super Admin.');
        }

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
     * Update the specified detail program entry (Super Admin only).
     */
    public function updateProgramDetail(Request $request, PpkoProgramDetail $detail): RedirectResponse
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Bagian pengeditan Tabel Detail Program PPKO hanya dapat diakses oleh Super Admin.');
        }

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
     * Remove the specified detail program entry (Super Admin only).
     */
    public function destroyProgramDetail(PpkoProgramDetail $detail): RedirectResponse
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Bagian pengeditan Tabel Detail Program PPKO hanya dapat diakses oleh Super Admin.');
        }

        $aspek = $detail->aspek;
        $detail->delete();

        return back()->with('success', 'Detail program "' . $aspek . '" berhasil dihapus.');
    }
}
