<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Lifestage;
use Illuminate\Http\Request;

class LifestageController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Lifestage::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lifestage_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Lifestage::create($data);
        return response()->json($item, 201);
    }

    public function show(Lifestage $lifestage)
    {
        return $lifestage;
    }

    public function update(Request $request, Lifestage $lifestage)
    {
        $data = $request->all();
        $lifestage->update($data);
        return $lifestage;
    }

    public function destroy(Lifestage $lifestage)
    {
        $lifestage->delete();
        return response()->noContent();
    }
}
