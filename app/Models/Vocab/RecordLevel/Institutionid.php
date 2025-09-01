<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Institutionid extends Model
{
    protected $table = 'vocab_record_level_institutionID';
    protected $primaryKey = 'institution_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['institutionID_value', 'description'];
}
