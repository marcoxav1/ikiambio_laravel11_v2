<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Institutioncode extends Model
{
    protected $table = 'vocab_record_level_institutionCode';
    protected $primaryKey = 'institutionCode_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['institutionCode_value', 'description'];
}
