<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Collectionid;
use Illuminate\Http\Request;

class CollectionidController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Collectionid::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'collection_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Collectionid::create($data);
        return response()->json($item, 201);
    }

    public function show(Collectionid $collectionid)
    {
        return $collectionid;
    }

    public function update(Request $request, Collectionid $collectionid)
    {
        $data = $request->all();
        $collectionid->update($data);
        return $collectionid;
    }

    public function destroy(Collectionid $collectionid)
    {
        $collectionid->delete();
        return response()->noContent();
    }
}
