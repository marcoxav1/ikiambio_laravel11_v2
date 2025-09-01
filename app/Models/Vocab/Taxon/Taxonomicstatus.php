<?php

namespace App\Models\Vocab\Taxon;

use Illuminate\Database\Eloquent\Model;

class Taxonomicstatus extends Model
{
    protected $table = 'vocab_taxon_taxonomicStatus';
    protected $primaryKey = 'taxonomicStatus_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['taxonomicStatus_value', 'description'];
}
