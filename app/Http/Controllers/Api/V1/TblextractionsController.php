<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tblextractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class TblextractionsController extends Controller
{
    public function index(Request $request)
    {
        $pk = (new Tblextractions)->getKeyName(); // 'idExtracciones'
        $items = Tblextractions::orderByDesc($pk)->paginate(15);

        return view('pages.tbl-extracciones.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        try {
            $item = DB::transaction(function () use ($data) {
                return Tblextractions::create($data);
            });

            return response()->json($item, 201);
        } catch (QueryException $e) {
            return $this->handleQueryException($e);
        }
    }

    // OJO: si tu apiResource() usa ->parameters(['tbl-extractions' => 'extraction'])
    // la firma será (Tblextractions $extraction). Si no, ajusta al nombre real del parámetro.
    public function show(Tblextractions $extraction)
    {
        return $extraction;
    }

    public function update(Request $request, Tblextractions $extraction)
    {
        $data = $this->validateData($request, true, $extraction);

        try {
            DB::transaction(function () use ($extraction, $data) {
                $extraction->update($data);
            });

            return response()->json($extraction);
        } catch (QueryException $e) {
            return $this->handleQueryException($e);
        }
    }

    public function destroy(Tblextractions $extraction)
    {
        try {
            DB::transaction(function () use ($extraction) {
                $extraction->delete();
            });

            return response()->noContent();
        } catch (QueryException $e) {
            return $this->handleQueryException($e);
        }
    }

    // ===================== Helpers =====================

    /**
     * Reglas de validación. Para update se usan 'sometimes' y puedes
     * agregar 'ignore' en reglas únicas si lo necesitas.
     */
    private function validateData(Request $request, bool $isUpdate = false, ?Tblextractions $current = null): array
    {
        // Para update usamos 'sometimes' (solo valida lo enviado)
        $req = $isUpdate ? 'sometimes' : 'nullable';

        return $request->validate([
            // Si no envías idExtracciones, el modelo puede generarlo en booted()
            'idExtracciones' => [$req, 'string', 'max:255'],

            // Si id_occ_bd referencia occurrence.id_occ_bd (varchar):
            'id_occ_bd'      => [$req, 'string', 'max:255'], // agrega Rule::exists si quieres forzar FK

            'materialSampleType' => [$req, 'string', 'max:255'],
            'idRegistros'        => [$req, 'string', 'max:255'],

            'fechaExtraccion'    => [$req, 'date'],

            'purificationMethod' => [$req, 'string'],
            'methodDeterminationConcentrationAndRatios' => [$req, 'string'],

            // Boolean en Postgres
            'adn_enSTOCK'        => [$req, 'boolean'],

            // Numéricos / decimales
            'volume'                   => [$req, 'numeric'],
            'volumeUnit'               => [$req, 'string', 'max:50'],
            'concentration'            => [$req, 'numeric'],
            'concentrationUnit'        => [$req, 'string', 'max:50'],
            'ratioOfAbsorbance260_280' => [$req, 'numeric'],
            'ratioOfAbsorbance260_230' => [$req, 'numeric'],

            'preservationType'        => [$req, 'string', 'max:255'],
            'preservationTemperature' => [$req, 'string', 'max:255'],
            'preservationDateBegin'   => [$req, 'date'],

            'quality'                 => [$req, 'string', 'max:255'],
            'qualityCheckDate'        => [$req, 'date'],
            'sieving'                 => [$req, 'string', 'max:255'],
            'codigoMuestraBiobanco'   => [$req, 'string', 'max:255'],
            'codigoADNBiobanco'       => [$req, 'string', 'max:255'],
            'codigoGermoplasmaBiobanco'=> [$req, 'string', 'max:255'],
            'extractionStaff'         => [$req, 'string', 'max:255'],
            'qualityRemarks'          => [$req, 'string'],
        ]);
    }

    private function handleQueryException(QueryException $e)
    {
        // Log técnico
        Log::error('PG error', [
            'message'  => $e->getMessage(),
            'sql'      => method_exists($e, 'getSql') ? $e->getSql() : null,
            'bindings' => method_exists($e, 'getBindings') ? $e->getBindings() : null,
            'code'     => $e->getCode(),
        ]);

        // Respuesta legible para el cliente
        $pgCode = $e->getCode();

        // 23505 = unique_violation (duplicado)
        if ($pgCode === '23505') {
            return response()->json([
                'message' => 'Registro duplicado (clave única). Cambia el identificador o un valor único.',
            ], 409);
        }

        // 23503 = foreign_key_violation
        if ($pgCode === '23503') {
            return response()->json([
                'message' => 'Violación de llave foránea. Revisa referencias (por ejemplo id_occ_bd).',
            ], 422);
        }

        // Genérico
        return response()->json([
            'message' => 'Error al guardar/actualizar.',
            'detail'  => $e->getMessage(),
        ], 500);
    }
}
