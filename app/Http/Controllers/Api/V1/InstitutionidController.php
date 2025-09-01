<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Institutionid;
use Illuminate\Http\Request;

class InstitutionidController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Institutionid::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'institutionID_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Institutionid::create($data);
        return response()->json($item, 201);
    }

    public function show(Institutionid $institutionid)
    {
        return $institutionid;
    }

    public function update(Request $request, Institutionid $institutionid)
    {
        $data = $request->all();
        $institutionid->update($data);
        return $institutionid;
    }

    public function destroy(Institutionid $institutionid)
    {
        $institutionid->delete();
        return response()->noContent();
    }
}
