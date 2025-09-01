<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblregistroslaboratorio;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblregistroslaboratorioController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblregistroslaboratorio::orderByDesc('id')->paginate(15);
        return view('pages.tblregistroslaboratorio.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblregistroslaboratorio.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblregistroslaboratorio::create($data));
            return redirect()->route('tblregistroslaboratorio.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        return view('pages.tblregistroslaboratorio.show', ['item' => $tblregistroslaboratorio]);
    }

    public function edit(Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        return view('pages.tblregistroslaboratorio.edit', ['item' => $tblregistroslaboratorio]);
    }

    public function update(Request $request, Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblregistroslaboratorio->update($data));
            return redirect()->route('tblregistroslaboratorio.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblregistroslaboratorio $tblregistroslaboratorio)
    {
        try {
            $this->tx(fn () => $tblregistroslaboratorio->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
