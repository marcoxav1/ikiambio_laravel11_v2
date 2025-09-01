<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblextracciones;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblextraccionesController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblextracciones::orderByDesc('id')->paginate(15);
        return view('pages.tblextracciones.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblextracciones.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblextracciones::create($data));
            return redirect()->route('tblextracciones.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblextracciones $tblextracciones)
    {
        return view('pages.tblextracciones.show', ['item' => $tblextracciones]);
    }

    public function edit(Tblextracciones $tblextracciones)
    {
        return view('pages.tblextracciones.edit', ['item' => $tblextracciones]);
    }

    public function update(Request $request, Tblextracciones $tblextracciones)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblextracciones->update($data));
            return redirect()->route('tblextracciones.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblextracciones $tblextracciones)
    {
        try {
            $this->tx(fn () => $tblextracciones->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
