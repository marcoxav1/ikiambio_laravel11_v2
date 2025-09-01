<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Measurementorfacts;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MeasurementorfactsController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Measurementorfacts::orderByDesc('id')->paginate(15);
        return view('pages.measurementorfacts.index', compact('items'));
    }

    public function create()
    {
        return view('pages.measurementorfacts.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Measurementorfacts::create($data));
            return redirect()->route('measurementorfacts.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Measurementorfacts $measurementorfacts)
    {
        return view('pages.measurementorfacts.show', ['item' => $measurementorfacts]);
    }

    public function edit(Measurementorfacts $measurementorfacts)
    {
        return view('pages.measurementorfacts.edit', ['item' => $measurementorfacts]);
    }

    public function update(Request $request, Measurementorfacts $measurementorfacts)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $measurementorfacts->update($data));
            return redirect()->route('measurementorfacts.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Measurementorfacts $measurementorfacts)
    {
        try {
            $this->tx(fn () => $measurementorfacts->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
