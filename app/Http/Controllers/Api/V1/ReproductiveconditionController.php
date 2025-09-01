<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Reproductivecondition;
use Illuminate\Http\Request;

class ReproductiveconditionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Reproductivecondition::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reprocond_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Reproductivecondition::create($data);
        return response()->json($item, 201);
    }

    public function show(Reproductivecondition $reproductivecondition)
    {
        return $reproductivecondition;
    }

    public function update(Request $request, Reproductivecondition $reproductivecondition)
    {
        $data = $request->all();
        $reproductivecondition->update($data);
        return $reproductivecondition;
    }

    public function destroy(Reproductivecondition $reproductivecondition)
    {
        $reproductivecondition->delete();
        return response()->noContent();
    }
}
