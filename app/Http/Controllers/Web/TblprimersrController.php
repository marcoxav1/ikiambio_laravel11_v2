<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblprimersr;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblprimersrController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblprimersr::orderByDesc('id')->paginate(15);
        return view('pages.tblprimersr.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblprimersr.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Tblprimersr::create($data));
            return redirect()->route('tblprimersr.index')->with('ok', 'Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblprimersr $tblprimersr)
    {
        return view('pages.tblprimersr.show', ['item' => $tblprimersr]);
    }

    public function edit(Tblprimersr $tblprimersr)
    {
        return view('pages.tblprimersr.edit', ['item' => $tblprimersr]);
    }

    public function update(Request $request, Tblprimersr $tblprimersr)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $tblprimersr->update($data));
            return redirect()->route('tblprimersr.index')->with('ok', 'Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblprimersr $tblprimersr)
    {
        try {
            $this->tx(fn () => $tblprimersr->delete());
            return back()->with('ok', 'Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
