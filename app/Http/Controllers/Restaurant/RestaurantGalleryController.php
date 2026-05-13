<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class RestaurantGalleryController extends Controller
{
    public function index(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $images = $restaurant->images()
            ->where('image_type', 'gallery')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('restaurant.gallery.index', compact('restaurant', 'images'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $file = $validated['image'];

        $folder = "img/restaurants/{$restaurant->id}/gallery";
        $publicFolder = public_path($folder);

        if (! File::exists($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->move($publicFolder, $filename);

        $nextOrder = $restaurant->images()
                ->where('image_type', 'gallery')
                ->max('sort_order') + 1;

        $restaurant->images()->create([
            'image_url' => '/' . $folder . '/' . $filename,
            'image_type' => 'gallery',
            'sort_order' => $nextOrder,
        ]);

        return back()->with('success', 'Foto toegevoegd.');
    }

    public function updateOrder(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $validated = $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['integer', 'exists:restaurant_images,id'],
        ]);

        foreach ($validated['images'] as $index => $imageId) {
            RestaurantImage::where('id', $imageId)
                ->where('restaurant_id', $restaurant->id)
                ->where('image_type', 'gallery')
                ->update([
                    'sort_order' => $index + 1,
                ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Request $request, Restaurant $restaurant, RestaurantImage $image)
    {
        $this->checkAccess($request, $restaurant);
        $this->checkGalleryImage($restaurant, $image);

        $path = public_path(ltrim($image->image_url, '/'));

        if (File::exists($path)) {
            File::delete($path);
        }

        $image->delete();

        $this->normalizeOrder($restaurant);

        return back()->with('success', 'Foto verwijderd.');
    }

    private function checkGalleryImage(Restaurant $restaurant, RestaurantImage $image): void
    {
        abort_unless(
            $image->restaurant_id === $restaurant->id && $image->image_type === 'gallery',
            404
        );
    }

    private function normalizeOrder(Restaurant $restaurant): void
    {
        $restaurant->images()
            ->where('image_type', 'gallery')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->values()
            ->each(function ($image, $index) {
                $image->update([
                    'sort_order' => $index + 1,
                ]);
            });
    }

    private function checkAccess(Request $request, Restaurant $restaurant): void
    {
        $allowed = $request->user()->hasRestaurantRole($restaurant->id, [
            'restaurant_owner',
            'restaurant_manager',
        ]);

        if (! $allowed) {
            abort(403);
        }
    }
}
