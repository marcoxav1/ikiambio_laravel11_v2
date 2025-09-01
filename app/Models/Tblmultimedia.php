<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblmultimedia extends Model
{
    protected $table = 'TblMultimedia';
    protected $primaryKey = 'idMultimedia';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idRegistros', 'type', 'format', 'identifier', 'title', 'description', 'created', 'creator', 'contributor', 'publisher', 'license'];
}
