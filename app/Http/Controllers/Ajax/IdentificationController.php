<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

// Modelos
use App\Models\Identification;
// Vocabs
use App\Models\Vocab\Identification\TypeStatus;
use App\Models\Vocab\Identification\VerificationStatus;

class IdentificationController extends Controller
{
    /** GET /ajax/identifications/search?q=... => [{id,text}] */
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') return response()->json([]);

        $like = "%{$q}%";

        $rows = Identification::query()
            ->where('identificationID', 'ilike', $like)
            ->orWhere('identifiedBy', 'ilike', $like)
            ->orderBy('identificationID')
            ->limit(20)
            ->get(['identificationID','identifiedBy','identificationRemarks']);

        $items = $rows->map(function ($r) {
            $label = $r->identificationID;
            if ($r->identifiedBy) $label .= ' — '.$r->identifiedBy;
            if ($r->identificationRemarks) $label .= ' — '.\Illuminate\Support\Str::limit($r->identificationRemarks, 40);
            return ['id' => $r->identificationID, 'text' => $label];
        });

        return response()->json($items);
    }

    /** POST /ajax/identifications => { id } (crea o actualiza por identificationID) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'identificationID'                => ['nullable','string','max:255'],
            'identificationQualifier'         => ['nullable','string'],
            'typeStatus'                      => ['nullable','integer', Rule::exists((new TypeStatus)->getTable(), (new TypeStatus)->getKeyName())],
            'identifiedBy'                    => ['nullable','string','max:255'],
            'dateIdentified'                  => ['nullable','date'],
            'identificationVerificationStatus'=> ['nullable','integer', Rule::exists((new VerificationStatus)->getTable(), (new VerificationStatus)->getKeyName())],
            'identificationRemarks'           => ['nullable','string'],
        ]);

        $id = DB::transaction(function () use ($data) {
            $identID = $data['identificationID'] ?? (string) Str::uuid();
            $row = Identification::find($identID);
            if ($row) {
                $row->update($data);
            } else {
                $data['identificationID'] = $identID;
                $row = Identification::create($data);
            }
            return $row->identificationID;
        });

        return response()->json(['id' => $id]);
    }
}
