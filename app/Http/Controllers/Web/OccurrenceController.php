<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Occurrence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

// ===== Vocabs para OCCURRENCE =====
use App\Models\Vocab\Occurrence\Organismquantitytype;
use App\Models\Vocab\Occurrence\Sex;
use App\Models\Vocab\Occurrence\Lifestage;
use App\Models\Vocab\Occurrence\Reproductivecondition;
use App\Models\Vocab\Occurrence\Establishmentmeans;
use App\Models\Vocab\Occurrence\Disposition;

// ===== Vocabs para RECORD LEVEL =====
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

// ===== Vocabs para LOCATION =====
use App\Models\Vocab\Location\Continent;
use App\Models\Vocab\Location\Verbatimsrs;       // verifica: a veces la clase se llama VerbatimSrs
use App\Models\Vocab\Location\Georefstatus;

// ===== Vocabs para TAXON =====
use App\Models\Vocab\Taxon\TaxonRank;
use App\Models\Vocab\Taxon\TaxonomicStatus;

// ===== Vocabs para IDENTIFICATION =====
use App\Models\Vocab\Identification\TypeStatus;
use App\Models\Vocab\Identification\VerificationStatus;

use App\Models\Organism;
use App\Models\Location;
use App\Models\Taxon;
use App\Models\Identification;
use App\Models\RecordLevel;


class OccurrenceController extends Controller
{
    public function index()
    {
        $items = Occurrence::with([
            'recordLevelRef',
            'organismQuantityTypeRef','sexRef','lifeStageRef','reproductiveConditionRef',
            'establishmentMeansRef','dispositionRef',
            'organismRef',
        ])
        ->orderByDesc('id_occ_bd')
        ->paginate(15);

        return view('pages.occurrence.index', compact('items'));
    }

    public function create()
    {
        // lo que ya pasabas (recordLevels, oqtypes, sexes, etc.)
        $recordLevels   = RecordLevel::orderBy('record_level_id','desc')->get(['record_level_id','datasetName']);
        $oqtypes        = Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes          = Sex::orderBy('sex_value')->get(['sex_id','sex_value']);
        $lifeStages     = LifeStage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value']);
        $reproConds     = ReproductiveCondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value']);
        $estabMeans     = EstablishmentMeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value']);
        $dispositions   = Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value']);

        // NUEVO: selects de Location
        $continents     = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = VerbatimSrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = GeorefStatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        return view('pages.occurrence.create', compact(
            'recordLevels','oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            'continents','verbatimSrs','georefStatuses'
        ));
    }

    public function createWizard()
    {
        // Catálogos para la pestaña Occurrence
        $oqtypes      = Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes        = Sex::orderBy('sex_value')->get(['sex_id','sex_value','description']);
        $lifeStages   = Lifestage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value','description']);
        $reproConds   = Reproductivecondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value','description']);
        $estabMeans   = Establishmentmeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value','description']);
        $dispositions = Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value','description']);

        // Catálogos para la pestaña Record Level
        $types                = Type::orderBy('type_value')->get(['type_id','type_value','description']);
        $licenses             = License::orderBy('license_value')->get(['license_id','license_value','description']);
        $rightsHolders        = Rightsholder::orderBy('rightsHolder_value')->get(['rightsHolder_id','rightsHolder_value','description']);
        $accessRights         = Accessrights::orderBy('accessrights_value')->get(['accessrights_id','accessrights_value','description']);
        $institutionIds       = Institutionid::orderBy('institutionID_value')->get(['institution_id','institutionID_value','description']);
        $collectionIds        = Collectionid::orderBy('collection_value')->get(['collection_id','collection_value','description']);
        $institutionCodes     = Institutioncode::orderBy('institutionCode_value')->get(['institutionCode_id','institutionCode_value','description']);
        $collectionCodes      = Collectioncode::orderBy('collectionCode_value')->get(['collectionCode_id','collectionCode_value','description']);
        $ownerInstitutionCodes= Ownerinstitutioncode::orderBy('ownerinstitutioncode_value')->get(['ownerinstitutioncode_id','ownerinstitutioncode_value','description']);
        $basisOfRecords       = Basisofrecord::orderBy('basisofrecord_value')->get(['basisofrecord_id','basisofrecord_value','description']);

        // Catálogos para Location
        $continents      = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = Verbatimsrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses  = Georefstatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        // Catálogos para Taxon
        $taxonRanks         = TaxonRank::orderBy('taxonRank_value')->get(['taxonRank_id','taxonRank_value']);
        $taxonomicStatuses  = TaxonomicStatus::orderBy('taxonomicStatus_value')->get(['taxonomicStatus_id','taxonomicStatus_value']);

        // Catálogos para Identification
        $idTypeStatuses  = TypeStatus::orderBy('typeStatus_value')->get(['vocab_identification_typeStatus_id','typeStatus_value']);
        $idVerifStatuses = VerificationStatus::orderBy('identificationVerificationStatus_value')->get(['vocab_identification_verificationStatus_id','identificationVerificationStatus_value']);

        $recordLevels = RecordLevel::orderByDesc('record_level_id')
            ->limit(50)
            ->get(['record_level_id','datasetName']);

         return view('pages.occurrence.create_wizard', compact(
            // Occurrence vocabs...
            'oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            // Record level vocabs...
            'types','licenses','rightsHolders','accessRights','institutionIds','collectionIds','institutionCodes','collectionCodes','ownerInstitutionCodes','basisOfRecords',
            // Location vocabs...
            'continents','verbatimSrs','georefStatuses',
            // Taxon vocabs...
            'taxonRanks','taxonomicStatuses',
            // Identification vocabs...
            'idTypeStatuses','idVerifStatuses',
            // >>> añade esto <<<
            'recordLevels'
        ));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request); // tu validación actual (puedes dejar estos 4 como 'nullable|string')

