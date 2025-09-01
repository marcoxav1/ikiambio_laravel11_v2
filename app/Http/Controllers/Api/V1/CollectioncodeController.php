<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Collectioncode;
use Illuminate\Http\Request;

class CollectioncodeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Collectioncode::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'collectionCode_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Collectioncode::create($data);
        return response()->json($item, 201);
    }

    public function show(Collectioncode $collectioncode)
    {
        return $collectioncode;
    }

    public function update(Request $request, Collectioncode $collectioncode)
    {
        $data = $request->all();
        $collectioncode->update($data);
        return $collectioncode;
    }

    public function destroy(Collectioncode $collectioncode)
    {
        $collectioncode->delete();
        return response()->noContent();
    }
}
