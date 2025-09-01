<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Occurrence;
use Illuminate\Http\Request;

use App\Models\Vocab\Location\Continent;
use App\Models\Vocab\Location\VerbatimSrs;
use App\Models\Vocab\Location\GeorefStatus;

class OccurrenceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Occurrence::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'occurrenceID' => ['nullable'],
            'record_level_id' => ['nullable'],
            'catalogNumber' => ['nullable'],
            'recordNumber' => ['nullable'],
            'recordedBy' => ['nullable'],
            'individualCount' => ['nullable'],
            'organismQuantity' => ['nullable'],
            'organismQuantityType' => ['required'],
            'sex' => ['required'],
            'lifeStage' => ['required'],
            'reproductiveCondition' => ['required'],
            'behavior' => ['nullable'],
            'substrate' => ['nullable'],
            'establishmentMeans' => ['required'],
            'preparations' => ['nullable'],
            'disposition' => ['required'],
            'associatedMedia' => ['nullable'],
            'associatedSequences' => ['nullable'],
            'associatedTaxa' => ['nullable'],
            'otherCatalogNumbers' => ['nullable'],
            'occurrenceRemarks' => ['nullable'],
            'organismID' => ['nullable'],
            'locationID' => ['nullable'],
            'taxonID' => ['nullable'],
            'identificationID' => ['nullable']
        ]);
        $item = Occurrence::create($data);
        return response()->json($item, 201);
    }

    public function show(Occurrence $occurrence)
    {
        return $occurrence;
    }

    public function update(Request $request, Occurrence $occurrence)
    {
        $data = $request->all();
        $occurrence->update($data);
        return $occurrence;
    }

    public function destroy(Occurrence $occurrence)
    {
        $occurrence->delete();
        return response()->noContent();
    }
}
