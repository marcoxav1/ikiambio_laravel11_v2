<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblprimersf;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblprimersfController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblprimersf::orderByDesc('id')->paginate(15);
        return view('pages.tblprimersf.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblprimersf.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Tblprimersf::create($data));
            return redirect()->route('tblprimersf.index')->with('ok', 'Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblprimersf $tblprimersf)
    {
        return view('pages.tblprimersf.show', ['item' => $tblprimersf]);
    }

    public function edit(Tblprimersf $tblprimersf)
    {
        return view('pages.tblprimersf.edit', ['item' => $tblprimersf]);
    }

    public function update(Request $request, Tblprimersf $tblprimersf)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $tblprimersf->update($data));
            return redirect()->route('tblprimersf.index')->with('ok', 'Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblprimersf $tblprimersf)
    {
        try {
            $this->tx(fn () => $tblprimersf->delete());
            return back()->with('ok', 'Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
