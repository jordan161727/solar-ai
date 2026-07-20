use App\Services\GoogleMapsService;

public function create(GoogleMapsService $googleMaps)
{
    return view('properties.create', [
        'googleMapsApiKey' => $googleMaps->getApiKey(),
    ]);
}