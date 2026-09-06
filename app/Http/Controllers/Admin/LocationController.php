<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::orderBy('is_primary', 'desc')->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->boolean('is_primary');
        $data['is_umkm'] = $request->boolean('is_umkm');
        $data['is_education'] = $request->boolean('is_education');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        if (!empty($data['is_primary'])) {
            Location::where('is_primary', true)->update(['is_primary' => false]);
        }

        Location::create($data);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Titik lokasi berhasil ditambahkan!');
    }

    public function edit(Location $location): View
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->boolean('is_primary');
        $data['is_umkm'] = $request->boolean('is_umkm');
        $data['is_education'] = $request->boolean('is_education');

        if ($request->hasFile('image')) {
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        if (!empty($data['is_primary'])) {
            Location::where('id', '!=', $location->id)->update(['is_primary' => false]);
        }

        $location->update($data);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Titik lokasi berhasil diperbarui!');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Titik lokasi berhasil dihapus!');
    }
}
