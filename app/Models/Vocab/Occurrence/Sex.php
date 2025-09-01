<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    protected $table = 'vocab_occurrence_sex';
    protected $primaryKey = 'sex_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['sex_value', 'description'];
}
