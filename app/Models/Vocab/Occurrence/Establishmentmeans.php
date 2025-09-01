<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Establishmentmeans extends Model
{
    protected $table = 'vocab_occurrence_establishmentMeans';
    protected $primaryKey = 'estabmeans_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['estabmeans_value', 'description'];
}
