<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Institutioncode;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class InstitutionCodeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Institutioncode::orderByDesc('institutionCode_id')->paginate(15);
        return view('pages.vocab-record-level-institution-code.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-institution-code.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Institutioncode::create($data));
            return redirect()->route('vocab-record-level-institution-code.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Institutioncode $institutionCode)
    {
        return view('pages.vocab-record-level-institution-code.show', ['item' => $institutionCode]);
    }

    public function edit(Institutioncode $institutionCode)
    {
        return view('pages.vocab-record-level-institution-code.edit', ['item' => $institutionCode]);
    }

    public function update(Request $request, Institutioncode $institutionCode)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $institutionCode->update($data));
            return redirect()->route('vocab-record-level-institution-code.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Institutioncode $institutionCode)
    {
        try {
            $this->tx(fn () => $institutionCode->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
