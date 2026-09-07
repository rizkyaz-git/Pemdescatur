<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGaleriFotoRequest;
use App\Models\GaleriFoto;
use App\Models\Kegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GaleriFotoController extends Controller
{
    /**
     * Store newly uploaded photos for a specific kegiatan.
     */
    public function store(StoreGaleriFotoRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $uploadedCount = 0;

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('ppko/galeri', 'public');

                $kegiatan->galeriFotos()->create([
                    'file_path' => $path,
                    'caption' => $request->input('caption'),
                    'uploaded_by' => auth()->id(),
                ]);

                $uploadedCount++;
            }
        }

        return back()->with('success', "Berhasil menambahkan {$uploadedCount} foto ke galeri dokumentasi kegiatan.");
    }

    /**
     * Remove the specified gallery photo from storage.
     */
    public function destroy(GaleriFoto $foto): RedirectResponse
    {
        if ($foto->file_path && Storage::disk('public')->exists($foto->file_path)) {
            Storage::disk('public')->delete($foto->file_path);
        }

        $foto->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
