<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VocabTblprimersPrimerdirection;
use Illuminate\Http\Request;

class VocabTblprimersPrimerdirectionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return VocabTblprimersPrimerdirection::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'primerdirection_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = VocabTblprimersPrimerdirection::create($data);
        return response()->json($item, 201);
    }

    public function show(VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        return $vocabTblprimersPrimerdirection;
    }

    public function update(Request $request, VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        $data = $request->all();
        $vocabTblprimersPrimerdirection->update($data);
        return $vocabTblprimersPrimerdirection;
    }

    public function destroy(VocabTblprimersPrimerdirection $vocabTblprimersPrimerdirection)
    {
        $vocabTblprimersPrimerdirection->delete();
        return response()->noContent();
    }
}
