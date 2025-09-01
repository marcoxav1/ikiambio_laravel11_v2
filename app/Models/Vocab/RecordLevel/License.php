<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'vocab_record_level_license';
    protected $primaryKey = 'license_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['license_value', 'description'];
}
