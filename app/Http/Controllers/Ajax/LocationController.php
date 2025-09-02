<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // Validamos mínimos. Si no envían locationID lo generamos (uuid).
        $data = $request->validate([
            'locationID' => ['nullable','string','max:255','unique:location,locationID'],
            'id_INEC'    => ['nullable','string','max:255'],
            'higherGeographyID' => ['nullable','string','max:255'],

            'continent'  => ['required','integer'],
            'waterBody'  => ['nullable','string','max:255'],
            'islandGroup'=> ['nullable','string','max:255'],
            'island'     => ['nullable','string','max:255'],
            'country'    => ['nullable','string','max:255'],
            'countryCode'=> ['nullable','string','max:2'],
            'stateProvince'=> ['nullable','string','max:255'],
            'county'     => ['nullable','string','max:255'],
            'municipality'=> ['nullable','string','max:255'],
            'locality'   => ['nullable','string'],
            'verbatimLocality'=> ['nullable','string'],
            'verbatimElevation'=> ['nullable','string'],
            'verbatimDepth'=> ['nullable','string'],
            'locationRemarks'=> ['nullable','string'],

            'decimalLatitude'  => ['nullable','numeric'],
            'decimalLongitude' => ['nullable','numeric'],
            'geodeticDatum'    => ['nullable','string','max:255'],
            'verbatimLatitude' => ['nullable','string','max:255'],
            'verbatimLongitude'=> ['nullable','string','max:255'],
            'verbatimCoordinateSystem'=> ['nullable','string','max:255'],

            'verbatimSRS' => ['required','integer'],
            'georeferencedBy'   => ['nullable','string','max:255'],
            'georeferencedDate' => ['nullable','date'],
            'georeferenceVerificationStatus' => ['required','integer'],
            'georeferenceRemarks' => ['nullable','string'],
        ]);

        if (empty($data['locationID'])) {
            $data['locationID'] = (string) \Illuminate\Support\Str::uuid();
        }

        $loc = DB::transaction(fn() => Location::create($data));

        // Construye etiqueta legible
        $parts = [$loc->locationID];
        $meta  = array_filter([
            $loc->locality,
            $loc->stateProvince,
            $loc->countryCode ? ($loc->country.' ('.$loc->countryCode.')') : $loc->country,
        ]);
        if ($meta) $parts[] = implode(', ', array_map(fn($x) => \Illuminate\Support\Str::limit($x, 40), $meta));
        $label = implode(' — ', $parts);

        return response()->json([
            'id'    => $loc->locationID,
            'label' => $label,
        ]);
    }

    public function search(Request $request)
    {
        $q = trim((string)$request->query('q', ''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Location::query()
            ->where(function ($w) use ($like) {
                $w->where('locationID', 'ilike', $like)
                  ->orWhere('locality', 'ilike', $like)
                  ->orWhere('country', 'ilike', $like)
                  ->orWhere('stateProvince', 'ilike', $like)
                  ->orWhere('countryCode', 'ilike', $like)
                  ->orWhere('municipality', 'ilike', $like)
                  ->orWhere('county', 'ilike', $like);
            })
            ->orderBy('locationID')
            ->limit(20)
            ->get(['locationID','locality','country','countryCode','stateProvince','municipality','county']);

        $items = $rows->map(function ($r) {
            $label = $r->locationID;
            $meta  = array_filter([
                $r->locality,
                $r->municipality,
                $r->county,
                $r->stateProvince,
                $r->countryCode ? ($r->country.' ('.$r->countryCode.')') : $r->country,
            ]);
            if ($meta) {
                $label .= ' — '.implode(', ', array_map(fn($x) => \Illuminate\Support\Str::limit($x, 30), $meta));
            }
            return ['id' => $r->locationID, 'text' => $label];
        });

        if ($items->isEmpty()) {
            return response()->json([['id' => '', 'text' => '— Sin resultados —']]);
        }

        return response()->json($items);
    }
}
