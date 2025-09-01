<?php

namespace App\Http\Controllers\Api\V1\Occurrence;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Occurrence\Sex;
use Illuminate\Http\Request;

class SexController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Sex::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sex_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Sex::create($data);
        return response()->json($item, 201);
    }

    public function show(Sex $sex)
    {
        return $sex;
    }

    public function update(Request $request, Sex $sex)
    {
        $data = $request->all();
        $sex->update($data);
        return $sex;
    }

    public function destroy(Sex $sex)
    {
        $sex->delete();
        return response()->noContent();
    }
}
