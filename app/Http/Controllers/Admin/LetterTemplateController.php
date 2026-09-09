<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LetterTemplateController extends Controller
{
    /**
     * Display a listing of ready-to-print letter templates.
     */
    public function index(): View
    {
        $templates = LetterTemplate::latest()->paginate(15);
        return view('admin.letter-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new ready-to-print letter template.
     */
    public function create(): View
    {
        return view('admin.letter-templates.create');
    }

    /**
     * Store a newly created ready-to-print letter template in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:doc,docx,pdf,rtf,odt|max:25600',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
        ], [
            'name.required' => 'Nama template surat wajib diisi.',
            'file.required' => 'File template surat siap cetak wajib diunggah.',
            'file.mimes' => 'Format file harus berupa DOC, DOCX, PDF, RTF, atau ODT.',
            'file.max' => 'Ukuran file maksimal 25 MB.',
        ]);

        $filePath = $request->file('file')->store('letter_templates', 'public');

        LetterTemplate::create([
            'name' => $validated['name'],
            'code' => null,
            'file_path' => $filePath,
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
        ]);

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'File template surat siap cetak berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified ready-to-print letter template.
     */
    public function edit(LetterTemplate $letterTemplate): View
    {
        return view('admin.letter-templates.edit', ['template' => $letterTemplate]);
    }

    /**
     * Update the specified ready-to-print letter template in storage.
     */
    public function update(Request $request, LetterTemplate $letterTemplate): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:doc,docx,pdf,rtf,odt|max:25600',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
        ], [
            'name.required' => 'Nama template surat wajib diisi.',
            'file.mimes' => 'Format file harus berupa DOC, DOCX, PDF, RTF, atau ODT.',
            'file.max' => 'Ukuran file maksimal 25 MB.',
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
        ];

        if ($request->hasFile('file')) {
            if ($letterTemplate->file_path && Storage::disk('public')->exists($letterTemplate->file_path)) {
                Storage::disk('public')->delete($letterTemplate->file_path);
            }
            $data['file_path'] = $request->file('file')->store('letter_templates', 'public');
        }

        $letterTemplate->update($data);

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'Template surat siap cetak berhasil diperbarui.');
    }

    /**
     * Remove the specified ready-to-print letter template and its file.
     */
    public function destroy(LetterTemplate $letterTemplate): RedirectResponse
    {
        if ($letterTemplate->file_path && Storage::disk('public')->exists($letterTemplate->file_path)) {
            Storage::disk('public')->delete($letterTemplate->file_path);
        }

        $letterTemplate->delete();

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'Template surat berhasil dihapus.');
    }
}
