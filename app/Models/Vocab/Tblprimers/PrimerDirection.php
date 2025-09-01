<?php

namespace App\Models\Vocab\Tblprimers;

use Illuminate\Database\Eloquent\Model;

class PrimerDirection extends Model
{
    // Nombre EXACTO de la tabla (según tu SQL)
    protected $table = 'vocab_tblprimers_primerDirection';

    // Clave primaria
    protected $primaryKey = 'id_primerdirection';
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene timestamps (created_at / updated_at)
    public $timestamps = false;

    // Asignación masiva
    protected $fillable = [
        'primerdirection_value',
        'description',
    ];
}