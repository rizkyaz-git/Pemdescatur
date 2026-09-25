<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LetterRequestController extends Controller
{
    /**
     * Display letter requests in the unfinished or completed tab.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->input('tab') === 'riwayat' ? 'riwayat' : 'baru';
        $query = LetterRequest::with('user', 'template');

        if ($activeTab === 'riwayat') {
            $query->completed();
        } else {
            $query->unfinished();
        }

        if ($request->filled('template_id')) {
            $templateId = $request->input('template_id');

            if ($templateId === 'lainnya') {
                $otherTemplate = LetterTemplate::where('name', 'Lainnya')->first();
                $otherId = $otherTemplate?->id ?? 0;

                $query->where(function ($q) use ($otherId) {
                    $q->where('template_id', $otherId)
                        ->orWhereNotNull('form_data->jenis_surat_lainnya');
                });
            } else {
                $query->where('template_id', $templateId);
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('form_data->nama', 'like', "%{$search}%")
                    ->orWhere('form_data->nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('form_data->telepon', 'like', "%{$search}%")
                    ->orWhere('form_data->nik', 'like', "%{$search}%")
                    ->orWhere('form_data->jenis_surat_lainnya', 'like', "%{$search}%")
                    ->orWhereHas('template', function ($templateQuery) use ($search) {
                        $templateQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $paginationParams = array_filter([
            'tab' => $activeTab,
            'search' => $request->input('search'),
            'template_id' => $request->input('template_id'),
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        $requests = $query->latest()->paginate(15)->appends($paginationParams);
        $templates = LetterTemplate::orderBy('name')->get();

        return view('admin.letter-requests.index', compact('requests', 'templates', 'activeTab'));
    }

    /**
     * Store a newly created letter type directly from the requests page
     * without requiring an uploaded template file.
     */
    public function storeType(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:letter_templates,name',
            'code' => 'nullable|string|max:50',
            'requirements' => 'nullable|string',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama jenis surat wajib diisi.',
            'name.unique' => 'Jenis surat dengan nama ini sudah terdaftar.',
            'name.max' => 'Nama jenis surat maksimal 255 karakter.',
            'code.max' => 'Kode singkatan maksimal 50 karakter.',
        ]);

        $letterType = LetterTemplate::create([
            'name' => trim($validated['name']),
            'code' => !empty($validated['code']) ? strtoupper(trim($validated['code'])) : null,
            'requirements' => !empty($validated['requirements']) ? trim($validated['requirements']) : null,
            'description' => !empty($validated['description']) ? trim($validated['description']) : null,
            'file_path' => null,
        ]);

        return redirect()->route('admin.letter-requests.index')
            ->with('success', "Jenis surat '{$letterType->name}' berhasil ditambahkan dan langsung aktif di formulir pengajuan warga.");
    }

    /**
     * Mark a letter request as completed using the shared admin workflow.
     */
    public function complete(LetterRequest $letterRequest): RedirectResponse
    {
        if ($letterRequest->isCompleted()) {
            return redirect()->route('admin.letter-requests.index', ['tab' => 'riwayat'])
                ->with('success', 'Permohonan ini sudah berada di Riwayat.');
        }

        $letterRequest->markCompleted();

        return redirect()->route('admin.letter-requests.index', ['tab' => 'riwayat'])
            ->with('success', 'Permohonan surat berhasil ditandai selesai.');
    }

    /**
     * Delete a completed letter request.
     */
    public function destroy(LetterRequest $letterRequest): RedirectResponse
    {
        if (! $letterRequest->isCompleted()) {
            return redirect()->route('admin.letter-requests.index', ['tab' => 'baru'])
                ->with('error', 'Hanya permohonan yang sudah selesai yang dapat dihapus.');
        }

        $letterRequest->delete();

        return redirect()->route('admin.letter-requests.index', ['tab' => 'riwayat'])
            ->with('success', 'Permohonan selesai berhasil dihapus.');
    }

    /**
     * Show the submitted letter request details.
     */
    public function show(LetterRequest $letterRequest): View
    {
        $letterRequest->load('template');

        return view('admin.letter-requests.show', ['request' => $letterRequest]);
    }
}
