<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblfechapcr;
use Illuminate\Http\Request;

class TblfechapcrController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblfechapcr::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amplificationDate' => ['nullable'],
            'amplificationMethod' => ['nullable'],
            'lugar_process' => ['nullable'],
            'amplificationStaff' => ['nullable'],
            'num_reacciones' => ['nullable'],
            'volumen_finalRx' => ['nullable'],
            'masterMix' => ['nullable'],
            'clh20' => ['nullable'],
            'buffer' => ['nullable'],
            'bsa' => ['nullable'],
            'mgcl' => ['nullable'],
            'dntp' => ['nullable'],
            'primer_F' => ['nullable'],
            'primer_R' => ['nullable'],
            'taq' => ['nullable'],
            'adn' => ['nullable'],
            'equipo_PCR' => ['nullable'],
            'pre_c' => ['nullable'],
            'pretiempo' => ['nullable'],
            'pcr1_c' => ['nullable'],
            'pcr1tiempo' => ['nullable'],
            'pcr2_c' => ['nullable'],
            'pcr2tiempo' => ['nullable'],
            'pcr3_c' => ['nullable'],
            'pcr3tiempo' => ['nullable'],
            'post_c' => ['nullable'],
            'post_tiempo' => ['nullable'],
            'final_c' => ['nullable'],
            'ciclos' => ['nullable'],
            'imagenPCRAccessionURI' => ['nullable'],
            'imagenPCR' => ['nullable']
        ]);
        $item = Tblfechapcr::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblfechapcr $tblfechapcr)
    {
        return $tblfechapcr;
    }

    public function update(Request $request, Tblfechapcr $tblfechapcr)
    {
        $data = $request->all();
        $tblfechapcr->update($data);
        return $tblfechapcr;
    }

    public function destroy(Tblfechapcr $tblfechapcr)
    {
        $tblfechapcr->delete();
        return response()->noContent();
    }
}
