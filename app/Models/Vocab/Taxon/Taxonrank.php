<?php

namespace App\Models\Vocab\Taxon;

use Illuminate\Database\Eloquent\Model;

class Taxonrank extends Model
{
    protected $table = 'vocab_taxon_taxonRank';
    protected $primaryKey = 'taxonRank_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['taxonRank_value', 'description'];
}
