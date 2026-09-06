<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Illuminate\View\View;

class OfficialController extends Controller
{
    public function index(): View
    {
        // Get all officials ordered by order ASC
        $officials = Official::orderBy('order', 'asc')->get();

        // Identify Head Official (Kepala Desa / Perbekel)
        $headOfficial = $officials->first(function ($official) {
            return str_contains(strtolower($official->position), 'kepala') || 
                   str_contains(strtolower($official->position), 'perbekel');
        }) ?? $officials->first();

        // Other officials excluding the head official
        $otherOfficials = $headOfficial 
            ? $officials->reject(fn($o) => $o->id === $headOfficial->id) 
            : $officials;

        return view('public.officials', compact('officials', 'headOfficial', 'otherOfficials'));
    }
}
