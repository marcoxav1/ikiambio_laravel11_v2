<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Ownerinstitutioncode extends Model
{
    protected $table = 'vocab_record_level_ownerInstitutionCode';
    protected $primaryKey = 'ownerinstitutioncode_id'; 
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['ownerinstitutioncode_value', 'description'];
}
