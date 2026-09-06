<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Official;
use App\Models\Statistic;
use App\Models\Resident;
use App\Models\Family;
use App\Models\LetterRequest;
use App\Models\Complaint;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'news_count' => News::count(),
            'officials_count' => Official::count(),
            'statistics_count' => Statistic::count(),
            'galleries_count' => Gallery::count(),
            'residents_count' => Resident::count(),
            'families_count' => Family::count(),
            'pending_letters_count' => LetterRequest::where('status', 'pending')->count(),
            'new_complaints_count' => Complaint::where('status', 'new')->count(),
        ];

        $latestNews = News::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNews'));
    }
}
