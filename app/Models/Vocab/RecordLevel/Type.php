<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'vocab_record_level_type';
    protected $primaryKey = 'type_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['type_value', 'description'];
}
