<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblextracciones;
use Illuminate\Http\Request;

class TblextraccionesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblextracciones::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_occ_bd' => ['nullable'],
            'materialSampleType' => ['nullable'],
            'idRegistros' => ['nullable'],
            'fechaExtraccion' => ['nullable'],
            'purificationMethod' => ['nullable'],
            'methodDeterminationConcentrationAndRatios' => ['nullable'],
            'adn_enSTOCK' => ['nullable'],
            'volume' => ['nullable'],
            'volumeUnit' => ['nullable'],
            'concentration' => ['nullable'],
            'concentrationUnit' => ['nullable'],
            'ratioOfAbsorbance260_280' => ['nullable'],
            'ratioOfAbsorbance260_230' => ['nullable'],
            'preservationType' => ['nullable'],
            'preservationTemperature' => ['nullable'],
            'preservationDateBegin' => ['nullable'],
            'quality' => ['nullable'],
            'qualityCheckDate' => ['nullable'],
            'sieving' => ['nullable'],
            'codigoMuestraBiobanco' => ['nullable'],
            'codigoADNBiobanco' => ['nullable'],
            'codigoGermoplasmaBiobanco' => ['nullable'],
            'extractionStaff' => ['nullable'],
            'qualityRemarks' => ['nullable']
        ]);
        $item = Tblextracciones::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblextracciones $tblextracciones)
    {
        return $tblextracciones;
    }

    public function update(Request $request, Tblextracciones $tblextracciones)
    {
        $data = $request->all();
        $tblextracciones->update($data);
        return $tblextracciones;
    }

    public function destroy(Tblextracciones $tblextracciones)
    {
        $tblextracciones->delete();
        return response()->noContent();
    }
}
