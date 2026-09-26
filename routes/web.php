<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public as PublicControllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// --- HALAMAN PUBLIK ---
Route::get('/', [PublicControllers\HomeController::class, 'index'])->name('home');
Route::get('/profil', [PublicControllers\ProfileController::class, 'index'])->name('public.profile');
Route::get('/struktur', [PublicControllers\OfficialController::class, 'index'])->name('public.officials');
Route::get('/berita', [PublicControllers\NewsController::class, 'index'])->name('public.news.index');
Route::get('/berita/{slug}', [PublicControllers\NewsController::class, 'show'])->name('public.news.show');
Route::post('/berita/{slug}/like', [PublicControllers\NewsController::class, 'like'])->middleware('throttle:10,1')->name('public.news.like');
Route::get('/galeri', [PublicControllers\GalleryController::class, 'index'])->name('public.gallery');
Route::get('/layanan', fn () => redirect('/layanan/cetak-surat-mandiri'));
Route::get('/pencarian', [PublicControllers\SearchController::class, 'index'])->name('public.search');
Route::get('/api/search', [PublicControllers\SearchController::class, 'api'])->name('api.search');
Route::get('/ppko-catur-cerdas', [PublicControllers\PpkoController::class, 'index'])->name('public.ppko');
Route::get('/ppko/kurikulum/{kurikulum}/download', [PublicControllers\PpkoController::class, 'downloadKurikulum'])->name('public.ppko.kurikulum.download');
Route::redirect('/ppko', '/ppko-catur-cerdas');

