<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblextractions;
use Illuminate\Http\Request;

class TblextractionsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblextractions::paginate($perPage);
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
        $item = Tblextractions::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblextractions $tblextractions)
    {
        return $tblextractions;
    }

    public function update(Request $request, Tblextractions $tblextractions)
    {
        $data = $request->all();
        $tblextractions->update($data);
        return $tblextractions;
    }

    public function destroy(Tblextractions $tblextractions)
    {
        $tblextractions->delete();
        return response()->noContent();
    }
}
