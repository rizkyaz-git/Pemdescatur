<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ComplaintCategory;
use App\Models\Gallery;
use App\Models\Kurikulum;
use App\Models\LetterTemplate;
use App\Models\News;
use App\Models\Official;
use App\Models\Pojok;
use App\Models\VillageProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
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

        $results = $this->performSearch($q, 8);
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
            $results = $this->performSearch($q, 40);
        }

        return view('public.search', [
            'query' => $q,
            'results' => $results,
            'total' => count($results)
        ]);
    }

    /**
     * Perform unified intelligent search across models, services & village profile.
     */
    private function performSearch(string $q, int $limit = 30): array
    {
        $raw = trim($q);
        if (mb_strlen($raw) < 2) {
            return [];
        }

        $search = mb_strtolower($raw);
        $tokens = array_values(array_filter(preg_split('/\s+/', $search), fn($t) => mb_strlen($t) >= 2));

        // Closure to test search against a list of terms
        $matchesAny = function (array $terms) use ($search, $tokens) {
            foreach ($terms as $term) {
                if (str_contains($search, $term)) {
                    return true;
                }
                foreach ($tokens as $token) {
                    if (str_contains($token, $term) || str_contains($term, $token)) {
                        return true;
                    }
                }
            }
            return false;
        };

        $intentMatches = [
            'official' => $matchesAny([
                'perangkat', 'aparatur', 'pamong', 'struktur', 'pemerintah', 'pejabat', 
                'kepala desa', 'kades', 'lurah', 'sekdes', 'sekretaris', 'bayan', 
                'kadus', 'kaur', 'kasi', 'kebayan', 'organisasi'
            ]),
            'letter' => $matchesAny([
                'surat', 'administrasi', 'blangko', 'format', 'template', 'pelayanan',
                'sktm', 'sku', 'skd', 'skk', 'spn', 'skkm', 'keterangan', 'pengantar',
                'domisili', 'usaha', 'nikah', 'kematian', 'kelahiran', 'tidak mampu', 'miskin'
            ]),
            'complaint' => $matchesAny([
                'pengaduan', 'keluhan', 'lapor', 'aspirasi', 'aduan', 'masalah', 'laporan', 'suara warga'
            ]),
            'news' => $matchesAny([
                'berita', 'warta', 'kabar', 'artikel', 'pengumuman', 'liputan'
            ]),
            'ppko' => $matchesAny([
                'ppko', 'catur cerdas', 'ormawa', 'imm', 'ums', 'literasi', 'perpustakaan', 'baca',
                'harmoni', 'ceria', 'tani', 'budaya', 'umkm', 'modul', 'kurikulum', 'pelatihan'
            ]),
            'profile' => $matchesAny([
                'profil', 'desa', 'catur', 'sejarah', '1987', 'soeharto', 'duto', 'asal usul',
                'visi', 'misi', 'wilayah', 'luas', 'sambi', 'boyolali', 'pedukuhan', 'dusun',
                'wonotoro', 'waduk', 'padi', 'organik', 'irigasi', 'pertanian'
            ]),
            'gallery' => $matchesAny([
                'galeri', 'foto', 'dokumentasi', 'gambar', 'album', 'kegiatan'
            ]),
        ];

        $collected = [];

        // 1. APARATUR DESA (Jika ada indikasi aparatur, tempatkan di prioritas utama)
        if ($intentMatches['official']) {
            $collected[] = [
                'type' => 'Struktur Pemerintahan',
                'title' => 'Bagan Struktur Organisasi Pemerintah Desa Catur',
                'category' => 'Pemerintahan Desa Catur',
                'snippet' => 'Susunan lengkap aparatur desa, kepala urusan (kaur), kepala seksi (kasi), dan kepala dusun (kadus) Desa Catur.',
                'url' => route('public.officials'),
                'badge' => 'Aparatur',
                'priority' => 1
            ];

            $officials = Official::orderBy('order', 'asc')->take(6)->get();
            foreach ($officials as $official) {
                $collected[] = [
                    'type' => 'Aparatur Desa',
                    'title' => $official->name . ' — ' . $official->position,
                    'category' => 'Pemerintahan Desa Catur',
                    'snippet' => 'Perangkat dan aparatur pelaksana Pemerintah Desa Catur, Sambi, Boyolali.',
                    'url' => route('public.officials'),
                    'badge' => 'Aparatur',
                    'priority' => 2
                ];
            }
        } else {
            // Pencarian spesifik nama atau jabatan
            $officials = Official::where(function ($query) use ($raw, $tokens) {
                $query->where('name', 'like', "%{$raw}%")
                      ->orWhere('position', 'like', "%{$raw}%");
                foreach ($tokens as $token) {
                    $query->orWhere('name', 'like', "%{$token}%")
                          ->orWhere('position', 'like', "%{$token}%");
                }
            })->orderBy('order', 'asc')->take(4)->get();

            foreach ($officials as $official) {
                $collected[] = [
                    'type' => 'Aparatur Desa',
                    'title' => $official->name . ' — ' . $official->position,
                    'category' => 'Pemerintahan Desa Catur',
                    'snippet' => 'Perangkat dan aparatur pelaksana Pemerintah Desa Catur, Sambi, Boyolali.',
                    'url' => route('public.officials'),
                    'badge' => 'Aparatur',
                    'priority' => 3
                ];
            }
        }

        // 2. LAYANAN SURAT (LetterTemplate)
        if ($intentMatches['letter']) {
            $collected[] = [
                'type' => 'Layanan Publik',
                'title' => 'Portal Layanan Permohonan Surat Online Desa Catur',
                'category' => 'Pelayanan Surat Warga',
                'snippet' => 'Unduh format blangko resmi atau ajukan surat keterangan domisili, usaha, nikah, kelahiran, dan lainnya.',
                'url' => route('warga.letter.index'),
                'badge' => 'Layanan',
                'priority' => 1
            ];

            $templates = LetterTemplate::where(function ($query) use ($raw, $tokens) {
                $query->where('name', 'like', "%{$raw}%")
                      ->orWhere('code', 'like', "%{$raw}%")
                      ->orWhere('description', 'like', "%{$raw}%");
                foreach ($tokens as $token) {
                    $query->orWhere('name', 'like', "%{$token}%")
                          ->orWhere('code', 'like', "%{$token}%")
                          ->orWhere('description', 'like', "%{$token}%");
                }
            })->take(6)->get();

            if ($templates->isEmpty()) {
                $templates = LetterTemplate::take(5)->get();
            }

            foreach ($templates as $tmpl) {
                $collected[] = [
                    'type' => 'Layanan Surat',
                    'title' => $tmpl->name . ($tmpl->code ? ' (' . $tmpl->code . ')' : ''),
                    'category' => 'Pelayanan Surat Warga',
                    'snippet' => Str::limit(strip_tags($tmpl->description ?? 'Format surat resmi permohonan administrasi warga Desa Catur.'), 120),
                    'url' => route('warga.letter.index'),
                    'badge' => 'Surat',
                    'priority' => 2
                ];
            }
        } else {
            $templates = LetterTemplate::where(function ($query) use ($raw, $tokens) {
                $query->where('name', 'like', "%{$raw}%")
                      ->orWhere('code', 'like', "%{$raw}%")
                      ->orWhere('description', 'like', "%{$raw}%");
                foreach ($tokens as $token) {
                    $query->orWhere('name', 'like', "%{$token}%")
                          ->orWhere('code', 'like', "%{$token}%")
                          ->orWhere('description', 'like', "%{$token}%");
                }
            })->take(4)->get();

            foreach ($templates as $tmpl) {
                $collected[] = [
                    'type' => 'Layanan Surat',
                    'title' => $tmpl->name . ($tmpl->code ? ' (' . $tmpl->code . ')' : ''),
                    'category' => 'Pelayanan Surat Warga',
                    'snippet' => Str::limit(strip_tags($tmpl->description ?? 'Format surat resmi permohonan administrasi warga Desa Catur.'), 120),
                    'url' => route('warga.letter.index'),
                    'badge' => 'Surat',
                    'priority' => 4
                ];
            }
        }

        // 3. LAYANAN PENGADUAN WARGA
        if ($intentMatches['complaint']) {
            $collected[] = [
                'type' => 'Layanan Publik',
                'title' => 'Formulir Pengaduan & Aspirasi Warga Desa Catur',
                'category' => 'Layanan Pengaduan & Aspirasi',
                'snippet' => 'Saluran resmi pelaporan fasilitas umum, aduan warga, atau aspirasi pembangunan langsung ke Pemdes Catur.',
                'url' => route('warga.complaint.index'),
                'badge' => 'Pengaduan',
                'priority' => 1
            ];
            $collected[] = [
                'type' => 'Layanan Publik',
                'title' => 'Buat Laporan / Pengaduan Baru',
                'category' => 'Layanan Pengaduan & Aspirasi',
                'snippet' => 'Isi formulir pelaporan online dengan melampirkan foto bukti lokasi atau aduan Anda.',
                'url' => route('warga.complaint.create'),
                'badge' => 'Pengaduan',
                'priority' => 2
            ];
        }

        $complaintCats = ComplaintCategory::where(function ($query) use ($raw, $tokens) {
            $query->where('name', 'like', "%{$raw}%")
                  ->orWhere('description', 'like', "%{$raw}%");
            foreach ($tokens as $token) {
                $query->orWhere('name', 'like', "%{$token}%")
                      ->orWhere('description', 'like', "%{$token}%");
            }
        })->take(3)->get();

        foreach ($complaintCats as $cat) {
            $collected[] = [
                'type' => 'Layanan Pengaduan',
                'title' => 'Lapor Pengaduan Bidang: ' . $cat->name,
                'category' => 'Kategori Pengaduan Warga',
                'snippet' => Str::limit(strip_tags($cat->description ?? 'Salurkan aspirasi atau aduan terkait ' . $cat->name . ' ke Pemdes Catur.'), 120),
                'url' => route('warga.complaint.create'),
                'badge' => 'Pengaduan',
                'priority' => 3
            ];
        }

        // 4. BERITA & PENGUMUMAN (News)
        $newsQuery = News::where('status', 'published');
        if ($intentMatches['news']) {
            $newsItems = $newsQuery->latest('published_at')->take(5)->get();
        } else {
            $newsItems = $newsQuery->where(function ($query) use ($raw, $tokens) {
                $query->where('title', 'like', "%{$raw}%")
                      ->orWhere('category', 'like', "%{$raw}%")
                      ->orWhere('excerpt', 'like', "%{$raw}%")
                      ->orWhere('content', 'like', "%{$raw}%");
                foreach ($tokens as $token) {
                    $query->orWhere('title', 'like', "%{$token}%")
                          ->orWhere('category', 'like', "%{$token}%")
                          ->orWhere('excerpt', 'like', "%{$token}%")
                          ->orWhere('content', 'like', "%{$token}%");
                }
            })->latest('published_at')->take(5)->get();
        }

        foreach ($newsItems as $news) {
            $collected[] = [
                'type' => 'Berita',
                'title' => $news->title,
                'category' => $news->category ?? 'Warta Desa',
                'snippet' => Str::limit(strip_tags($news->excerpt ?? $news->content), 120),
                'url' => route('public.news.show', $news->slug),
                'badge' => 'Berita',
                'priority' => $intentMatches['news'] ? 1 : 3
            ];
        }

        // 5. PPKO CATUR CERDAS & POJOK LITERASI
        if ($intentMatches['ppko']) {
            $collected[] = [
                'type' => 'Program Unggulan',
                'title' => 'PPKO Catur Cerdas — Program Transformasi Literasi UMS',
                'category' => 'PPKO Catur Cerdas',
                'snippet' => 'Inisiatif Penguatan Kapasitas Organisasi Kemahasiswaan UMS menghadirkan 5 pojok literasi di Desa Catur.',
                'url' => route('public.ppko'),
                'badge' => 'PPKO',
                'priority' => 1
            ];

            $pojoks = Pojok::take(5)->get();
        } else {
            $pojoks = Pojok::where(function ($query) use ($raw, $tokens) {
                $query->where('nama', 'like', "%{$raw}%")
                      ->orWhere('deskripsi_singkat', 'like', "%{$raw}%");
                foreach ($tokens as $token) {
                    $query->orWhere('nama', 'like', "%{$token}%")
                          ->orWhere('deskripsi_singkat', 'like', "%{$token}%");
                }
            })->take(3)->get();
        }

        foreach ($pojoks as $pojok) {
            $collected[] = [
                'type' => 'Pojok Literasi',
                'title' => $pojok->nama,
                'category' => 'PPKO Catur Cerdas',
                'snippet' => Str::limit(strip_tags($pojok->deskripsi_singkat), 120),
                'url' => route('public.ppko'),
                'badge' => 'PPKO',
                'priority' => $intentMatches['ppko'] ? 2 : 4
            ];
        }

        $kurikulums = Kurikulum::where(function ($query) use ($raw, $tokens) {
            $query->where('judul', 'like', "%{$raw}%")
                  ->orWhere('deskripsi', 'like', "%{$raw}%");
            foreach ($tokens as $token) {
                $query->orWhere('judul', 'like', "%{$token}%")
                      ->orWhere('deskripsi', 'like', "%{$token}%");
            }
        })->take(3)->get();

        foreach ($kurikulums as $kur) {
            $collected[] = [
                'type' => 'Materi & Modul',
                'title' => $kur->judul,
                'category' => 'Modul Edukasi PPKO',
                'snippet' => Str::limit(strip_tags($kur->deskripsi ?? 'Dokumen materi dan modul edukasi PPKO Catur Cerdas.'), 120),
                'url' => route('public.ppko'),
                'badge' => 'Modul',
                'priority' => 4
            ];
        }

        // 6. PROFIL DESA, SEJARAH, & POTENSI UNGGULAN
        $profile = VillageProfile::first();
        if ($profile && $intentMatches['profile']) {
            $collected[] = [
                'type' => 'Profil Desa',
                'title' => 'Profil Desa Catur — Sejarah, Visi, Misi & 13 Pedukuhan',
                'category' => 'Profil Wilayah',
                'snippet' => 'Informasi lengkap Desa Catur, Kecamatan Sambi, Boyolali dengan sejarah percontohan pertanian 1987 oleh Presiden Soeharto.',
                'url' => route('public.profile'),
                'badge' => 'Profil',
                'priority' => 2
            ];

            if ($matchesAny(['wonotoro', 'waduk', 'padi', 'organik', 'irigasi', 'tani', 'pertanian'])) {
                $collected[] = [
                    'type' => 'Potensi Desa',
                    'title' => 'Pertanian Padi Organik & Waduk Wonotoro',
                    'category' => 'Potensi Unggulan',
                    'snippet' => 'Kawasan pertanian padi organik Desa Catur dengan suplai irigasi melimpah sepanjang tahun dari Waduk Wonotoro.',
                    'url' => route('public.profile'),
                    'badge' => 'Potensi',
                    'priority' => 1
                ];
            }

            if ($matchesAny(['visi', 'misi', 'tujuan'])) {
                $collected[] = [
                    'type' => 'Profil Desa',
                    'title' => 'Visi & Misi Pemerintah Desa Catur',
                    'category' => 'Profil Wilayah',
                    'snippet' => Str::limit(strip_tags($profile->vision . ' ' . $profile->mission), 120),
                    'url' => route('public.profile'),
                    'badge' => 'Profil',
                    'priority' => 1
                ];
            }
        }

        // 7. GALERI FOTO
        $galleries = Gallery::where(function ($query) use ($raw, $tokens) {
            $query->where('title', 'like', "%{$raw}%")
                  ->orWhere('description', 'like', "%{$raw}%");
            foreach ($tokens as $token) {
                $query->orWhere('title', 'like', "%{$token}%")
                      ->orWhere('description', 'like', "%{$token}%");
            }
        })->latest('published_at')->take(4)->get();

        foreach ($galleries as $gallery) {
            $collected[] = [
                'type' => 'Galeri Foto',
                'title' => $gallery->title,
                'category' => 'Dokumentasi Desa',
                'snippet' => Str::limit(strip_tags($gallery->description ?? 'Dokumentasi kegiatan dan pesona Desa Catur.'), 120),
                'url' => route('public.gallery'),
                'badge' => 'Galeri',
                'priority' => 4
            ];
        }

        // 8. PERPUSTAKAAN DIGITAL
        if ($matchesAny(['perpustakaan', 'buku', 'baca', 'katalog', 'pustaka'])) {
            $collected[] = [
                'type' => 'Fasilitas Publik',
                'title' => 'Perpustakaan Digital Desa Catur',
                'category' => 'Fasilitas Desa',
                'snippet' => 'Akses koleksi buku dan referensi bacaan online resmi Perpustakaan Desa Catur.',
                'url' => 'https://desacaturbyl.perpustakaan.co.id/home.ks',
                'badge' => 'Perpustakaan',
                'priority' => 1
            ];
        }

        // Urutkan berdasarkan prioritas relevansi
        usort($collected, fn($a, $b) => ($a['priority'] ?? 5) <=> ($b['priority'] ?? 5));

        // Deduplikasi berdasarkan URL + Title
        $unique = [];
        $deduped = [];
        foreach ($collected as $item) {
            $key = $item['url'] . '|' . $item['title'];
            if (!isset($unique[$key])) {
                $unique[$key] = true;
                unset($item['priority']);
                $deduped[] = $item;
            }
        }

        return array_slice($deduped, 0, $limit);
    }
}
