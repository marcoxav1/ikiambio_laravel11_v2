<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocabTblprimersPrimerdirection extends Model
{
    protected $table = 'vocab_tblprimers_primerDirection';
    protected $primaryKey = 'id_primerdirection';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['primerdirection_value', 'description'];
}
