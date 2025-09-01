<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Type::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_value' => ['required'],
            'description' => ['required']
        ]);
        $item = Type::create($data);
        return response()->json($item, 201);
    }

    public function show(Type $type)
    {
        return $type;
    }

    public function update(Request $request, Type $type)
    {
        $data = $request->all();
        $type->update($data);
        return $type;
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return response()->noContent();
    }
}
