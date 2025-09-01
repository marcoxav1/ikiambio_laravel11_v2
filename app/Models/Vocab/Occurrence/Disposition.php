<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'vocab_occurrence_disposition';
    protected $primaryKey = 'disposition_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['disposition_value', 'description'];
}
