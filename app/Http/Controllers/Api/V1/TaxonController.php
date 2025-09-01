<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Taxon;
use Illuminate\Http\Request;

class TaxonController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Taxon::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'scientificNameID' => ['nullable'],
            'scientificName' => ['nullable'],
            'namePublishedIn' => ['nullable'],
            'namePublishedInYear' => ['nullable'],
            'higherClassification' => ['nullable'],
            'kingdom' => ['nullable'],
            'phylum' => ['nullable'],
            'class' => ['nullable'],
            'order' => ['nullable'],
            'family' => ['nullable'],
            'genus' => ['nullable'],
            'subgenus' => ['nullable'],
            'specificEpithet' => ['nullable'],
            'intraspecificEpithet' => ['nullable'],
            'taxonRank' => ['nullable'],
            'verbatimTaxonRank' => ['nullable'],
            'scientificNameAuthorship' => ['nullable'],
            'vernacularName' => ['nullable'],
            'taxonomicStatus' => ['nullable'],
            'taxonRemarks' => ['nullable']
        ]);
        $item = Taxon::create($data);
        return response()->json($item, 201);
    }

    public function show(Taxon $taxon)
    {
        return $taxon;
    }

    public function update(Request $request, Taxon $taxon)
    {
        $data = $request->all();
        $taxon->update($data);
        return $taxon;
    }

    public function destroy(Taxon $taxon)
    {
        $taxon->delete();
        return response()->noContent();
    }
}
