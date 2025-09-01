<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RecordLevel;
use Illuminate\Http\Request;

class RecordLevelController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return RecordLevel::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'modified' => ['nullable'],
            'language' => ['nullable'],
            'license' => ['required'],
            'rightsHolder' => ['required'],
            'accessRights' => ['required'],
            'bibliographicCitation' => ['nullable'],
            'references' => ['nullable'],
            'institutionID' => ['required'],
            'collectionID' => ['required'],
            'datasetID' => ['nullable'],
            'institutionCode' => ['required'],
            'collectionCode' => ['required'],
            'datasetName' => ['nullable'],
            'ownerInstitutionCode' => ['required'],
            'basisOfRecord' => ['required'],
            'informationWithheld' => ['nullable'],
            'dataGeneralizations' => ['nullable']
        ]);
        $item = RecordLevel::create($data);
        return response()->json($item, 201);
    }

    public function show(RecordLevel $recordLevel)
    {
        return $recordLevel;
    }

    public function update(Request $request, RecordLevel $recordLevel)
    {
        $data = $request->all();
        $recordLevel->update($data);
        return $recordLevel;
    }

    public function destroy(RecordLevel $recordLevel)
    {
        $recordLevel->delete();
        return response()->noContent();
    }
}
