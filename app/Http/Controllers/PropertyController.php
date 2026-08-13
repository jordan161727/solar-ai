<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\Customer;
use App\Models\Property;
use App\Models\SolarAssessment;
use App\Services\PropertyInsightsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = $request->query('status');

        $properties = Property::query()
            ->with(['customer', 'solarAssessment'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('property_name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($c) use ($search) {
                            $c->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(in_array($status, ['Pending', 'Analyzing', 'Completed'], true),
                fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $stats = [
            'totalProperties' => Property::count(),
            'pendingProperties' => Property::where('status', 'Pending')->count(),
            'analyzingProperties' => Property::where('status', 'Analyzing')->count(),
            'completedProperties' => Property::where('status', 'Completed')->count(),
            // Score lives on solar_assessments, not properties
            'averageScore' => round(SolarAssessment::avg('solar_score') ?? 0),
        ];

        return view('properties.index', [
            'properties' => $properties,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request, PropertyInsightsService $insights)
    {
        $validated = $request->validated();

        if (!empty($validated['email'])) {
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $validated['owner_name'],
                    'last_name' => null,
                    'phone' => $validated['phone'] ?? null,
                ]
            );
        } else {
            $customer = Customer::create([
                'first_name' => $validated['owner_name'],
                'last_name' => null,
                'email' => null,
                'phone' => $validated['phone'] ?? null,
            ]);
        }

        $propertyData = [
            'customer_id' => $customer->id,
            'property_name' => $validated['property_name'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'] ?? null,
            'province' => $validated['province'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'country' => $validated['country'] ?? 'Philippines',
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'place_id' => $validated['place_id'] ?? null,
            'status' => $validated['status'] ?? 'Pending',
        ];

        $property = Property::create($propertyData);

        // Keep a qualified lead even when Solar has no coverage for the address.
        $insights->refresh($property);

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property created and location insights requested.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load(['customer', 'solarAssessment', 'weatherRecords']);

        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
         return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([

        'owner_name' => 'required|max:255',
        'email' => 'nullable|email',
        'phone' => 'nullable|max:30',

        'address' => 'required|max:255',
        'barangay' => 'nullable|max:255',
        'city' => 'required|max:255',
        'province' => 'required|max:255',
        'zipcode' => 'nullable|max:20',

        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',

        'roof_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

        'roof_type' => 'required',

        'roof_area' => 'nullable|numeric',

        'solar_score' => 'nullable|integer',

        'estimated_generation' => 'nullable|numeric',

        'estimated_savings' => 'nullable|numeric',

        'status' => 'required',

        'notes' => 'nullable'

    ]);

    if($request->hasFile('roof_image')){

        if($property->roof_image &&
            Storage::disk('public')->exists($property->roof_image)){

            Storage::disk('public')->delete($property->roof_image);

        }

        $validated['roof_image'] =
            $request->file('roof_image')
                ->store('properties','public');
    }

    $property->update($validated);

    return redirect()
            ->route('properties.index')
            ->with('success','Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if($property->roof_image &&
        Storage::disk('public')->exists($property->roof_image)){

        Storage::disk('public')->delete($property->roof_image);

    }

    $property->delete();

    return back()->with('success','Property deleted successfully.');
    }
}
