<?php

namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Location\Continent;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Continent::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'continent_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Continent::create($data);
        return response()->json($item, 201);
    }

    public function show(Continent $continent)
    {
        return $continent;
    }

    public function update(Request $request, Continent $continent)
    {
        $data = $request->all();
        $continent->update($data);
        return $continent;
    }

    public function destroy(Continent $continent)
    {
        $continent->delete();
        return response()->noContent();
    }
}
