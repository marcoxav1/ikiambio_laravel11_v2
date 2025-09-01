<?php

namespace App\Http\Controllers\Api\V1\Identification;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Identification\Typestatus;
use Illuminate\Http\Request;

class TypestatusController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Typestatus::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'typeStatus_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Typestatus::create($data);
        return response()->json($item, 201);
    }

    public function show(Typestatus $typestatus)
    {
        return $typestatus;
    }

    public function update(Request $request, Typestatus $typestatus)
    {
        $data = $request->all();
        $typestatus->update($data);
        return $typestatus;
    }

    public function destroy(Typestatus $typestatus)
    {
        $typestatus->delete();
        return response()->noContent();
    }
}
