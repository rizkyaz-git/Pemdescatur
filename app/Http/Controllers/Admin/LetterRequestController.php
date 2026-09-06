<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LetterRequestController extends Controller
{
    /**
     * Display a listing of the letter requests.
     */
    public function index(Request $request): View
    {
        $query = LetterRequest::with('user', 'template');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by template
        if ($request->filled('template_id')) {
            $query->where('template_id', $request->input('template_id'));
        }

        // Search by ticket number or user name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ticket_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $requests = $query->latest()->paginate(15);
        $templates = LetterTemplate::all();

        return view('admin.letter-requests.index', compact('requests', 'templates'));
    }

    /**
     * Show the form for editing the specified request (process).
     */
    public function edit(LetterRequest $letterRequest): View
    {
        $letterRequest->load('user', 'template');
        return view('admin.letter-requests.edit', ['request' => $letterRequest]);
    }

    /**
     * Update (approve/reject) the specified request.
     */
    public function update(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
            'result_file_path' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('result_file_path')) {
            $file = $request->file('result_file_path');
            $filename = $letterRequest->ticket_number . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('letters', $filename, 'public');
            $validated['result_file_path'] = $path;
        }

        $validated['processed_at'] = now();
        $letterRequest->update($validated);

        $status_label = $validated['status'] === 'approved' ? 'disetujui' : 'ditolak';

        return redirect()->route('admin.letter-requests.index')
                        ->with('success', "Permohonan surat berhasil {$status_label}.");
    }

    /**
     * Show the specified request.
     */
    public function show(LetterRequest $letterRequest): View
    {
        $letterRequest->load('user', 'template');
        return view('admin.letter-requests.show', ['request' => $letterRequest]);
    }
}
