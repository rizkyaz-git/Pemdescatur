<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = [
            'village_name' => Setting::get('village_name', 'Pemerintah Desa Catur'),
            'village_district' => Setting::get('village_district', 'Kecamatan Sambi, Kabupaten Boyolali, Jawa Tengah'),
            'village_address' => Setting::get('village_address', 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali, Jawa Tengah 57376'),
            'village_phone' => Setting::get('village_phone', '0812-3456-7890'),
            'village_email' => Setting::get('village_email', 'info@desacatur.id'),
            'library_url' => Setting::get('library_url', 'https://perpustakaan.boyolali.go.id'),
            'village_logo_path' => Setting::get('village_logo_path'),
            'hero_image_path' => Setting::get('hero_image_path'),
            'hero_title' => Setting::get('hero_title', 'Selamat Datang di Portal Resmi Desa Catur'),
            'hero_subtitle' => Setting::get('hero_subtitle', 'Pusat Informasi Terpadu, Transparansi Pemerintahan, dan Agribisnis Desa Catur Sambi Boyolali'),
            'library_desktop_image_path' => Setting::get('library_desktop_image_path'),
            'library_tablet_image_path' => Setting::get('library_tablet_image_path'),
            'library_mobile_image_path' => Setting::get('library_mobile_image_path'),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Setting::set('village_name', $validated['village_name']);
        Setting::set('village_district', $validated['village_district'] ?? '');
        Setting::set('village_address', $validated['village_address'] ?? '');
        Setting::set('village_phone', $validated['village_phone'] ?? '');
        Setting::set('village_email', $validated['village_email'] ?? '');
        Setting::set('library_url', $validated['library_url']);
        Setting::set('hero_title', $validated['hero_title'] ?? '');
        Setting::set('hero_subtitle', $validated['hero_subtitle'] ?? '');

        if ($request->hasFile('village_logo')) {
            $oldLogo = Setting::get('village_logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('village_logo')->store('settings', 'public');
            Setting::set('village_logo_path', $logoPath);
        }

        if ($request->hasFile('hero_image')) {
            $oldHero = Setting::get('hero_image_path');
            if ($oldHero && Storage::disk('public')->exists($oldHero)) {
                Storage::disk('public')->delete($oldHero);
            }
            $heroPath = $request->file('hero_image')->store('settings', 'public');
            Setting::set('hero_image_path', $heroPath);
        }

        if ($request->hasFile('library_desktop_image')) {
            $oldDesktop = Setting::get('library_desktop_image_path');
            if ($oldDesktop && Storage::disk('public')->exists($oldDesktop)) {
                Storage::disk('public')->delete($oldDesktop);
            }
            $path = $request->file('library_desktop_image')->store('settings', 'public');
            Setting::set('library_desktop_image_path', $path);
        }

        if ($request->hasFile('library_tablet_image')) {
            $oldTablet = Setting::get('library_tablet_image_path');
            if ($oldTablet && Storage::disk('public')->exists($oldTablet)) {
                Storage::disk('public')->delete($oldTablet);
            }
            $path = $request->file('library_tablet_image')->store('settings', 'public');
            Setting::set('library_tablet_image_path', $path);
        }

        if ($request->hasFile('library_mobile_image')) {
            $oldMobile = Setting::get('library_mobile_image_path');
            if ($oldMobile && Storage::disk('public')->exists($oldMobile)) {
                Storage::disk('public')->delete($oldMobile);
            }
            $path = $request->file('library_mobile_image')->store('settings', 'public');
            Setting::set('library_mobile_image_path', $path);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Pengaturan website dan gambar mockup perpustakaan berhasil diperbarui!');
    }

    public function deleteLogo(): RedirectResponse
    {
        $oldLogo = Setting::get('village_logo_path');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }
        Setting::set('village_logo_path', null);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Logo desa berhasil dihapus.');
    }

    public function deleteHero(): RedirectResponse
    {
        $oldHero = Setting::get('hero_image_path');
        if ($oldHero && Storage::disk('public')->exists($oldHero)) {
            Storage::disk('public')->delete($oldHero);
        }
        Setting::set('hero_image_path', null);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Gambar background hero berhasil dihapus dan dikembalikan ke bawaan.');
    }

    public function deleteLibraryDesktopImage(): RedirectResponse
    {
        $old = Setting::get('library_desktop_image_path');
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        Setting::set('library_desktop_image_path', null);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Gambar Mockup Desktop berhasil dihapus.');
    }

    public function deleteLibraryTabletImage(): RedirectResponse
    {
        $old = Setting::get('library_tablet_image_path');
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        Setting::set('library_tablet_image_path', null);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Gambar Mockup Tablet berhasil dihapus.');
    }

    public function deleteLibraryMobileImage(): RedirectResponse
    {
        $old = Setting::get('library_mobile_image_path');
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        Setting::set('library_mobile_image_path', null);

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Gambar Mockup Mobile berhasil dihapus.');
    }
}
