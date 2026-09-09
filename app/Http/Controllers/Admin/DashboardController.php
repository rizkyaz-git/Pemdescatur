<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Official;
use App\Models\LetterTemplate;
use App\Models\Complaint;
use App\Models\Pojok;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'news_count' => News::count(),
            'officials_count' => Official::count(),
            'galleries_count' => Gallery::count(),
            'letter_templates_count' => LetterTemplate::count(),
            'new_complaints_count' => Complaint::where('status', 'new')->count(),
            'users_count' => User::count(),
            'pojoks_count' => class_exists(Pojok::class) ? Pojok::count() : 4,
        ];

        $latestNews = News::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNews'));
    }
}
