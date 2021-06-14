<?php

namespace App\Http\Controllers;

use App\Actions\WorkingWithImage\WorkingWithImage;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

  public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    return view('admin.banners.createBanner');
  }


  public function store(StoreBannerRequest $request): \Illuminate\Http\RedirectResponse
  {

    $validated = $request->validated();

    return WorkingWithImage::storeBanner($request, $validated);
  }


  public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $banner = Banner::findOrFail($id);

    return view('admin.banners.editBanner',compact('banner'));
  }


  public function update(UpdateBannerRequest $request): \Illuminate\Http\RedirectResponse
  {

    $validated = $request->validated();

    return WorkingWithImage::updateBanner($request, $validated);

}

  public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
  {
    $banners=Banner::orderBy('location','desc')->orderBy('position')->get();

    return view('admin.banners.index',compact('banners'));
  }


  public function destroy(Request $request): \Illuminate\Http\RedirectResponse
  {
    $validated = $request->validate(['id'=>'required|numeric']);

    $banner = Banner::find($validated['id']);

    return WorkingWithImage::deleteBanner($banner);
  }
}
