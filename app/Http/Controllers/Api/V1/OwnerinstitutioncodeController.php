<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Ownerinstitutioncode;
use Illuminate\Http\Request;

class OwnerinstitutioncodeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Ownerinstitutioncode::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ownerinstitutioncode_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Ownerinstitutioncode::create($data);
        return response()->json($item, 201);
    }

    public function show(Ownerinstitutioncode $ownerinstitutioncode)
    {
        return $ownerinstitutioncode;
    }

    public function update(Request $request, Ownerinstitutioncode $ownerinstitutioncode)
    {
        $data = $request->all();
        $ownerinstitutioncode->update($data);
        return $ownerinstitutioncode;
    }

    public function destroy(Ownerinstitutioncode $ownerinstitutioncode)
    {
        $ownerinstitutioncode->delete();
        return response()->noContent();
    }
}
