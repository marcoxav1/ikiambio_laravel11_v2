<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    protected $table = 'occurrence';
    protected $primaryKey = 'id_occ_bd';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'occurrenceID',
        'record_level_id',
        'catalogNumber',
        'recordNumber',
        'recordedBy',
        'individualCount',
        'organismQuantity',
        'organismQuantityType',
        'sex',
        'lifeStage',
        'reproductiveCondition',
        'behavior',
        'substrate',
        'establishmentMeans',
        'preparations',
        'disposition',
        'associatedMedia',
        'associatedSequences',
        'associatedTaxa',
        'otherCatalogNumbers',
        'occurrenceRemarks',
        'organismID',
        'locationID',
        'taxonID',
        'identificationID',
    ];

    protected $casts = [
        'individualCount'   => 'integer',
        'organismQuantity'  => 'float',
    ];

    // ===================== Relaciones (sufijo Ref) =====================

    // A record_level (FK: record_level_id -> record_level.record_level_id)
    public function recordLevelRef()
    {
        return $this->belongsTo(\App\Models\RecordLevel::class, 'record_level_id', 'record_level_id');
    }

    // Vocabs de Occurrence
    public function organismQuantityTypeRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Organismquantitytype::class, 'organismQuantityType', 'oqtype_id');
    }

    public function sexRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Sex::class, 'sex', 'sex_id');
    }

    public function lifeStageRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Lifestage::class, 'lifeStage', 'lifestage_id');
    }

    public function reproductiveConditionRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Reproductivecondition::class, 'reproductiveCondition', 'reprocond_id');
    }

    public function establishmentMeansRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Establishmentmeans::class, 'establishmentMeans', 'estabmeans_id');
    }

    public function dispositionRef()
    {
        return $this->belongsTo(\App\Models\Vocab\Occurrence\Disposition::class, 'disposition', 'disposition_id');
    }

    // relaciones con las otras tablas
    public function organismRef()
    {
        return $this->belongsTo(\App\Models\Organism::class, 'organismID', 'organismID');
    }
    public function locationRef()
    {
        return $this->belongsTo(\App\Models\Location::class, 'locationID', 'locationID');
    }
    public function taxonRef()
    {
        return $this->belongsTo(\App\Models\Taxon::class, 'taxonID', 'taxonID');
    }
    public function identificationRef()
    {
        return $this->belongsTo(\App\Models\Identification::class, 'identificationID', 'identificationID');
    }

    // (Opcional) si luego creas modelos para MeasurementOrFacts / TblExtracciones,
    // te recomiendo revisar tipos (allí id_occ_bd es varchar) para evitar cast explícito.
}
