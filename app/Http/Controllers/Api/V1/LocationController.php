<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Location::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_INEC' => ['nullable'],
            'higherGeographyID' => ['nullable'],
            'continent' => ['required'],
            'waterBody' => ['nullable'],
            'islandGroup' => ['nullable'],
            'island' => ['nullable'],
            'country' => ['nullable'],
            'countryCode' => ['nullable'],
            'stateProvince' => ['nullable'],
            'county' => ['nullable'],
            'municipality' => ['nullable'],
            'locality' => ['nullable'],
            'verbatimLocality' => ['nullable'],
            'verbatimElevation' => ['nullable'],
            'verbatimDepth' => ['nullable'],
            'locationRemarks' => ['nullable'],
            'decimalLatitude' => ['nullable'],
            'decimalLongitude' => ['nullable'],
            'geodeticDatum' => ['nullable'],
            'verbatimLatitude' => ['nullable'],
            'verbatimLongitude' => ['nullable'],
            'verbatimCoordinateSystem' => ['nullable'],
            'verbatimSRS' => ['required'],
            'georeferencedBy' => ['nullable'],
            'georeferencedDate' => ['nullable'],
            'georeferenceVerificationStatus' => ['required'],
            'georeferenceRemarks' => ['nullable']
        ]);
        $item = Location::create($data);
        return response()->json($item, 201);
    }

    public function show(Location $location)
    {
        return $location;
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->all();
        $location->update($data);
        return $location;
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return response()->noContent();
    }
}
