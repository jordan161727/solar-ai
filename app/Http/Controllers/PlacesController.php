<?php

namespace App\Http\Controllers;

use App\Services\GooglePlacesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Backs the address autocomplete field. The browser talks to these routes
 * instead of Google directly, keeping the API key server-side.
 */
class PlacesController extends Controller
{
    public function __construct(private GooglePlacesService $places)
    {
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => 'required|string|max:255',
            'session' => 'nullable|string|max:100',
        ]);

        return response()->json([
            'suggestions' => $this->places->autocomplete(
                $validated['q'],
                $validated['session'] ?? null,
            ),
        ]);
    }

    public function details(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'place_id' => 'required|string|max:255',
            'session' => 'nullable|string|max:100',
        ]);

        $details = $this->places->details(
            $validated['place_id'],
            $validated['session'] ?? null,
        );

        if ($details === null) {
            return response()->json(['message' => 'Could not resolve that address.'], 422);
        }

        return response()->json($details);
    }
}
