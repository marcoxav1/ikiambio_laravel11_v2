<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Tblfechapcr;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblfechapcrController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Tblfechapcr::orderByDesc('id')->paginate(15);
        return view('pages.tblfechapcr.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblfechapcr.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblfechapcr::create($data));
            return redirect()->route('tblfechapcr.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblfechapcr $tblfechapcr)
    {
        return view('pages.tblfechapcr.show', ['item' => $tblfechapcr]);
    }

    public function edit(Tblfechapcr $tblfechapcr)
    {
        return view('pages.tblfechapcr.edit', ['item' => $tblfechapcr]);
    }

    public function update(Request $request, Tblfechapcr $tblfechapcr)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblfechapcr->update($data));
            return redirect()->route('tblfechapcr.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblfechapcr $tblfechapcr)
    {
        try {
            $this->tx(fn () => $tblfechapcr->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
