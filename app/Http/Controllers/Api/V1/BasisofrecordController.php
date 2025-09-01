<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Basisofrecord;
use Illuminate\Http\Request;

class BasisofrecordController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Basisofrecord::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'basisofrecord_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Basisofrecord::create($data);
        return response()->json($item, 201);
    }

    public function show(Basisofrecord $basisofrecord)
    {
        return $basisofrecord;
    }

    public function update(Request $request, Basisofrecord $basisofrecord)
    {
        $data = $request->all();
        $basisofrecord->update($data);
        return $basisofrecord;
    }

    public function destroy(Basisofrecord $basisofrecord)
    {
        $basisofrecord->delete();
        return response()->noContent();
    }
}
