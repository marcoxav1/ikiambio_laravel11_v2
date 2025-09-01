<?php

namespace App\Http\Controllers\Api\V1\RecordLevel;

use App\Http\Controllers\Controller;
use App\Models\Vocab\RecordLevel\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return License::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'license_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = License::create($data);
        return response()->json($item, 201);
    }

    public function show(License $license)
    {
        return $license;
    }

    public function update(Request $request, License $license)
    {
        $data = $request->all();
        $license->update($data);
        return $license;
    }

    public function destroy(License $license)
    {
        $license->delete();
        return response()->noContent();
    }
}
