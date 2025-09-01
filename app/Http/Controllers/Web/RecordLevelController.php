<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RecordLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

// Modelos vocab
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
    public function index()
    {
        $items = RecordLevel::with([
            'typeRef','licenseRef','rightsHolderRef','accessRightsRef',
            'institutionIdRef','collectionIdRef','institutionCodeRef','collectionCodeRef',
            'ownerInstitutionCodeRef','basisOfRecordRef',
        ])->orderByDesc('record_level_id')->paginate(15);

        return view('pages.record-level.index', compact('items'));
    }

    public function create()
    {
        $options = $this->options();
        return view('pages.record-level.create', $options);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            RecordLevel::create($data);
        });

        return redirect()->route('record-level.index')->with('ok', 'Creado');
    }

    public function show(RecordLevel $recordLevel)
    {
        $recordLevel->load([
            'typeRef','licenseRef','rightsHolderRef','accessRightsRef',
            'institutionIdRef','collectionIdRef','institutionCodeRef','collectionCodeRef',
            'ownerInstitutionCodeRef','basisOfRecordRef',
        ]);

        return view('pages.record-level.show', ['item' => $recordLevel]);
    }

    public function edit(RecordLevel $recordLevel)
    {
        $options = $this->options();
        $options['item'] = $recordLevel;
        return view('pages.record-level.edit', $options);
    }

    public function update(Request $request, RecordLevel $recordLevel)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($recordLevel, $data) {
            $recordLevel->update($data);
        });

        return redirect()->route('record-level.index')->with('ok', 'Actualizado');
    }

    public function destroy(RecordLevel $recordLevel)
    {
        DB::transaction(function () use ($recordLevel) {
            $recordLevel->delete();
        });

        return back()->with('ok', 'Eliminado');
    }

    // ================= Helpers =================

    /** Carga opciones para todos los selects (value + descripción) */
    private function options(): array
    {
        return [
            'types' => Type::orderBy('type_value')->get(['type_id','type_value','description']),
            'licenses' => License::orderBy('license_value')->get(['license_id','license_value','description']),
            'rightsHolders' => Rightsholder::orderBy('rightsHolder_value')->get(['rightsHolder_id','rightsHolder_value','description']),
            'accessRights' => Accessrights::orderBy('accessrights_value')->get(['accessrights_id','accessrights_value','description']),
            'institutionIds' => Institutionid::orderBy('institutionID_value')->get(['institution_id','institutionID_value','description']),
            'collectionIds' => Collectionid::orderBy('collection_value')->get(['collection_id','collection_value','description']),
            'institutionCodes' => Institutioncode::orderBy('institutionCode_value')->get(['institutionCode_id','institutionCode_value','description']),
            'collectionCodes' => Collectioncode::orderBy('collectionCode_value')->get(['collectionCode_id','collectionCode_value','description']),
            'ownerInstitutionCodes' => Ownerinstitutioncode::orderBy('ownerinstitutioncode_value')->get(['ownerinstitutioncode_id','ownerinstitutioncode_value','description']),
            'basisOfRecords' => Basisofrecord::orderBy('basisofrecord_value')->get(['basisofrecord_id','basisofrecord_value','description']),
        ];
    }

    /** Reglas de validación, usando Rule::exists con tabla/PK de cada modelo */
    private function validated(Request $request): array
    {
        return $request->validate([
            // FKs (nombres EXACTOS del request según tus inputs)
            'type' => [
                'required','integer',
                Rule::exists((new Type)->getTable(), (new Type)->getKeyName())
            ],
            'license' => [
                'required','integer',
                Rule::exists((new License)->getTable(), (new License)->getKeyName())
            ],
            'rightsHolder' => [
                'required','integer',
                Rule::exists((new Rightsholder)->getTable(), (new Rightsholder)->getKeyName())
            ],
            'accessRights' => [
                'required','integer',
                Rule::exists((new Accessrights)->getTable(), (new Accessrights)->getKeyName())
            ],
            'institutionID' => [
                'required','integer',
                Rule::exists((new Institutionid)->getTable(), (new Institutionid)->getKeyName())
            ],
            'collectionID' => [
                'required','integer',
                Rule::exists((new Collectionid)->getTable(), (new Collectionid)->getKeyName())
            ],
            'institutionCode' => [
                'required','integer',
                Rule::exists((new Institutioncode)->getTable(), (new Institutioncode)->getKeyName())
            ],
            'collectionCode' => [
                'required','integer',
                Rule::exists((new Collectioncode)->getTable(), (new Collectioncode)->getKeyName())
            ],
            'ownerInstitutionCode' => [
                'required','integer',
                Rule::exists((new Ownerinstitutioncode)->getTable(), (new Ownerinstitutioncode)->getKeyName())
            ],
            'basisOfRecord' => [
                'required','integer',
                Rule::exists((new Basisofrecord)->getTable(), (new Basisofrecord)->getKeyName())
            ],

            // Propios
            'modified' => ['nullable','date'],
            'language' => ['nullable','string','size:2'],
            'bibliographicCitation' => ['nullable','string'],
            'references' => ['nullable','string'],
            'datasetID' => ['nullable','string','max:100'],
            'datasetName' => ['nullable','string','max:255'],
            'informationWithheld' => ['nullable','string'],
            'dataGeneralizations' => ['nullable','string'],
        ]);
    }
}
