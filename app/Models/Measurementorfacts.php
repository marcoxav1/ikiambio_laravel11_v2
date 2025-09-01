<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurementorfacts extends Model
{
    protected $table = 'measurementorfacts';
    protected $primaryKey = 'measurementID';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_occ_bd', 'measurementType', 'measurementValue', 'measurementAccuracy', 'measurementUnit', 'measurementDeterminedBy', 'measurementDeterminedDate', 'measurementMethod', 'measurementRemarks'];
}
