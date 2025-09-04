<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentificationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'identificationID'                   => ['nullable','string','max:100','unique:identification,identificationID'],
            'identificationQualifier'            => ['nullable','string','max:100'],
            'typeStatus'                         => ['nullable','integer'], // FK
            'identifiedBy'                       => ['nullable','string','max:255'],
            'dateIdentified'                     => ['nullable','date'],
            'identificationVerificationStatus'   => ['nullable','integer'], // FK
            'identificationRemarks'              => ['nullable','string'],
        ]);

        if (empty($data['identificationID'])) {
            $data['identificationID'] = (string) \Illuminate\Support\Str::uuid();
        }

        $idn = DB::transaction(fn() => Identification::create($data));

        // Etiqueta legible
        $parts = array_filter([
            $idn->identifiedBy ? 'by: '.$idn->identifiedBy : null,
            $idn->dateIdentified ? 'date: '.$idn->dateIdentified : null,
            $idn->identificationQualifier ? 'qualif: '.$idn->identificationQualifier : null,
            $idn->identificationRemarks ? \Illuminate\Support\Str::limit($idn->identificationRemarks, 40) : null,
        ]);
        $label = $idn->identificationID.' — '.implode(' • ', $parts);

        return response()->json(['id' => $idn->identificationID, 'label' => $label]);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q',''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Identification::query()
            ->where('identificationID', 'ilike', $like)
            ->orWhere('identifiedBy', 'ilike', $like)
            ->orWhere('identificationQualifier', 'ilike', $like)
            ->orWhere('identificationRemarks', 'ilike', $like)
            ->orderBy('identificationID')
            ->limit(20)
            ->get([
                'identificationID','identifiedBy','dateIdentified','identificationQualifier','identificationRemarks'
            ]);

        $items = $rows->map(function ($r) {
            $meta = array_filter([
                $r->identifiedBy,
                $r->dateIdentified,
                $r->identificationQualifier,
                $r->identificationRemarks ? \Illuminate\Support\Str::limit($r->identificationRemarks, 40) : null,
            ]);
            return [
                'id'   => $r->identificationID,
                'text' => $r->identificationID.' — '.implode(' • ', $meta),
            ];
        });

        if ($items->isEmpty()) {
            return response()->json([['id' => '', 'text' => '— Sin resultados —']]);
        }

        return response()->json($items);
    }
}
