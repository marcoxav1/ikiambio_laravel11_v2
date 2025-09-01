<?php

namespace App\Http\Controllers\Api\V1\Taxon;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Taxon\Taxonomicstatus;
use Illuminate\Http\Request;

class TaxonomicstatusController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Taxonomicstatus::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'taxonomicStatus_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Taxonomicstatus::create($data);
        return response()->json($item, 201);
    }

    public function show(Taxonomicstatus $taxonomicstatus)
    {
        return $taxonomicstatus;
    }

    public function update(Request $request, Taxonomicstatus $taxonomicstatus)
    {
        $data = $request->all();
        $taxonomicstatus->update($data);
        return $taxonomicstatus;
    }

    public function destroy(Taxonomicstatus $taxonomicstatus)
    {
        $taxonomicstatus->delete();
        return response()->noContent();
    }
}
