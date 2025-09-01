<?php

namespace App\Models\Vocab\Identification;

use Illuminate\Database\Eloquent\Model;

class Verificationstatus extends Model
{
    protected $table = 'vocab_identification_verificationStatus';
    protected $primaryKey = 'vocab_identification_verificationStatus_id';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['identificationVerificationStatus_value', 'description'];
}
