<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    /**
     * Live search suggestion API for AJAX dropdown.
     */
    public function api(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json([
                'query' => $q,
                'total' => 0,
                'results' => []
            ]);
        }

        $results = $this->searchService->search($q, 8);
        $total = count($results);

        return response()->json([
            'query' => $q,
            'total' => $total,
            'results' => array_slice($results, 0, 8)
        ]);
    }

    /**
     * Dedicated full search results page.
     */
    public function index(Request $request): View
    {
        $q = trim($request->get('q', ''));
        $results = [];
        
        if (mb_strlen($q) >= 2) {
            $results = $this->searchService->search($q, 40);
        }

        return view('public.search', [
            'query' => $q,
            'results' => $results,
            'total' => count($results)
        ]);
    }
}
