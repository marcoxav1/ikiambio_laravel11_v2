<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Reproductivecondition extends Model
{
    protected $table = 'vocab_occurrence_reproductiveCondition';
    protected $primaryKey = 'reprocond_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['reprocond_value', 'description'];
}
