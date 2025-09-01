<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblmultimedia;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblmultimediaController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblmultimedia::orderByDesc('id')->paginate(15);
        return view('pages.tblmultimedia.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblmultimedia.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblmultimedia::create($data));
            return redirect()->route('tblmultimedia.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblmultimedia $tblmultimedia)
    {
        return view('pages.tblmultimedia.show', ['item' => $tblmultimedia]);
    }

    public function edit(Tblmultimedia $tblmultimedia)
    {
        return view('pages.tblmultimedia.edit', ['item' => $tblmultimedia]);
    }

    public function update(Request $request, Tblmultimedia $tblmultimedia)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblmultimedia->update($data));
            return redirect()->route('tblmultimedia.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblmultimedia $tblmultimedia)
    {
        try {
            $this->tx(fn () => $tblmultimedia->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
