<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public as PublicControllers;
use Illuminate\Support\Facades\Route;

// --- HALAMAN PUBLIK ---
Route::get('/', [PublicControllers\HomeController::class, 'index'])->name('home');
Route::get('/profil', [PublicControllers\ProfileController::class, 'index'])->name('public.profile');
Route::get('/struktur', [PublicControllers\OfficialController::class, 'index'])->name('public.officials');
Route::get('/berita', [PublicControllers\NewsController::class, 'index'])->name('public.news.index');
Route::get('/berita/{slug}', [PublicControllers\NewsController::class, 'show'])->name('public.news.show');
Route::post('/berita/{slug}/like', [PublicControllers\NewsController::class, 'like'])->name('public.news.like');
Route::get('/galeri', [PublicControllers\GalleryController::class, 'index'])->name('public.gallery');
Route::get('/layanan', [PublicControllers\ServiceController::class, 'index'])->name('public.services.index');
Route::get('/pencarian', [PublicControllers\SearchController::class, 'index'])->name('public.search');
Route::get('/api/search', [PublicControllers\SearchController::class, 'api'])->name('api.search');
Route::get('/ppko-catur-cerdas', [PublicControllers\PpkoController::class, 'index'])->name('public.ppko');
Route::get('/ppko/kurikulum/{kurikulum}/download', [PublicControllers\PpkoController::class, 'downloadKurikulum'])->name('public.ppko.kurikulum.download');
Route::redirect('/ppko', '/ppko-catur-cerdas');

// --- PANEL ADMIN (TERPROTEKSI MIDDLEWARE AUTH) ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);

    // Profil Desa CRUD
    Route::get('/profil', [Admin\VillageProfileController::class, 'edit'])->name('village-profile.edit');
    Route::put('/profil', [Admin\VillageProfileController::class, 'update'])->name('village-profile.update');

    // Berita CRUD
    Route::resource('news', Admin\NewsController::class)->except(['show']);

    // Perangkat Desa CRUD
    Route::resource('officials', Admin\OfficialController::class)->except(['show']);



    // Galeri CRUD
    Route::resource('galleries', Admin\GalleryController::class)->except(['show']);

    // Pengaturan Umum, Logo & Hero Background
    Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/logo', [Admin\SettingController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::delete('/settings/hero', [Admin\SettingController::class, 'deleteHero'])->name('settings.delete-hero');
    Route::delete('/settings/head-photo', [Admin\SettingController::class, 'deleteHeadPhoto'])->name('settings.delete-head-photo');
    Route::delete('/settings/library-desktop', [Admin\SettingController::class, 'deleteLibraryDesktopImage'])->name('settings.delete-library-desktop');
    Route::delete('/settings/library-tablet', [Admin\SettingController::class, 'deleteLibraryTabletImage'])->name('settings.delete-library-tablet');
    Route::delete('/settings/library-mobile', [Admin\SettingController::class, 'deleteLibraryMobileImage'])->name('settings.delete-library-mobile');

    // ===== PHASE 1: PELAYANAN SURAT =====
    Route::resource('letter-templates', Admin\LetterTemplateController::class)->except(['show']);
    Route::resource('letter-requests', Admin\LetterRequestController::class)->only(['index', 'show', 'edit', 'update']);

    // ===== PHASE 1: PENGADUAN MASYARAKAT =====
    Route::resource('complaints', Admin\ComplaintController::class)->except(['create', 'store']);

    // ===== PPK ORMAWA: ADMIN PPKO (FOTO SAMPUL & FILE UNDUHAN) =====
    Route::prefix('ppko')->name('ppko.')->group(function () {
        Route::get('/', [Admin\PpkoSettingController::class, 'index'])->name('index');
        Route::get('/{pojok}', [Admin\PpkoSettingController::class, 'edit'])->name('edit');
        Route::put('/{pojok}', [Admin\PpkoSettingController::class, 'update'])->name('update');
        Route::post('/{pojok}/foto', [Admin\PpkoSettingController::class, 'updateFoto'])->name('foto.update');
        Route::delete('/{pojok}/foto', [Admin\PpkoSettingController::class, 'deleteFoto'])->name('foto.delete');
        Route::post('/{pojok}/file', [Admin\PpkoSettingController::class, 'storeFile'])->name('file.store');
        Route::delete('/file/{kurikulum}', [Admin\PpkoSettingController::class, 'destroyFile'])->name('file.destroy');
        Route::post('/detail-program', [Admin\PpkoSettingController::class, 'storeProgramDetail'])->name('detail-program.store');
        Route::put('/detail-program/{detail}', [Admin\PpkoSettingController::class, 'updateProgramDetail'])->name('detail-program.update');
        Route::delete('/detail-program/{detail}', [Admin\PpkoSettingController::class, 'destroyProgramDetail'])->name('detail-program.destroy');
    });
    Route::redirect('/pojoks', '/admin/ppko');
    Route::redirect('/kegiatans', '/admin/ppko');
});

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// ===== PORTAL LAYANAN PUBLIK WARGA & GUEST =====
// Pengajuan Surat
Route::get('/layanan/surat', [PublicControllers\LetterRequestController::class, 'index'])->name('warga.letter.index');
Route::get('/layanan/surat/buat', [PublicControllers\LetterRequestController::class, 'create'])->name('warga.letter.create');
Route::post('/layanan/surat', [PublicControllers\LetterRequestController::class, 'store'])->name('warga.letter.store');
Route::get('/layanan/surat/{letterRequest}', [PublicControllers\LetterRequestController::class, 'show'])->name('warga.letter.show');

// Pengajuan Pengaduan
Route::get('/layanan/pengaduan', [PublicControllers\ComplaintController::class, 'index'])->name('warga.complaint.index');
Route::get('/layanan/pengaduan/buat', [PublicControllers\ComplaintController::class, 'create'])->name('warga.complaint.create');
Route::post('/layanan/pengaduan', [PublicControllers\ComplaintController::class, 'store'])->name('warga.complaint.store');
Route::get('/layanan/pengaduan/{complaint}', [PublicControllers\ComplaintController::class, 'show'])->name('warga.complaint.show');

require __DIR__.'/auth.php';
