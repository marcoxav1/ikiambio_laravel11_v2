<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblprimersf;
use Illuminate\Http\Request;

class TblprimersfController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Tblprimersf::paginate($perPage);
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
        $item = Tblprimersf::create($data);
        return response()->json($item, 201);
    }

    public function show(Tblprimersf $tblprimersf)
    {
        return $tblprimersf;
    }

    public function update(Request $request, Tblprimersf $tblprimersf)
    {
        $data = $request->all();
        $tblprimersf->update($data);
        return $tblprimersf;
    }

    public function destroy(Tblprimersf $tblprimersf)
    {
        $tblprimersf->delete();
        return response()->noContent();
    }
}
