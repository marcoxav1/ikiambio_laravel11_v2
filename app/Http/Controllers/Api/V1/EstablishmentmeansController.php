<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Establishmentmeans;
use Illuminate\Http\Request;

class EstablishmentmeansController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Establishmentmeans::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'estabmeans_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Establishmentmeans::create($data);
        return response()->json($item, 201);
    }

    public function show(Establishmentmeans $establishmentmeans)
    {
        return $establishmentmeans;
    }

    public function update(Request $request, Establishmentmeans $establishmentmeans)
    {
        $data = $request->all();
        $establishmentmeans->update($data);
        return $establishmentmeans;
    }

    public function destroy(Establishmentmeans $establishmentmeans)
    {
        $establishmentmeans->delete();
        return response()->noContent();
    }
}
