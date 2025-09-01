<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Organismquantitytype;
use Illuminate\Http\Request;

class OrganismquantitytypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Organismquantitytype::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'oqtype_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Organismquantitytype::create($data);
        return response()->json($item, 201);
    }

    public function show(Organismquantitytype $organismquantitytype)
    {
        return $organismquantitytype;
    }

    public function update(Request $request, Organismquantitytype $organismquantitytype)
    {
        $data = $request->all();
        $organismquantitytype->update($data);
        return $organismquantitytype;
    }

    public function destroy(Organismquantitytype $organismquantitytype)
    {
        $organismquantitytype->delete();
        return response()->noContent();
    }
}
