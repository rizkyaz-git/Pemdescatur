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
     * Display list / search of letter requests
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $query = LetterRequest::with('template');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('form_data', 'like', "%{$search}%");
            });
        } elseif (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            // For guest with no search, show empty or recent public tickets
            $query->whereNull('user_id');
        }

        $requests = $query->latest()->paginate(10)->withQueryString();
        $templates = LetterTemplate::all();

        return view('public.layanan.surat.index', compact('requests', 'templates', 'search'));
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
