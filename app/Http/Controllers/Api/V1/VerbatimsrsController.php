<?php

namespace App\Http\Controllers\Api\V1\Location;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Location\Verbatimsrs;
use Illuminate\Http\Request;

class VerbatimsrsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Verbatimsrs::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'verbatimSRS_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Verbatimsrs::create($data);
        return response()->json($item, 201);
    }

    public function show(Verbatimsrs $verbatimsrs)
    {
        return $verbatimsrs;
    }

    public function update(Request $request, Verbatimsrs $verbatimsrs)
    {
        $data = $request->all();
        $verbatimsrs->update($data);
        return $verbatimsrs;
    }

    public function destroy(Verbatimsrs $verbatimsrs)
    {
        $verbatimsrs->delete();
        return response()->noContent();
    }
}
