<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LetterTemplateController extends Controller
{
    /**
     * Display a listing of the letter templates.
     */
    public function index(): View
    {
        $templates = LetterTemplate::withCount('requests')
                                   ->paginate(15);

        return view('admin.letter-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create(): View
    {
        return view('admin.letter-templates.create');
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:letter_templates|max:50',
            'template_text' => 'required|string',
            'description' => 'nullable|string',
        ]);

        LetterTemplate::create($validated);

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'Template surat berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(LetterTemplate $letterTemplate): View
    {
        return view('admin.letter-templates.edit', ['template' => $letterTemplate]);
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, LetterTemplate $letterTemplate): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:letter_templates,code,' . $letterTemplate->id . '|max:50',
            'template_text' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $letterTemplate->update($validated);

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'Template surat berhasil diperbarui.');
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(LetterTemplate $letterTemplate): RedirectResponse
    {
        $letterTemplate->delete();

        return redirect()->route('admin.letter-templates.index')
                        ->with('success', 'Template surat berhasil dihapus.');
    }
}
