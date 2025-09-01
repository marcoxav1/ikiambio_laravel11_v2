<?php

namespace App\Models\Vocab\RecordLevel;

use Illuminate\Database\Eloquent\Model;

class RightsHolder extends Model
{
    // OJO: en tu SQL la tabla está con H mayúscula y va entre comillas → respeta exactamente el nombre
    protected $table = 'vocab_record_level_rightsHolder';

    // PK según tu SQL:
    protected $primaryKey = 'rightsHolder_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // No usas created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'rightsHolder_value',
        'description',
    ];
}
