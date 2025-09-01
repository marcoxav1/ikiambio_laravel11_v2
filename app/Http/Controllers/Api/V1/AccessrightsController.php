<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Accessrights;
use Illuminate\Http\Request;

class AccessrightsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Accessrights::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'accessrights_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Accessrights::create($data);
        return response()->json($item, 201);
    }

    public function show(Accessrights $accessrights)
    {
        return $accessrights;
    }

    public function update(Request $request, Accessrights $accessrights)
    {
        $data = $request->all();
        $accessrights->update($data);
        return $accessrights;
    }

    public function destroy(Accessrights $accessrights)
    {
        $accessrights->delete();
        return response()->noContent();
    }
}
