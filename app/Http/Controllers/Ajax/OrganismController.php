<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Organism;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganismController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'organismID'                 => ['nullable','string','max:255'],
            'associatedOccurrences'      => ['nullable','string'],
            'associatedOrganisms'        => ['nullable','string'],
            'previousIdentifications'    => ['nullable','string'],
        ]);

        $id = $data['organismID'] ?? Str::uuid()->toString();

        DB::transaction(function () use (&$id, $data) {
            $org = Organism::updateOrCreate(
                ['organismID' => $id],
                [
                    'associatedOccurrences'   => $data['associatedOccurrences']   ?? null,
                    'associatedOrganisms'     => $data['associatedOrganisms']     ?? null,
                    'previousIdentifications' => $data['previousIdentifications'] ?? null,
                ]
            );
            $id = $org->organismID;
        });

        return response()->json(['ok' => true, 'id' => $id]);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') return response()->json([]);

        // Para PostgreSQL: usar ILIKE (case-insensitive)
        $like = "%{$q}%";

        $rows = \App\Models\Organism::query()
            ->where('organismID', 'ilike', $like)
            ->orWhere('associatedOccurrences', 'ilike', $like)
            ->orWhere('associatedOrganisms', 'ilike', $like)
            ->orWhere('previousIdentifications', 'ilike', $like)
            ->orderBy('organismID')
            ->limit(20)
            ->get(['organismID', 'associatedOccurrences', 'associatedOrganisms', 'previousIdentifications']);

        $items = $rows->map(function ($r) {
            $pieces = array_filter([
                $r->associatedOccurrences ? 'occ: '.\Illuminate\Support\Str::limit($r->associatedOccurrences, 30) : null,
                $r->associatedOrganisms ? 'org: '.\Illuminate\Support\Str::limit($r->associatedOrganisms, 30) : null,
                $r->previousIdentifications ? 'prev: '.\Illuminate\Support\Str::limit($r->previousIdentifications, 30) : null,
            ]);
            $text = $r->organismID.(count($pieces) ? ' — '.implode(' | ', $pieces) : '');
            return ['id' => $r->organismID, 'text' => $text];
        });

        return response()->json($items);
    }
}
