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
    /* public function search(Request $request)
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
    } */

    /** Búsqueda simple para reutilizar record levels existentes */
    /* public function search(Request $request)
    {
        $q = trim((string)$request->query('q', ''));
        if ($q === '') return response()->json([]);

        $rows = RecordLevel::query()
            ->when(ctype_digit($q), fn($qq) => $qq->orWhere('record_level_id', (int)$q))
            ->orWhere('datasetName', 'ilike', "%{$q}%")
            ->orWhere('references', 'ilike', "%{$q}%")
            ->orWhere('datasetID', 'ilike', "%{$q}%")
            ->orderByDesc('record_level_id')
            ->limit(20)
            ->get(['record_level_id','datasetName','references','datasetID']);

        return response()->json(
            $rows->map(fn($r) => [
                'id'   => $r->record_level_id,
                'text' => '#'.$r->record_level_id.' - '.$r->references.' - '.$r->datasetID.' - '.($r->datasetName ? ' - '.$r->datasetName : ''),
            ])
        );
    }     */


    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            return response()->json([]);
        }

        // Opcional: permitir que, si estás editando una Occurrence, el RL ya vinculado
        // aparezca también en resultados para poder re-usarlo.
        $currentId = $request->query('current_id'); // ej: /search?q=pepe&current_id=12

        $builder = RecordLevel::query();

        // 1) Restringe a los que NO están asociados a Occurrence (o el current_id si fue pasado)
        $builder->where(function ($w) use ($currentId) {
            // NOT IN (SELECT record_level_id FROM occurrence WHERE record_level_id IS NOT NULL)
            $w->whereNotIn('record_level_id', function ($sub) {
                $sub->select('record_level_id')
                    ->from('occurrence')
                    ->whereNotNull('record_level_id');
            });

            if ($currentId) {
                // Incluye el actual si se está editando
                $w->orWhere('record_level_id', (int) $currentId);
            }
        });

        // 2) Búsqueda por texto/ID (agrupada para no romper la condición anterior)
        $builder->where(function ($w) use ($q) {
            if (ctype_digit($q)) {
                $w->orWhere('record_level_id', (int) $q);
            }
            $w->orWhere('datasetName', 'ilike', "%{$q}%")
            ->orWhere('references',  'ilike', "%{$q}%")
            ->orWhere('datasetID',   'ilike', "%{$q}%");
        });

        // 3) Orden, límite y columnas
        $rows = $builder
            ->orderByDesc('record_level_id')
            ->limit(20)
            ->get(['record_level_id','datasetName','references','datasetID']);

        // 4) Formato select2-like
        $items = $rows->map(function ($r) {
            $label = '#'.$r->record_level_id.' - '.$r->references.' - '.$r->datasetID;
            if (!empty($r->datasetName)) {
                $label .= ' - '.$r->datasetName;
            }
            return [
                'id'   => $r->record_level_id,
                'text' => $label,
            ];
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
