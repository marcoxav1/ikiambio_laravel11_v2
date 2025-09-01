<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Disposition;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Disposition::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'disposition_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Disposition::create($data);
        return response()->json($item, 201);
    }

    public function show(Disposition $disposition)
    {
        return $disposition;
    }

    public function update(Request $request, Disposition $disposition)
    {
        $data = $request->all();
        $disposition->update($data);
        return $disposition;
    }

    public function destroy(Disposition $disposition)
    {
        $disposition->delete();
        return response()->noContent();
    }
}
