<?php

namespace App\Http\Controllers\Api\V1\Identification;

use App\Http\Controllers\Controller;
use App\Models\Vocab\Identification\Verificationstatus;
use Illuminate\Http\Request;

class VerificationstatusController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Verificationstatus::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'identificationVerificationStatus_value' => ['required'],
            'description' => ['nullable']
        ]);
        $item = Verificationstatus::create($data);
        return response()->json($item, 201);
    }

    public function show(Verificationstatus $verificationstatus)
    {
        return $verificationstatus;
    }

    public function update(Request $request, Verificationstatus $verificationstatus)
    {
        $data = $request->all();
        $verificationstatus->update($data);
        return $verificationstatus;
    }

    public function destroy(Verificationstatus $verificationstatus)
    {
        $verificationstatus->delete();
        return response()->noContent();
    }
}
