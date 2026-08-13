<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

/**
 * Proxies the Static Maps API so satellite imagery can be shown without
 * putting the API key in the page source.
 */
class MapImageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $validated = $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'zoom' => 'nullable|integer|between:1,21',
            'scale' => 'nullable|integer|in:1,2',
            // Static Maps caps a requested side at 640.
            'w' => 'nullable|integer|between:64,640',
            'h' => 'nullable|integer|between:64,640',
            'size' => 'nullable|in:small,medium,large',
            'pin' => 'nullable|boolean',
        ]);

        $key = config('services.google.maps_api_key');

        if (blank($key)) {
            abort(404);
        }

        // Explicit w/h wins; the named sizes stay for the simpler call sites.
        if (isset($validated['w'], $validated['h'])) {
            $dimensions = $validated['w'].'x'.$validated['h'];
        } else {
            $dimensions = match ($validated['size'] ?? 'medium') {
                'small' => '400x200',
                'large' => '640x360',
                default => '600x340',
            };
        }

        $parameters = [
            'center' => $validated['lat'].','.$validated['lng'],
            'zoom' => $validated['zoom'] ?? 19,
            'size' => $dimensions,
            'scale' => $validated['scale'] ?? 2,
            'maptype' => 'satellite',
            'key' => $key,
        ];

        // The designer draws its own panel overlay, so it opts out of the pin.
        if ($request->boolean('pin', true)) {
            $parameters['markers'] = 'color:0xD97706|'.$validated['lat'].','.$validated['lng'];
        }

        $response = Http::timeout(15)->get('https://maps.googleapis.com/maps/api/staticmap', $parameters);

        if (! $response->successful()) {
            abort(502, 'Map preview unavailable.');
        }

        return response($response->body(), 200, [
            'Content-Type' => $response->header('Content-Type') ?: 'image/png',
            // Coordinates are immutable for a given property, so cache hard.
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }
}
