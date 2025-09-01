<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Measurementorfacts;
use Illuminate\Http\Request;

class MeasurementorfactsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Measurementorfacts::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_occ_bd' => ['nullable'],
            'measurementType' => ['nullable'],
            'measurementValue' => ['nullable'],
            'measurementAccuracy' => ['nullable'],
            'measurementUnit' => ['nullable'],
            'measurementDeterminedBy' => ['nullable'],
            'measurementDeterminedDate' => ['nullable'],
            'measurementMethod' => ['nullable'],
            'measurementRemarks' => ['nullable']
        ]);
        $item = Measurementorfacts::create($data);
        return response()->json($item, 201);
    }

    public function show(Measurementorfacts $measurementorfacts)
    {
        return $measurementorfacts;
    }

    public function update(Request $request, Measurementorfacts $measurementorfacts)
    {
        $data = $request->all();
        $measurementorfacts->update($data);
        return $measurementorfacts;
    }

    public function destroy(Measurementorfacts $measurementorfacts)
    {
        $measurementorfacts->delete();
        return response()->noContent();
    }
}
