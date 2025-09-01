<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Rightsholder;
use Illuminate\Http\Request;

class RightsholderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Rightsholder::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rightsHolder_value' => ['nullable'],
            'description' => ['nullable']
        ]);
        $item = Rightsholder::create($data);
        return response()->json($item, 201);
    }

    public function show(Rightsholder $rightsholder)
    {
        return $rightsholder;
    }

    public function update(Request $request, Rightsholder $rightsholder)
    {
        $data = $request->all();
        $rightsholder->update($data);
        return $rightsholder;
    }

    public function destroy(Rightsholder $rightsholder)
    {
        $rightsholder->delete();
        return response()->noContent();
    }
}
