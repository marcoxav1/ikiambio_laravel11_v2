<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Accessrights extends Model
{
    protected $table = 'vocab_record_level_accessRights';
    protected $primaryKey = 'accessrights_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['accessrights_value', 'description'];
}
