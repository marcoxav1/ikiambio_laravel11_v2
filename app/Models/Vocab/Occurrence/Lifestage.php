<?php

namespace App\Models\Vocab\Occurrence;

use Illuminate\Database\Eloquent\Model;

class Lifestage extends Model
{
    protected $table = 'vocab_occurrence_lifeStage';
    protected $primaryKey = 'lifestage_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['lifestage_value', 'description'];
}
