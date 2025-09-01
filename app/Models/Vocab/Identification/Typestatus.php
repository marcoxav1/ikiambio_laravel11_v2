<?php

namespace App\Models\Vocab\Identification;

use Illuminate\Database\Eloquent\Model;

class Typestatus extends Model
{
    protected $table = 'vocab_identification_typeStatus';
    protected $primaryKey = 'vocab_identification_typeStatus_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['typeStatus_value', 'description'];
}
