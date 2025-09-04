<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    protected $table = 'identification';
    protected $primaryKey = 'identificationID';
    public $incrementing = false;   // PK varchar
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'identificationID',
        'identificationQualifier',
        'typeStatus',                         // FK -> vocab_identification_typeStatus
        'identifiedBy',
        'dateIdentified',
        'identificationVerificationStatus',   // FK -> vocab_identification_verificationStatus
        'identificationRemarks',
    ];

    // Vocabs
    public function typeStatusRef()
    {
        // PK de vocab: vocab_identification_typeStatus_id
        return $this->belongsTo(
            \App\Models\Vocab\Identification\TypeStatus::class,
            'typeStatus', 'vocab_identification_typeStatus_id'
        );
    }

    public function verificationStatusRef()
    {
        // PK de vocab: vocab_identification_verificationStatus_id
        return $this->belongsTo(
            \App\Models\Vocab\Identification\VerificationStatus::class,
            'identificationVerificationStatus', 'vocab_identification_verificationStatus_id'
        );
    }
}
