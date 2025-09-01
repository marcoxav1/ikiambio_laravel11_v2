<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    protected $table = 'identification';
    protected $primaryKey = 'identificationID'; // varchar
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'identificationID','identificationQualifier','typeStatus','identifiedBy',
        'dateIdentified','identificationVerificationStatus','identificationRemarks',
    ];
}
