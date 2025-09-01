<?php

namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Location\GeorefStatus;
use Illuminate\Http\Request;

class GeorefStatusController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return GeorefStatus::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'georef_status_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = GeorefStatus::create($data);
        return response()->json($item, 201);
    }

    public function show(GeorefStatus $georefStatus)
    {
        return $georefStatus;
    }

    public function update(Request $request, GeorefStatus $georefStatus)
    {
        $data = $request->all();
        $georefStatus->update($data);
        return $georefStatus;
    }

    public function destroy(GeorefStatus $georefStatus)
    {
        $georefStatus->delete();
        return response()->noContent();
    }
}
