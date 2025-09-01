<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxon extends Model
{
    protected $table = 'taxon';
    protected $primaryKey = 'taxonID';
    public $incrementing = false;     // PK string
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'taxonID',
        'scientificNameID',
        'scientificName',
        'namePublishedIn',
        'namePublishedInYear',
        'higherClassification',
        'kingdom','phylum','class','order','family','genus','subgenus',
        'specificEpithet','intraspecificEpithet',
        'taxonRank',                // FK -> vocab_taxon_taxonRank.taxonRank_id
        'verbatimTaxonRank',
        'scientificNameAuthorship',
        'vernacularName',
        'taxonomicStatus',          // FK -> vocab_taxon_taxonomicStatus.taxonomicStatus_id
        'taxonRemarks',
    ];

    // Para que el route model binding use taxonID en /taxon/{taxon}
    public function getRouteKeyName()
    {
        return 'taxonID';
    }

    // ===== Relaciones a vocabularios =====
    public function taxonRankRef()
    {
        return $this->belongsTo(
            \App\Models\Vocab\Taxon\TaxonRank::class,
            'taxonRank',          // FK en esta tabla
            'taxonRank_id'        // PK en la tabla vocab
        );
    }

    public function taxonomicStatusRef()
    {
        return $this->belongsTo(
            \App\Models\Vocab\Taxon\TaxonomicStatus::class,
            'taxonomicStatus',    // FK en esta tabla
            'taxonomicStatus_id'  // PK en la tabla vocab
        );
    }
}
