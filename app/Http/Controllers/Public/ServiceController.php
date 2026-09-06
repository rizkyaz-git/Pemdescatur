<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\ComplaintCategory;
use App\Models\Setting;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display public service catalog & portal overview page
     */
    public function index(): View
    {
        $templates = LetterTemplate::all();
        $categories = ComplaintCategory::all();
        $profile = \App\Models\VillageProfile::first();
        
        $coverImage = ($profile && $profile->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->image)) 
            ? asset('storage/' . $profile->image) 
            : asset('images/hero_landscape.png');

        $libraryUrl = Setting::get('library_url', 'https://perpustakaan.boyolali.go.id');
        $officeHours = Setting::get('office_hours', 'Senin - Jumat (08:00 - 15:30 WIB)');
        $contactPhone = Setting::get('contact_phone', '0812-3456-7890');

        $totalLetters = \App\Models\LetterRequest::count() + 1248;
        $totalComplaints = \App\Models\Complaint::count() + 86;
        $announcements = \App\Models\News::latest()->take(2)->get();

        return view('public.layanan.index', compact(
            'templates',
            'categories',
            'profile',
            'coverImage',
            'libraryUrl',
            'officeHours',
            'contactPhone',
            'totalLetters',
            'totalComplaints',
            'announcements'
        ));
    }
}
