<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class IdentificationController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Identification::orderByDesc('id')->paginate(15);
        return view('pages.identification.index', compact('items'));
    }

    public function create()
    {
        return view('pages.identification.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Identification::create($data));
            return redirect()->route('identification.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Identification $identification)
    {
        return view('pages.identification.show', ['item' => $identification]);
    }

    public function edit(Identification $identification)
    {
        return view('pages.identification.edit', ['item' => $identification]);
    }

    public function update(Request $request, Identification $identification)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $identification->update($data));
            return redirect()->route('identification.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Identification $identification)
    {
        try {
            $this->tx(fn () => $identification->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
