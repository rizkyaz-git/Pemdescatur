<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Official;
use App\Models\VillageProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Live search suggestion API for AJAX dropdown.
     */
    public function api(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 2) {
            return response()->json([
                'query' => $q,
                'total' => 0,
                'results' => []
            ]);
        }

        $results = $this->performSearch($q, 6);
        $total = count($results);

        return response()->json([
            'query' => $q,
            'total' => $total,
            'results' => array_slice($results, 0, 6)
        ]);
    }

    /**
     * Dedicated full search results page.
     */
    public function index(Request $request): View
    {
        $q = trim($request->get('q', ''));
        $results = [];
        
        if (!empty($q)) {
            $results = $this->performSearch($q, 30);
        }

        return view('public.search', [
            'query' => $q,
            'results' => $results,
            'total' => count($results)
        ]);
    }

    /**
     * Perform unified search across existing models & static features.
     */
    private function performSearch(string $q, int $limit = 20): array
    {
        $results = [];
        $search = strtolower($q);

        // 1. Berita & Pengumuman
        $newsItems = News::where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%")
                      ->orWhere('excerpt', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        foreach ($newsItems as $news) {
            $results[] = [
                'type' => 'Berita',
                'title' => $news->title,
                'category' => $news->category ?? 'Berita Desa',
                'snippet' => \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?? $news->content), 90),
                'url' => route('public.news.show', $news->slug),
                'badge' => '📰 Berita'
            ];
        }

        // 2. Perangkat & Struktur Pemerintahan
        $officials = Official::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('position', 'like', "%{$q}%");
            })
            ->take(4)
            ->get();

        foreach ($officials as $official) {
            $results[] = [
                'type' => 'Pemerintahan',
                'title' => $official->name . ' - ' . $official->position,
                'category' => 'Struktur Pemerintahan',
                'snippet' => 'Perangkat Pemerintah Desa Catur Sambi Boyolali',
                'url' => route('public.officials'),
                'badge' => '🏛️ Perangkat Desa'
            ];
        }



        // 4. Galeri & Wisata
        $galleries = Gallery::where('title', 'like', "%{$q}%")
            ->orWhere('category', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->take(3)
            ->get();

        foreach ($galleries as $gallery) {
            $results[] = [
                'type' => 'Galeri',
                'title' => $gallery->title,
                'category' => $gallery->category ?? 'Galeri Foto',
                'snippet' => strip_tags($gallery->description ?? 'Dokumentasi kegiatan Desa Catur'),
                'url' => route('public.gallery'),
                'badge' => '📷 Galeri'
            ];
        }

        // 5. Static Features (Pojok Literasi, Profil, Waduk Wonotoro, Irigasi, Desa Wisata)
        $staticFeatures = [
            [
                'title' => 'Pojok Harmoni - Literasi Informasi & Pelayanan Desa',
                'keywords' => ['harmoni', 'pojok harmoni', 'literasi', 'pelayanan', 'informasi'],
                'category' => 'Pojok Literasi',
                'snippet' => 'Layanan literasi informasi publik dan keharmonisan warga Desa Catur.',
                'url' => route('public.profile'),
                'badge' => '📖 Pojok Literasi'
            ],
            [
                'title' => 'Pojok Tani - Agribisnis & Padi Organik Waduk Wonotoro',
                'keywords' => ['tani', 'pojok tani', 'pertanian', 'padi', 'organik', 'irigasi', 'wonotoro', 'waduk'],
                'category' => 'Pojok Literasi',
                'snippet' => 'Edukasi pertanian padi organik dengan pengairan sepanjang tahun dari Waduk Wonotoro.',
                'url' => route('public.profile'),
                'badge' => '🌾 Pojok Literasi'
            ],
            [
                'title' => 'Pojok Ceria - Sarana Pendidikan (TK, SD/MI, MTsN, SMKN 1 Sambi)',
                'keywords' => ['ceria', 'pojok ceria', 'pendidikan', 'sekolah', 'tk', 'sd', 'mi', 'mtsn', 'smkn'],
                'category' => 'Pojok Literasi',
                'snippet' => 'Informasi sarana pendidikan desa terpadu untuk anak dan remaja Desa Catur.',
                'url' => route('public.news.index'),
                'badge' => '🎓 Pojok Literasi'
            ],
            [
                'title' => 'Pojok UMKM - Beras Organik, Olahan Herbal & Produk Lokal',
                'keywords' => ['umkm', 'pojok umkm', 'produk', 'herbal', 'beras', 'usaha', 'ekonomi'],
                'category' => 'Pojok Literasi',
                'snippet' => 'Pengembangan produk UMKM beras organik, olahan herbal, dan kerajinan warga.',
                'url' => route('public.gallery'),
                'badge' => '🛍️ Pojok Literasi'
            ],
            [
                'title' => 'Pojok Budaya - Wisata Religi Masjid Wonokusumo & Cagar Budaya',
                'keywords' => ['budaya', 'pojok budaya', 'masjid', 'wonokusumo', 'wisata', 'religi', 'sejarah', '1987'],
                'category' => 'Pojok Literasi',
                'snippet' => 'Warisan sejarah, wisata religi Masjid Wonokusumo, dan tradisi lokal Desa Catur.',
                'url' => route('public.profile'),
                'badge' => '🏛️ Pojok Literasi'
            ],
            [
                'title' => 'Profil Desa Catur - 13 Pedukuhan & Sejarah Presiden Soeharto 1987',
                'keywords' => ['profil', 'sejarah', '1987', 'soeharto', 'duto moelyono', 'dusun', 'pedukuhan', 'sambi', 'boyolali'],
                'category' => 'Profil Desa',
                'snippet' => 'Sejarah Desa Catur meraih penghargaan percontohan pertanian nasional dari Presiden Soeharto tahun 1987.',
                'url' => route('public.profile'),
                'badge' => '📖 Profil'
            ]
        ];

        foreach ($staticFeatures as $static) {
            $match = false;
            foreach ($static['keywords'] as $kw) {
                if (str_contains(strtolower($kw), $search) || str_contains($search, strtolower($kw))) {
                    $match = true;
                    break;
                }
            }
            if ($match || str_contains(strtolower($static['title']), $search)) {
                $results[] = [
                    'type' => 'Informasi',
                    'title' => $static['title'],
                    'category' => $static['category'],
                    'snippet' => $static['snippet'],
                    'url' => $static['url'],
                    'badge' => $static['badge']
                ];
            }
        }

        return array_slice($results, 0, $limit);
    }
}
