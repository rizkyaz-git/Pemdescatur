<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints.
     */
    public function index(Request $request): View
    {
        $query = Complaint::with('user', 'category');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $complaints = $query->latest()->paginate(15);
        $categories = ComplaintCategory::all();

        return view('admin.complaints.index', compact('complaints', 'categories'));
    }

    /**
     * Show the specified complaint.
     */
    public function show(Complaint $complaint): View
    {
        $complaint->load('user', 'category');
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit(Complaint $complaint): View
    {
        $complaint->load('user', 'category');
        return view('admin.complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified complaint.
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,processing,resolved',
            'admin_response' => 'nullable|string',
        ]);

        if ($validated['status'] === 'resolved' && $validated['admin_response']) {
            $validated['responded_at'] = now();
        }

        $complaint->update($validated);

        return redirect()->route('admin.complaints.index')
                        ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified complaint.
     */
    public function destroy(Complaint $complaint): RedirectResponse
    {
        $complaint->delete();

        return redirect()->route('admin.complaints.index')
                        ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
