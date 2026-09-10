<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ComplaintController extends Controller
{
    /**
     * Display list / search of complaints
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $selectedCategory = $request->input('kategori');
        $selectedStatus = $request->input('status');

        $query = Complaint::with('category');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
                
                // Also search by ID if user typed ticket number like PGD-202609-00001 or just digits
                if (preg_match('/(\d+)$/', $search, $matches)) {
                    $q->orWhere('id', intval($matches[1]));
                }
            });
        }

        if (!empty($selectedCategory)) {
            $query->where('category_id', $selectedCategory);
        }

        if (!empty($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $complaints = $query->latest()->paginate(9)->withQueryString();
        $categories = ComplaintCategory::all();

        return view('public.layanan.pengaduan.index', compact('complaints', 'categories', 'search', 'selectedCategory', 'selectedStatus'));
    }

    /**
     * Show form for creating new complaint
     */
    public function create(): View
    {
        $categories = ComplaintCategory::all();
        return view('public.layanan.pengaduan.create', compact('categories'));
    }

    /**
     * Store new complaint (guest & logged-in user)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $attachment_path = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachment_path = $file->storeAs('complaints', uniqid() . '.' . $file->getClientOriginalExtension(), 'public');
        }

        $complaint = Complaint::create([
            'user_id' => auth()->id(), // null if guest
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'attachment_path' => $attachment_path,
            'status' => 'new',
        ]);

        return redirect()->route('warga.complaint.show', $complaint->id)
                        ->with('success', "Pengaduan berhasil dikirim! Laporan Anda telah tercatat dan akan segera ditindaklanjuti.");
    }

    /**
     * Show complaint detail
     */
    public function show(Complaint $complaint): View
    {
        $complaint->load('category');
        return view('public.layanan.pengaduan.show', compact('complaint'));
    }
}
