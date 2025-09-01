<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblprimersr;
use Illuminate\Http\Request;

class TblprimersrController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblprimersr::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'genAbrev' => ['nullable'],
            'genName' => ['nullable'],
            'primerName' => ['nullable'],
            'primerSequence' => ['nullable'],
            'primerReferenceCitation' => ['nullable'],
            'id_primerDirection' => ['required'],
            'grupo_Taxonomico' => ['nullable'],
            'region' => ['nullable'],
            'tecnologia' => ['nullable'],
            'proyecto_Tesis' => ['nullable'],
            'longitud_Primer' => ['nullable'],
            'Longitud_amplicon' => ['nullable'],
            'gc' => ['nullable'],
            'dnaMeltingPoint' => ['nullable'],
            'annealing_Temperature' => ['nullable'],
            'primerStaff' => ['nullable'],
            'fecha_orden' => ['nullable'],
            'proveedor' => ['nullable']
        ]);
        $item = Tblprimersr::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblprimersr $tblprimersr)
    {
        return $tblprimersr;
    }

    public function update(Request $request, Tblprimersr $tblprimersr)
    {
        $data = $request->all();
        $tblprimersr->update($data);
        return $tblprimersr;
    }

    public function destroy(Tblprimersr $tblprimersr)
    {
        $tblprimersr->delete();
        return response()->noContent();
    }
}
