<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Institutionid;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class InstitutionIdController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Institutionid::orderByDesc('institution_id')->paginate(15);
        return view('pages.vocab-record-level-institution-id.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-institution-id.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Institutionid::create($data));
            return redirect()->route('vocab-record-level-institution-id.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Institutionid $institutionId)
    {
        return view('pages.vocab-record-level-institution-id.show', ['item' => $institutionId]);
    }

    public function edit(Institutionid $institutionId)
    {
        return view('pages.vocab-record-level-institution-id.edit', ['item' => $institutionId]);
    }

    public function update(Request $request, Institutionid $institutionId)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $institutionId->update($data));
            return redirect()->route('vocab-record-level-institution-id.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Institutionid $institutionId)
    {
        try {
            $this->tx(fn () => $institutionId->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
