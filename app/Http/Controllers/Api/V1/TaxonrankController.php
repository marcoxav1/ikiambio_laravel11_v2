<?php

namespace App\Http\Controllers\Api\V1\Taxon;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Taxon\Taxonrank;
use Illuminate\Http\Request;

class TaxonrankController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Taxonrank::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'taxonRank_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Taxonrank::create($data);
        return response()->json($item, 201);
    }

    public function show(Taxonrank $taxonrank)
    {
        return $taxonrank;
    }

    public function update(Request $request, Taxonrank $taxonrank)
    {
        $data = $request->all();
        $taxonrank->update($data);
        return $taxonrank;
    }

    public function destroy(Taxonrank $taxonrank)
    {
        $taxonrank->delete();
        return response()->noContent();
    }
}
