<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblregistroslaboratorio;
use Illuminate\Http\Request;

class TblregistroslaboratorioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblregistroslaboratorio::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idFechaPCR' => ['nullable'],
            'idExtracciones' => ['nullable'],
            'vol_ADN_PCR' => ['nullable'],
            'amplificationSuccess' => ['nullable'],
            'amplificationSuccessDetails' => ['nullable'],
            'sampleDesignation' => ['nullable'],
            'idPrimerF' => ['nullable'],
            'idPrimerR' => ['nullable'],
            'tecnologia_secuenciacion' => ['nullable'],
            'consensusSequence' => ['nullable'],
            'fechaSecuenciacion' => ['nullable'],
            'sequencingStaff' => ['nullable'],
            'ordenSecuenciacion' => ['nullable'],
            'geneticAccessionNumber' => ['nullable'],
            'geneticAccessionURI' => ['nullable']
        ]);
        $item = Tblregistroslaboratorio::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        return $tblregistroslaboratorio;
    }

    public function update(Request $request, Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        $data = $request->all();
        $tblregistroslaboratorio->update($data);
        return $tblregistroslaboratorio;
    }

    public function destroy(Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        $tblregistroslaboratorio->delete();
        return response()->noContent();
    }
}
