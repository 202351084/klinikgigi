<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\BannerRequest;
use App\Models\Banner;
use App\Models\ClinicSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('doctor.banners.index', [
            'banners' => Banner::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('doctor.banners.create', [
            'banner' => new Banner(),
        ]);
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['clinic_setting_id'] = ClinicSetting::query()->firstOrFail()->id;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        unset($data['image']);

        Banner::query()->create($data);

        return redirect()->route('doctor.banner.index')->with('status', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner): View
    {
        return view('doctor.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        unset($data['image']);

        $banner->update($data);

        return redirect()->route('doctor.banner.index')->with('status', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();

        return redirect()->route('doctor.banner.index')->with('status', 'Banner berhasil dihapus.');
    }
}