// --- PANEL ADMIN (TERPROTEKSI MIDDLEWARE AUTH & CHECKROLE) ---
Route::redirect('/admin', '/kelola');
Route::middleware(['auth', 'role:super_admin,admin_pemdes,ppk_ormawa'])->prefix('kelola')->name('admin.')->group(function () {
    // 1. Dashboard: Dapat diakses oleh semua peran admin
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // 2. Pengaturan Profil Sendiri (Foto Profil, Nama & Password): Dapat diakses oleh semua peran admin
    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [Admin\ProfileController::class, 'destroyAvatar'])->name('profile.destroy-avatar');

    // Utility: Bersihkan cache rute/aplikasi langsung dari web
    // Menggunakan POST untuk mencegah CSRF via link GET
    Route::post('/clear-cache', function () {
        try {
            Artisan::call('optimize:clear');
            $routeCache = app()->bootstrapPath('cache/routes-v7.php');
            if (file_exists($routeCache)) {
                @unlink($routeCache);
            }

            return redirect()->back()->with('success', 'Semua cache (route, view, config) berhasil dibersihkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Gagal membersihkan cache: '.$e->getMessage());
        }
    })->name('clear-cache');

    // 3. Berita & Pengumuman: Dapat diakses oleh Super Admin, Admin Pemdes, dan PPK Ormawa
    Route::middleware(['role:super_admin,admin_pemdes,ppk_ormawa'])->group(function () {
        Route::post('news/{news}/set-featured', [Admin\NewsController::class, 'setFeatured'])->name('news.set-featured');
        Route::resource('news', Admin\NewsController::class)->except(['show']);
        Route::post('news-categories', [Admin\NewsCategoryController::class, 'store'])->name('news-categories.store');
        Route::delete('news-categories/{newsCategory}', [Admin\NewsCategoryController::class, 'destroy'])->name('news-categories.destroy');
    });

    // 4. Modul Pemdes & Layanan Publik: Hanya dapat diakses oleh Super Admin dan Admin Pemdes
    Route::middleware(['role:super_admin,admin_pemdes'])->group(function () {
        // Profil Desa CRUD
        Route::get('/profil', [Admin\VillageProfileController::class, 'edit'])->name('village-profile.edit');
        Route::put('/profil', [Admin\VillageProfileController::class, 'update'])->name('village-profile.update');

        // Perangkat Desa CRUD
        Route::match(['post', 'put', 'patch'], 'officials/reorder', [Admin\OfficialController::class, 'reorder'])->name('officials.reorder');
        Route::resource('officials', Admin\OfficialController::class)->except(['show'])->whereNumber('official');

        // Galeri CRUD
        Route::resource('galleries', Admin\GalleryController::class)->except(['show']);

        // Layanan Publik (Template Surat, Permohonan Surat, Pengaduan Warga)
        Route::post('letter-requests/letter-types', [Admin\LetterRequestController::class, 'storeType'])->name('letter-requests.store-type');
        Route::patch('letter-requests/{letterRequest}/complete', [Admin\LetterRequestController::class, 'complete'])->name('letter-requests.complete');
        Route::resource('letter-templates', Admin\LetterTemplateController::class)->except(['show']);
        Route::resource('letter-requests', Admin\LetterRequestController::class)->only(['index', 'show', 'destroy']);
        // Pengaduan: alur "Baru" (belum selesai) & "Riwayat" (sudah selesai).
        // Alur lama "Tanggapi / Ubah Status" sudah dihapus; satu-satunya aksi
        // perubahan status adalah menandai pengaduan selesai.
        Route::patch('complaints/{complaint}/complete', [Admin\ComplaintController::class, 'complete'])->name('complaints.complete');
        Route::resource('complaints', Admin\ComplaintController::class)->only(['index', 'show', 'destroy']);
    });

    // 5. Modul PPK Ormawa: Hanya dapat diakses oleh Super Admin dan PPK Ormawa
    Route::middleware(['role:super_admin,ppk_ormawa'])->prefix('ppko')->name('ppko.')->group(function () {
        Route::get('/', [Admin\PpkoSettingController::class, 'index'])->name('index');
        Route::get('/{pojok}', [Admin\PpkoSettingController::class, 'edit'])->name('edit');
        Route::put('/{pojok}', [Admin\PpkoSettingController::class, 'update'])->name('update');
        Route::post('/{pojok}/foto', [Admin\PpkoSettingController::class, 'updateFoto'])->name('foto.update');
        Route::delete('/{pojok}/foto', [Admin\PpkoSettingController::class, 'deleteFoto'])->name('foto.delete');
        Route::post('/{pojok}/file', [Admin\PpkoSettingController::class, 'storeFile'])->name('file.store');
        Route::delete('/file/{kurikulum}', [Admin\PpkoSettingController::class, 'destroyFile'])->name('file.destroy');
        // Pengeditan Tabel Detail Program PPKO: Eksklusif Super Admin
        Route::middleware(['role:super_admin'])->group(function () {
            Route::post('/detail-program', [Admin\PpkoSettingController::class, 'storeProgramDetail'])->name('detail-program.store');
            Route::put('/detail-program/{detail}', [Admin\PpkoSettingController::class, 'updateProgramDetail'])->name('detail-program.update');
            Route::delete('/detail-program/{detail}', [Admin\PpkoSettingController::class, 'destroyProgramDetail'])->name('detail-program.destroy');
        });
    });

    // 6. Pengaturan Website & Kelola Pengguna: Eksklusif Super Admin
    Route::middleware(['role:super_admin'])->group(function () {
        // Pengaturan Umum, Logo & Hero Background
        Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
        Route::delete('/settings/logo', [Admin\SettingController::class, 'deleteLogo'])->name('settings.delete-logo');
        Route::delete('/settings/hero', [Admin\SettingController::class, 'deleteHero'])->name('settings.delete-hero');
        Route::delete('/settings/library-desktop', [Admin\SettingController::class, 'deleteLibraryDesktopImage'])->name('settings.delete-library-desktop');
        Route::delete('/settings/library-tablet', [Admin\SettingController::class, 'deleteLibraryTabletImage'])->name('settings.delete-library-tablet');
        Route::delete('/settings/library-mobile', [Admin\SettingController::class, 'deleteLibraryMobileImage'])->name('settings.delete-library-mobile');

        // Kelola Pengguna CRUD
        Route::resource('users', Admin\UserController::class)->except(['show']);
    });
});

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// ===== PORTAL LAYANAN PUBLIK WARGA & GUEST =====
// Pengajuan Surat (halaman utama) & Template/Katalog Surat (halaman sekunder)
// Redirect hanya GET; Route::redirect() mendaftarkan ANY dan dapat menutup
// route POST /layanan/surat ketika route cache diaktifkan.
Route::get('/layanan/surat', fn () => redirect('/layanan/cetak-surat-mandiri'));
// Halaman utama: form pengajuan surat (dipromosikan dari create() lama)
Route::get('/layanan/cetak-surat-mandiri', [PublicControllers\LetterRequestController::class, 'create'])->name('warga.letter.index');
// Halaman sekunder: katalog & unduh template surat (dipindah dari index() lama)
Route::get('/layanan/surat/template', [PublicControllers\LetterRequestController::class, 'index'])->name('warga.letter.templates');
Route::get('/layanan/surat/template/{letterTemplate}/download', [PublicControllers\LetterRequestController::class, 'downloadTemplate'])->name('warga.letter.download');
// /layanan/surat/buat → redirect permanen ke halaman form utama (keduanya sekarang identik)
Route::get('/layanan/surat/buat', fn () => redirect('/layanan/cetak-surat-mandiri', 301));
Route::post('/layanan/surat', [PublicControllers\LetterRequestController::class, 'store'])->middleware('throttle:5,1')->name('warga.letter.store');
Route::get('/layanan/surat/{letterRequest}', [PublicControllers\LetterRequestController::class, 'show'])->name('warga.letter.show');

// Pengaduan Warga (tanpa akun — identifikasi via nama & nomor WhatsApp)
// Gunakan satu route GET agar nama route tidak saling menimpa ketika route di-cache.
Route::get('/pengaduan', [PublicControllers\ComplaintController::class, 'create'])->name('warga.complaint.create');
Route::post('/pengaduan', [PublicControllers\ComplaintController::class, 'store'])->middleware('throttle:5,1')->name('warga.complaint.store');

// Redirect lama ke URL baru (backward compatibility)
Route::get('/layanan/pengaduan', fn () => redirect('/pengaduan'))->name('warga.complaint.index');
Route::get('/layanan/pengaduan/buat', fn () => redirect('/pengaduan'));

require __DIR__.'/auth.php';
