<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblmultimedia;
use Illuminate\Http\Request;

class TblmultimediaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblmultimedia::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idRegistros' => ['nullable'],
            'type' => ['nullable'],
            'format' => ['nullable'],
            'identifier' => ['nullable'],
            'title' => ['nullable'],
            'description' => ['nullable'],
            'created' => ['nullable'],
            'creator' => ['nullable'],
            'contributor' => ['nullable'],
            'publisher' => ['nullable'],
            'license' => ['nullable']
        ]);
        $item = Tblmultimedia::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblmultimedia $tblmultimedia)
    {
        return $tblmultimedia;
    }

    public function update(Request $request, Tblmultimedia $tblmultimedia)
    {
        $data = $request->all();
        $tblmultimedia->update($data);
        return $tblmultimedia;
    }

    public function destroy(Tblmultimedia $tblmultimedia)
    {
        $tblmultimedia->delete();
        return response()->noContent();
    }
}
