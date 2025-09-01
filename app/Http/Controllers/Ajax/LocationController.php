<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'locationID' => ['nullable','string','max:255'],
                'id_INEC' => ['nullable','string','max:255'],
                'higherGeographyID' => ['nullable','string','max:255'],
                'continent' => ['required','integer'],
                'waterBody' => ['nullable','string'],
                'islandGroup' => ['nullable','string'],
                'island' => ['nullable','string'],
                'country' => ['nullable','string'],
                'countryCode' => ['nullable','string','max:2'],
                'stateProvince' => ['nullable','string'],
                'county' => ['nullable','string'],
                'municipality' => ['nullable','string'],
                'locality' => ['nullable','string'],
                'verbatimLocality' => ['nullable','string'],
                'verbatimElevation' => ['nullable','string'],
                'verbatimDepth' => ['nullable','string'],
                'locationRemarks' => ['nullable','string'],
                'decimalLatitude' => ['nullable','numeric'],
                'decimalLongitude' => ['nullable','numeric'],
                'geodeticDatum' => ['nullable','string'],
                'verbatimLatitude' => ['nullable','string'],
                'verbatimLongitude' => ['nullable','string'],
                'verbatimCoordinateSystem' => ['nullable','string'],
                'verbatimSRS' => ['required','integer'],
                'georeferencedBy' => ['nullable','string'],
                'georeferencedDate' => ['nullable','date'], // Y-m-d
                'georeferenceVerificationStatus' => ['required','integer'],
                'georeferenceRemarks' => ['nullable','string'],
            ]);

            $id = $data['locationID'] ?: Str::uuid()->toString();

            DB::transaction(function () use (&$id, $data) {
                Location::updateOrCreate(
                    ['locationID' => $id],
                    collect($data)->except('locationID')->toArray()
                );
            });

            return response()->json(['ok' => true, 'id' => $id]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            // si no hay query, no sugerimos nada
            return response()->json([]);
        }

        $like = "%{$q}%";

        $rows = \App\Models\Location::query()
            ->where('locationID', 'ilike', $like)
            ->orWhere('locality', 'ilike', $like)
            ->orWhere('country', 'ilike', $like)
            ->orWhere('stateProvince', 'ilike', $like)
            ->orderBy('locationID')
            ->limit(20)
            ->get(['locationID','locality','country','countryCode','stateProvince']);

        if ($rows->isEmpty()) {
            // item sentinela para que el UI muestre "sin resultados"
            return response()->json([
                ['id' => '', 'text' => '— No se encontraron resultados —', 'empty' => true]
            ]);
        }

        $items = $rows->map(function ($r) {
            $label = $r->locationID;
            $meta  = array_filter([
                $r->locality,
                $r->stateProvince,
                $r->countryCode ? ($r->country.' ('.$r->countryCode.')') : $r->country,
            ]);
            if (count($meta)) {
                $label .= ' — '.implode(', ', array_map(
                    fn($x) => \Illuminate\Support\Str::limit($x, 30), $meta
                ));
            }
            return ['id' => $r->locationID, 'text' => $label];
        });

        return response()->json($items);
    }


}
