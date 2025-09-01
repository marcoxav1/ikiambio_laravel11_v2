<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblextracciones extends Model
{
    protected $table = 'TblExtracciones';
    protected $primaryKey = 'idExtracciones';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_occ_bd', 'materialSampleType', 'idRegistros', 'fechaExtraccion', 'purificationMethod', 'methodDeterminationConcentrationAndRatios', 'adn_enSTOCK', 'volume', 'volumeUnit', 'concentration', 'concentrationUnit', 'ratioOfAbsorbance260_280', 'ratioOfAbsorbance260_230', 'preservationType', 'preservationTemperature', 'preservationDateBegin', 'quality', 'qualityCheckDate', 'sieving', 'codigoMuestraBiobanco', 'codigoADNBiobanco', 'codigoGermoplasmaBiobanco', 'extractionStaff', 'qualityRemarks'];
}
