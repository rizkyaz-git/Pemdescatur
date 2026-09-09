<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LetterRequestController extends Controller
{
    /**
     * Display list / search of ready-to-print letter templates
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $query = LetterTemplate::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('requirements', 'like', "%{$search}%");
            });
        }

        $templates = $query->orderBy('name')->get();

        return view('public.layanan.surat.index', compact('templates', 'search'));
    }

    /**
     * Download the ready-to-print template file
     */
    public function downloadTemplate(LetterTemplate $letterTemplate)
    {
        if (!$letterTemplate->file_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($letterTemplate->file_path)) {
            return back()->with('error', 'File template surat belum tersedia untuk diunduh. Silakan hubungi perangkat Desa Catur.');
        }

        $ext = pathinfo($letterTemplate->file_path, PATHINFO_EXTENSION);
        $filename = 'Template_' . \Illuminate\Support\Str::slug($letterTemplate->name, '_') . ($ext ? '.' . $ext : '.doc');
        $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($letterTemplate->file_path);

        return response()->download($fullPath, $filename);
    }

    /**
     * Show form for creating new letter request
     */
    public function create(): View
    {
        $templates = LetterTemplate::all();
        return view('public.layanan.surat.create', compact('templates'));
    }

    /**
     * Store new letter request (guest & logged-in user)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:letter_templates,id',
            'form_data' => 'required|array',
        ]);

        $letterRequest = LetterRequest::create([
            'user_id' => auth()->id(), // null if guest
            'template_id' => $validated['template_id'],
            'form_data' => $request->input('form_data'),
        ]);

        return redirect()->route('warga.letter.show', $letterRequest->id)
                        ->with('success', "Permohonan surat berhasil dikirim! Simpan Nomor Tiket Anda: {$letterRequest->ticket_number}");
    }

    /**
     * Show letter request detail with ticket number
     */
    public function show(LetterRequest $letterRequest): View
    {
        $letterRequest->load('template');
        return view('public.layanan.surat.show', compact('letterRequest'));
    }
}
