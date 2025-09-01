<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Organismquantitytype extends Model
{
    protected $table = 'vocab_occurrence_organismQuantityType';
    protected $primaryKey = 'oqtype_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['oqtype_value', 'description'];
}
