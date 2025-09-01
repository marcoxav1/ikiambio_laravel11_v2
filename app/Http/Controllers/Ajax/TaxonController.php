<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

// Modelos
use App\Models\Taxon;
// Vocabs
use App\Models\Vocab\Taxon\TaxonRank;
use App\Models\Vocab\Taxon\TaxonomicStatus;

class TaxonController extends Controller
{
    /** GET /ajax/taxa/search?q=... => [{id,text}] */
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Taxon::query()
            ->where('taxonID', 'ilike', $like)
            ->orWhere('scientificName', 'ilike', $like)
            ->orderBy('scientificName')
            ->limit(20)
            ->get(['taxonID','scientificName','kingdom','family','genus']);

        $items = $rows->map(function ($r) {
            $meta = array_filter([$r->kingdom, $r->family, $r->genus]);
            $label = ($r->scientificName ?: '[sin nombre]') . ' — ' . $r->taxonID;
            if ($meta) $label .= ' — '.implode(' / ', $meta);
            return ['id' => $r->taxonID, 'text' => \Illuminate\Support\Str::limit($label, 100)];
        });

        return response()->json($items);
    }

    /** POST /ajax/taxa => { id }  (crea o actualiza por taxonID) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'taxonID'                  => ['nullable','string','max:100'],
            'scientificNameID'         => ['nullable','string','max:100'],
            'scientificName'           => ['required','string','max:255'],

            'namePublishedIn'          => ['nullable','string'],
            'namePublishedInYear'      => ['nullable','integer'],
            'higherClassification'     => ['nullable','string'],

            'kingdom'                  => ['nullable','string','max:100'],
            'phylum'                   => ['nullable','string','max:100'],
            'class'                    => ['nullable','string','max:100'],
            'order'                    => ['nullable','string','max:100'],
            'family'                   => ['nullable','string','max:100'],
            'genus'                    => ['nullable','string','max:100'],
            'subgenus'                 => ['nullable','string','max:100'],
            'specificEpithet'          => ['nullable','string','max:100'],
            'intraspecificEpithet'     => ['nullable','string','max:100'],

            'taxonRank'                => ['nullable','integer', Rule::exists((new TaxonRank)->getTable(), (new TaxonRank)->getKeyName())],
            'verbatimTaxonRank'        => ['nullable','string','max:50'],
            'scientificNameAuthorship' => ['nullable','string'],
            'vernacularName'           => ['nullable','string'],
            'taxonomicStatus'          => ['nullable','integer', Rule::exists((new TaxonomicStatus)->getTable(), (new TaxonomicStatus)->getKeyName())],
            'taxonRemarks'             => ['nullable','string'],
        ]);

        $id = DB::transaction(function () use ($data) {
            $taxonID = $data['taxonID'] ?? (string) Str::uuid(); // genera uno si no envían
            $row = Taxon::find($taxonID);
            if ($row) {
                $row->update($data);
            } else {
                $data['taxonID'] = $taxonID;
                $row = Taxon::create($data);
            }
            return $row->taxonID;
        });

        return response()->json(['id' => $id]);
    }
}
