<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class Collectioncode extends Model
{
    protected $table = 'vocab_record_level_collectionCode';
    protected $primaryKey = 'collectionCode_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['collectionCode_value', 'description'];
}
