<?php


namespace App\Actions\WorkingWithImage;


use App\Models\Banner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorkingWithImage
{
  public static function updateImages(Request $request, $product): array|\Illuminate\Http\RedirectResponse
  {
    $pathApp = 'app/public/uploads/images/';

    if ($request->current) {

      $toDelete = array_diff(explode(',', $product->images), $request->current);
      if (!empty($toDelete)) {

        foreach ($toDelete as $item) {

          if (file_exists(storage_path($pathApp . $product->id . '/700x700/' . $item))) {
            File::delete(storage_path($pathApp . $product->id . '/700x700/' . $item));
          }
        }
      }
    }

    return self::storeImages($request, $product);

  }


  public static function storeImages(Request $request, $product): array|\Illuminate\Http\RedirectResponse
  {

    $pathApp = 'app/public/uploads/images/';
    $path = 'public/uploads/images/';
    if ($request->hasFile('image')) {

      $images = Collection::wrap($request->image);

      try {

        $images->each(function ($image) use ($pathApp, $path, $product) {

          if (!file_exists(storage_path($pathApp . $product->id . '/700x700/' . $image->getClientOriginalName()))) {


            $name = $image->getClientOriginalName();

            if (!is_dir(storage_path($pathApp . $product->id . '/700x700'))) {
              Storage::makeDirectory($path . $product->id . '/700x700');
            }


            Image::make($image)->resize(700, 700, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })->save(storage_path($pathApp . $product->id . '/700x700/' . $name));

          }
        });
      } catch (Exception $e) {

        abort(500);

      }
    }
    $filesNames = Storage::files($path . $product->id . '/full');

    return is_array($filesNames) ? array_map(static function ($elem) {
      return preg_replace('/^[a-zA-Z0-9\/\\\]+\/full\//', '', $elem);
    }, $filesNames) : [preg_replace('/^[a-zA-Z0-9\/\\\]+\/full\//', '', $filesNames)];

  }


  public static function storeBanner(Request $request, $validated): \Illuminate\Http\RedirectResponse
  {
    $banner= new Banner;
    $banner->url = $validated['url'];
    $banner->location = $validated['location'];
    $banner->position = $validated['position'];

    $image = $request->image;

    $name = $image->getClientOriginalName();

    $banner->image = $name;

    $pathApp = 'app/public/uploads/banners/';

    $path = 'public/uploads/banners/';

    try {

      if (!file_exists(storage_path($pathApp . $name))) {


      self::storeBannerImage($path,$pathApp,$image,$name);

      } else {

        return redirect()->back()->with('status', 'File with this name already exists');
      }
    } catch (Exception $e) {

      abort(500);

    }
    if(Banner::where('location', $banner->location)->where('position', $banner->position)->first() !== null){

    DB::table('banners')->where('location',$banner->location)->where('position', '>=', $banner->position)->increment('position');
    }

    $banner->save();

    return redirect()->back()->with('status', 'Banner added!');

  }


  public static function deleteBanner($banner): bool|\Illuminate\Http\RedirectResponse
  {
    $pathApp = 'app/public/uploads/banners/';

    try {
      if (file_exists(storage_path($pathApp . $banner->image))) {

        File::delete(storage_path($pathApp . '/1152x300/' . $banner->image));
        File::delete(storage_path($pathApp . $banner->image));
      } else {

        return redirect()->back()->with('status', 'There is no file with this name.');
      }
    } catch (Exception $e) {

      return redirect()->back()->with('status', 'Something goes wrong, try again.');

    }

    $countBanners= Banner::where('location', $banner->location)->count();

    $location =$banner->location;

    $banner->delete();

    Banner::orderBanners($countBanners,$location);

    return redirect()->back()->with('status', 'Banner deleted!');
  }


  public static function updateBanner($request, $validated)
  {
    $pathApp = 'app/public/uploads/banners/';
    $path = 'public/uploads/banners/';

    $banner = Banner::findOrFail($validated['id']);
    $location = $banner->location;
    $banner->url = $validated['url'];
    $banner->location = $validated['location'];
    $banner->position = $validated['position'];


    if ($request->has('image')) {

      $name = $banner->image;

      try {
        if (file_exists(storage_path($pathApp . $name))) {

          File::delete(storage_path($pathApp . '/1152x300/' . $name));
          File::delete(storage_path($pathApp . $name));

        }

      } catch (Exception $e) {

        return redirect()->back()->with('status', 'Something goes wrong, try again.');

      }

      $image = $request->image;

      $name = $image->getClientOriginalName();

      $banner->image = $name;

      try {

        if (!file_exists(storage_path($pathApp . $name))) {

          self::storeBannerImage($path, $pathApp, $image, $name);

        } else {

          return redirect()->back()->with('status', 'File with this name already exists.');
        }
      } catch (Exception $e) {

        abort(500);

      }
    }
    if (Banner::where('location', $banner->location)->where('position', $banner->position)->first() !== null) {

      DB::table('banners')->where('location', $banner->location)->where('position', '>=', $banner->position)->increment('position');
    }

    $banner->save();

    $countBanners = Banner::where('location', $location)->count();

    Banner::orderBanners($countBanners,$location);

    return redirect()->back()->with('status', 'Banner updated!');

  }


  public static function storeBannerImage($path,$pathApp,$image,$name): void
  {

      $image->storeAs($path, $name);

      if (!is_dir(storage_path($pathApp . '/1152x300'))) {
        Storage::makeDirectory($path . '/1152x300');
      }

      Image::make($image)->fit(1152, 300, function ($constraint) {
        $constraint->upsize();
      })->save(storage_path($pathApp . '/1152x300/' . $name));
    }

}
