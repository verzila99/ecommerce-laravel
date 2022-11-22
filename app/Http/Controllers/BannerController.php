<?php

namespace App\Http\Controllers;

use App\Actions\WorkingWithImage\WorkingWithImage;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function create(): Factory|View|Application
    {
        return view('admin.banners.createBanner');
    }


    public function store(StoreBannerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return WorkingWithImage::storeBanner($request, $validated);
    }


    public function edit($id): Factory|View|Application
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.editBanner', compact('banner'));
    }


    public function update(UpdateBannerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return WorkingWithImage::updateBanner($request, $validated);
    }

    public function index(): Factory|View|Application
    {
        $banners = Banner::orderBy('location', 'desc')->orderBy('position')
                         ->get();

        return view('admin.banners.index', compact('banners'));
    }


    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate(['id' => 'required|numeric']);

        $banner = Banner::find($validated['id']);

        return WorkingWithImage::deleteBanner($banner);
    }
}
