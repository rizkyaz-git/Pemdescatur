<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateVillageProfileRequest;
use App\Models\VillageProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VillageProfileController extends Controller
{
    public function edit(): View
    {
        $profile = VillageProfile::firstOrCreate(
            ['id' => 1],
            [
                'history' => '',
                'vision' => '',
                'mission' => '',
            ]
        );

        return view('admin.village_profile.edit', compact('profile'));
    }

    public function update(UpdateVillageProfileRequest $request): RedirectResponse
    {
        $profile = VillageProfile::firstOrCreate(['id' => 1]);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($profile->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->image);
            }
            $data['image'] = $request->file('image')->store('village_profile', 'public');
        }

        $profile->update($data);

        return redirect()->route('admin.village-profile.edit')
            ->with('success', 'Profil Desa Catur berhasil diperbarui!');
    }
}
