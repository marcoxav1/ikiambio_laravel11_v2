<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

// Modelos principales
use App\Models\RecordLevel;

// Vocabs (ajusta namespaces si difieren)
use App\Models\Vocab\RecordLevel\Type;
use App\Models\Vocab\RecordLevel\License;
use App\Models\Vocab\RecordLevel\Rightsholder;
use App\Models\Vocab\RecordLevel\Accessrights;
use App\Models\Vocab\RecordLevel\Institutionid;
use App\Models\Vocab\RecordLevel\Collectionid;
use App\Models\Vocab\RecordLevel\Institutioncode;
use App\Models\Vocab\RecordLevel\Collectioncode;
use App\Models\Vocab\RecordLevel\Ownerinstitutioncode;
use App\Models\Vocab\RecordLevel\Basisofrecord;

class RecordLevelController extends Controller
{
    /** GET /ajax/record-levels/search?q=...  => [{id,text}] */
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            return response()->json([]);
        }

        $like = "%{$q}%";

        $rows = RecordLevel::query()
            ->where('datasetName', 'ilike', $like)
            ->orWhere('references', 'ilike', $like)
            ->orWhere('datasetID', 'ilike', $like)
            ->orderByDesc('record_level_id')
            ->limit(20)
            ->get(['record_level_id','datasetName','references','datasetID']);

        $items = $rows->map(function ($r) {
            $parts = array_filter([
                $r->datasetName,
                $r->references,
                $r->datasetID ? 'ID: '.$r->datasetID : null,
            ]);
            $label = '#'.$r->record_level_id.(count($parts) ? ' — '.\Illuminate\Support\Str::limit(implode(' | ', $parts), 90) : '');
            return ['id' => $r->record_level_id, 'text' => $label];
        });

        return response()->json($items);
    }

    /** POST /ajax/record-levels  => { id }  (crea o actualiza si envían record_level_id) */
    public function store(Request $request)
    {
        // Validación base + FKs a vocab
        $data = $request->validate([
            'record_level_id'      => ['nullable','integer'],
            'type'                 => ['required','integer', Rule::exists((new Type)->getTable(), (new Type)->getKeyName())],
            'modified'             => ['nullable','date'],
            'language'             => ['nullable','string','max:2'],
            'license'              => ['required','integer', Rule::exists((new License)->getTable(), (new License)->getKeyName())],
            'rightsHolder'         => ['required','integer', Rule::exists((new Rightsholder)->getTable(), (new Rightsholder)->getKeyName())],
            'accessRights'         => ['required','integer', Rule::exists((new Accessrights)->getTable(), (new Accessrights)->getKeyName())],
            'bibliographicCitation'=> ['nullable','string'],
            'references'           => ['nullable','string'],
            'institutionID'        => ['required','integer', Rule::exists((new Institutionid)->getTable(), (new Institutionid)->getKeyName())],
            'collectionID'         => ['required','integer', Rule::exists((new Collectionid)->getTable(), (new Collectionid)->getKeyName())],
            'datasetID'            => ['nullable','string','max:100'],
            'institutionCode'      => ['required','integer', Rule::exists((new Institutioncode)->getTable(), (new Institutioncode)->getKeyName())],
            'collectionCode'       => ['required','integer', Rule::exists((new Collectioncode)->getTable(), (new Collectioncode)->getKeyName())],
            'datasetName'          => ['nullable','string','max:255'],
            'ownerInstitutionCode' => ['required','integer', Rule::exists((new Ownerinstitutioncode)->getTable(), (new Ownerinstitutioncode)->getKeyName())],
            'basisOfRecord'        => ['required','integer', Rule::exists((new Basisofrecord)->getTable(), (new Basisofrecord)->getKeyName())],
            'informationWithheld'  => ['nullable','string'],
            'dataGeneralizations'  => ['nullable','string'],
        ]);

        $id = DB::transaction(function () use ($data) {
            if (!empty($data['record_level_id'])) {
                $rl = RecordLevel::find($data['record_level_id']);
                if ($rl) {
                    $rl->update($data);
                    return $rl->record_level_id;
                }
            }
            $rl = RecordLevel::create($data);
            return $rl->record_level_id;
        });

        return response()->json(['id' => $id]);
    }
}