        DB::transaction(function () use (&$data) {
            // 1) crear/reusar relacionados
            $data['organismID']       = $this->upsertOrganism($data['organismID'] ?? null);
            $data['locationID']       = $this->upsertLocation($data['locationID'] ?? null);
            $data['taxonID']          = $this->upsertTaxon($data['taxonID'] ?? null);
            $data['identificationID'] = $this->upsertIdentification($data['identificationID'] ?? null);

            // 2) crear occurrence
            \App\Models\Occurrence::create($data);
        });

        return redirect()->route('occurrence.index')->with('ok','Creado');
    }



    public function show(Occurrence $occurrence)
    {
        $occurrence->load([
            'recordLevelRef',
            'organismQuantityTypeRef','sexRef','lifeStageRef','reproductiveConditionRef',
            'establishmentMeansRef','dispositionRef',
            'organismRef',
        ]);

        return view('pages.occurrence.show', ['item' => $occurrence]);
    }

    public function edit(Occurrence $occurrence)
    {
        // …los mismos loads que arriba…
        $recordLevels   = RecordLevel::orderBy('record_level_id','desc')->get(['record_level_id','datasetName']);
        $oqtypes        = Organismquantitytype::orderBy('oqtype_value')->get(['oqtype_id','oqtype_value','description']);
        $sexes          = Sex::orderBy('sex_value')->get(['sex_id','sex_value']);
        $lifeStages     = LifeStage::orderBy('lifestage_value')->get(['lifestage_id','lifestage_value']);
        $reproConds     = ReproductiveCondition::orderBy('reprocond_value')->get(['reprocond_id','reprocond_value']);
        $estabMeans     = EstablishmentMeans::orderBy('estabmeans_value')->get(['estabmeans_id','estabmeans_value']);
        $dispositions   = Disposition::orderBy('disposition_value')->get(['disposition_id','disposition_value']);

        // NUEVO
        $continents     = Continent::orderBy('continent_value')->get(['continent_id','continent_value']);
        $verbatimSrs    = VerbatimSrs::orderBy('verbatimSRS_value')->get(['verbatimSRS_id','verbatimSRS_value']);
        $georefStatuses = GeorefStatus::orderBy('georef_status_value')->get(['georef_status_id','georef_status_value']);

        $item = $occurrence;

        return view('pages.occurrence.edit', compact(
            'item',
            'recordLevels','oqtypes','sexes','lifeStages','reproConds','estabMeans','dispositions',
            'continents','verbatimSrs','georefStatuses'
        ));
    }

    public function update(Request $request, Occurrence $occurrence)
    {
        $data = $this->validated($request, $occurrence);

        DB::transaction(function () use (&$data, $occurrence) {
            $data['organismID']       = $this->upsertOrganism($data['organismID'] ?? $occurrence->organismID);
            $data['locationID']       = $this->upsertLocation($data['locationID'] ?? $occurrence->locationID);
            $data['taxonID']          = $this->upsertTaxon($data['taxonID'] ?? $occurrence->taxonID);
            $data['identificationID'] = $this->upsertIdentification($data['identificationID'] ?? $occurrence->identificationID);

            $occurrence->update($data);
        });

        return redirect()->route('occurrence.index')->with('ok','Actualizado');
    }

   /*  public function destroy(Occurrence $occurrence)
    {
        DB::transaction(function () use ($occurrence) {
            $occurrence->delete();
        });

        return back()->with('ok','Eliminado');
    } */

    public function destroy(Occurrence $occurrence)
    {
        DB::transaction(function () use ($occurrence) {
            // Guarda llaves antes del delete de occurrence
            $rid    = $occurrence->record_level_id;         // int
            $ident  = $occurrence->identificationID;        // varchar
            $idOcc  = (string) $occurrence->id_occ_bd;      // PK (int) -> para tablas con varchar

            // 1) Borra la occurrence primero (evita FKs hacia record_level)
            $occurrence->delete();

            // 2) Borra record_level 1–a–1 (si existe)
            if ($rid) {
                RecordLevel::where('record_level_id', $rid)->delete();
            }

            // 3) Borra identificación vinculada (siempre, según tu regla)
            if ($ident) {
                Identification::where('identificationID', $ident)->delete();
            }

            // 4) Borra dependientes por id_occ_bd
            DB::table('TblExtracciones')->where('id_occ_bd', $idOcc)->delete();
            DB::table('measurementorfacts')->where('id_occ_bd', $idOcc)->delete();
        });

        return back()->with('ok', 'Occurrence y sus dependencias fueron eliminadas.');
    }    

    // ================= Helpers =================

    private function options(): array
    {
        return [
            'recordLevels' => RecordLevel::orderByDesc('record_level_id')
                ->get(['record_level_id','datasetName']),

            'oqtypes' => Organismquantitytype::orderBy('oqtype_value')
                ->get(['oqtype_id','oqtype_value','description']),

            'sexes' => Sex::orderBy('sex_value')
                ->get(['sex_id','sex_value','description']),

            'lifeStages' => Lifestage::orderBy('lifestage_value')
                ->get(['lifestage_id','lifestage_value','description']),

            'reproConds' => Reproductivecondition::orderBy('reprocond_value')
                ->get(['reprocond_id','reprocond_value','description']),

            'estabMeans' => Establishmentmeans::orderBy('estabmeans_value')
                ->get(['estabmeans_id','estabmeans_value','description']),

            'dispositions' => Disposition::orderBy('disposition_value')
                ->get(['disposition_id','disposition_value','description']),

            // Si quieres sugerir organisms existentes:
            // 'organisms' => Organism::orderBy('organismID')->get(['organismID']),
        ];
    }

    private function validated(Request $request, ?Occurrence $occurrence = null): array
    {
        $id = $occurrence?->getKey();

        return $request->validate([
            'occurrenceID' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'occurrenceID')->ignore($id, 'id_occ_bd'),
            ],
            'record_level_id' => ['nullable','integer', Rule::exists((new RecordLevel)->getTable(),'record_level_id')],

            'catalogNumber' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'catalogNumber')->ignore($id, 'id_occ_bd'),
            ],

            'recordNumber' => ['nullable','string'],
            'recordedBy'   => ['nullable','string'],

            'individualCount' => ['nullable','integer'],
            'organismQuantity'=> ['nullable','numeric'],

            'organismQuantityType' => ['required','integer', Rule::exists((new Organismquantitytype)->getTable(),'oqtype_id')],
            'sex'                 => ['required','integer', Rule::exists((new Sex)->getTable(),'sex_id')],
            'lifeStage'           => ['required','integer', Rule::exists((new Lifestage)->getTable(),'lifestage_id')],
            'reproductiveCondition'=> ['required','integer', Rule::exists((new Reproductivecondition)->getTable(),'reprocond_id')],
            'establishmentMeans'  => ['required','integer', Rule::exists((new Establishmentmeans)->getTable(),'estabmeans_id')],
            'disposition'         => ['required','integer', Rule::exists((new Disposition)->getTable(),'disposition_id')],

            'behavior'            => ['nullable','string'],
            'substrate'           => ['nullable','string'],
            'preparations'        => ['nullable','string'],
            'associatedMedia'     => ['nullable','string'],
            'associatedSequences' => ['nullable','string'],
            'associatedTaxa'      => ['nullable','string'],
            'otherCatalogNumbers' => ['nullable','string'],
            'occurrenceRemarks'   => ['nullable','string'],

            'organismID'          => ['nullable','string'], // si quieres validar que exista: Rule::exists((new Organism)->getTable(),'organismID')
            'locationID'          => ['nullable','string'],
            'taxonID'             => ['nullable','string'],

            'identificationID' => [
                'nullable','string',
                Rule::unique((new Occurrence)->getTable(), 'identificationID')->ignore($id, 'id_occ_bd'),
            ],
        ]);
    }

    private function ensureStringPk(?string $id): string
    {
        // Si el usuario no envía un ID, generamos uno
        return $id && trim($id) !== '' ? trim($id) : (string) Str::uuid();
    }

    private function upsertOrganism(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        // Puedes pasar más campos si los tienes en el form
        Organism::firstOrCreate(['organismID' => $id], [
            'associatedOccurrences' => null,
            'associatedOrganisms'   => null,
            'previousIdentifications'=> null,
        ]);
        return $id;
    }

    private function upsertLocation(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Location::firstOrCreate(['locationID' => $id], []);
        return $id;
    }

    private function upsertTaxon(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Taxon::firstOrCreate(['taxonID' => $id], []);
        return $id;
    }

    private function upsertIdentification(?string $rawId): string
    {
        $id = $this->ensureStringPk($rawId);
        Identification::firstOrCreate(['identificationID' => $id], []);
        return $id;
    }


}
