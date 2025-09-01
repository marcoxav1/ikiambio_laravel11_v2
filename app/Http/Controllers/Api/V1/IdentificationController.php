<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Identification;
use Illuminate\Http\Request;

class IdentificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Identification::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'identificationQualifier' => ['nullable'],
            'typeStatus' => ['nullable'],
            'identifiedBy' => ['nullable'],
            'dateIdentified' => ['nullable'],
            'identificationVerificationStatus' => ['nullable'],
            'identificationRemarks' => ['nullable']
        ]);
        $item = Identification::create($data);
        return response()->json($item, 201);
    }

    public function show(Identification $identification)
    {
        return $identification;
    }

    public function update(Request $request, Identification $identification)
    {
        $data = $request->all();
        $identification->update($data);
        return $identification;
    }

    public function destroy(Identification $identification)
    {
        $identification->delete();
        return response()->noContent();
    }
}
