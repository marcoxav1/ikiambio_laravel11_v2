<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Organism;
use Illuminate\Http\Request;

class OrganismController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Organism::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'associatedOccurrences' => ['nullable'],
            'associatedOrganisms' => ['nullable'],
            'previousIdentifications' => ['nullable']
        ]);
        $item = Organism::create($data);
        return response()->json($item, 201);
    }

    public function show(Organism $organism)
    {
        return $organism;
    }

    public function update(Request $request, Organism $organism)
    {
        $data = $request->all();
        $organism->update($data);
        return $organism;
    }

    public function destroy(Organism $organism)
    {
        $organism->delete();
        return response()->noContent();
    }
}
