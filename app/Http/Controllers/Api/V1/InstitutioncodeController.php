<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Institutioncode;
use Illuminate\Http\Request;

class InstitutioncodeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Institutioncode::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'institutionCode_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Institutioncode::create($data);
        return response()->json($item, 201);
    }

    public function show(Institutioncode $institutioncode)
    {
        return $institutioncode;
    }

    public function update(Request $request, Institutioncode $institutioncode)
    {
        $data = $request->all();
        $institutioncode->update($data);
        return $institutioncode;
    }

    public function destroy(Institutioncode $institutioncode)
    {
        $institutioncode->delete();
        return response()->noContent();
    }
}
