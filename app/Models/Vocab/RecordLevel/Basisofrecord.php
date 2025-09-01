<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Basisofrecord extends Model
{
    protected $table = 'vocab_record_level_basisOfRecord';
    protected $primaryKey = 'basisofrecord_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['basisofrecord_value', 'description'];
}
