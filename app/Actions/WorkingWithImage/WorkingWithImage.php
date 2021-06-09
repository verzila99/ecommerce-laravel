<?php


namespace App\Actions\WorkingWithImage;


use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WorkingWithImage
{
  public static function storeImages(Request $request, $product): array|\Illuminate\Http\RedirectResponse
  {

    $pathApp = 'app/public/uploads/images/';
    $path = 'public/uploads/images/';
    if ($request->hasFile('image')) {

      $images = Collection::wrap($request->image);

      try {

        $images->each(function ($image) use ($pathApp, $path, $product) {

          if (!file_exists(storage_path($pathApp . $product->id . '/full/' . $image->getClientOriginalName()))) {

            $image->storeAs($path . $product->id . '/full', $image->getClientOriginalName());

            $name = $image->getClientOriginalName();

            if (!is_dir(storage_path($pathApp . $product->id . '/700x700'))) {
              Storage::makeDirectory($path . $product->id . '/700x700');
            }
            if (!is_dir(storage_path($pathApp . $product->id . '/225x225'))) {
              Storage::makeDirectory($path . $product->id . '/225x225');
            }
            if (!is_dir(storage_path($pathApp . $product->id . '/45x45'))) {
              Storage::makeDirectory($path . $product->id . '/45x45');
            }

            Image::make($image)->resize(700, 700, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })->save(storage_path($pathApp . $product->id . '/700x700/' . $name));

            Image::make($image)->resize(225, 225, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })->save(storage_path($pathApp . $product->id . '/225x225/' . $name));

            Image::make($image)->resize(45, 45, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();

            })->save(storage_path($pathApp . $product->id . '/45x45/' . $name));
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


  public static function updateImages(Request $request, $product): array|\Illuminate\Http\RedirectResponse
  {
    $pathApp = 'app/public/uploads/images/';

    if ($request->current) {

      $toDelete = array_diff(explode(',', $product->images), $request->current);
      if (!empty($toDelete)) {


        foreach ($toDelete as $item) {


          if (file_exists(storage_path($pathApp . $product->id . '/full/' . $item))) {
            File::delete(storage_path($pathApp . $product->id . '/full/' . $item));
          }
          if (file_exists(storage_path($pathApp . $product->id . '/700x700/' . $item))) {
            File::delete(storage_path($pathApp. $product->id . '/700x700/' . $item));
          }
          if (file_exists(storage_path($pathApp . $product->id . '/225x225/' . $item))) {
            File::delete(storage_path($pathApp . $product->id . '/225x225/' . $item));
          }
          if (file_exists(storage_path($pathApp . $product->id . '/45x45/' . $item))) {
            File::delete(storage_path($pathApp. $product->id . '/45x45/' . $item));
          }

        }
      }
    }

    return self::storeImages($request, $product);

  }

}
