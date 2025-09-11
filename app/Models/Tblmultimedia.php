<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblmultimedia extends Model
{
    protected $table = 'TblMultimedia';
    protected $primaryKey = 'idMultimedia';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idMultimedia',
        'idRegistros',
        'type',
        'format',
        'identifier',
        'title',
        'description',
        'created',
        'creator',
        'contributor',
        'publisher',
        'license',
    ];
}
