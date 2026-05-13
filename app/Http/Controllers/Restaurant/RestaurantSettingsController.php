<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RestaurantSettingsController extends Controller
{
    public function edit(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $restaurant->load(['information', 'logo', 'banner', 'openingHours']);

        $openingHours = $restaurant->openingHours->keyBy('day_of_week');

        return view('restaurant.settings.edit', compact('restaurant', 'openingHours'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'restaurant_type' => ['nullable', 'string', 'max:255'],

            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],

            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'opening_hours' => ['required', 'array'],
            'opening_hours.*.closed' => ['nullable'],
            'opening_hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'opening_hours.*.close_time' => ['nullable', 'date_format:H:i'],
        ]);

        $restaurant->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'restaurant_type' => $validated['restaurant_type'],
        ]);

        $restaurant->information()->updateOrCreate(
            ['restaurant_id' => $restaurant->id],
            [
                'address' => $validated['address'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
            ]
        );

        if ($request->hasFile('logo')) {
            $this->saveRestaurantImage($restaurant, $request->file('logo'), 'logo');
        }

        if ($request->hasFile('banner')) {
            $this->saveRestaurantImage($restaurant, $request->file('banner'), 'banner');
        }

        foreach ($validated['opening_hours'] as $day => $hours) {
            if (isset($hours['closed'])) {
                $restaurant->openingHours()
                    ->where('day_of_week', $day)
                    ->delete();

                continue;
            }

            if (empty($hours['open_time']) || empty($hours['close_time'])) {
                continue;
            }

            $restaurant->openingHours()->updateOrCreate(
                [
                    'restaurant_id' => $restaurant->id,
                    'day_of_week' => $day,
                ],
                [
                    'open_time' => $hours['open_time'],
                    'close_time' => $hours['close_time'],
                ]
            );
        }

        return back()->with('success', 'Restaurant instellingen opgeslagen.');
    }

    private function saveRestaurantImage(Restaurant $restaurant, $file, string $type): void
    {
        $folder = "img/restaurants/{$restaurant->id}/{$type}";
        $publicFolder = public_path($folder);

        if (! File::exists($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->move($publicFolder, $filename);

        $currentImage = $restaurant->images()
            ->where('image_type', $type)
            ->first();

        if ($currentImage) {
            $oldPath = public_path(ltrim($currentImage->image_url, '/'));

            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $restaurant->images()->updateOrCreate(
            [
                'restaurant_id' => $restaurant->id,
                'image_type' => $type,
            ],
            [
                'image_url' => '/' . $folder . '/' . $filename,
            ]
        );
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
