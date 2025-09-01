<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Http\Controllers\Controller;
use App\Models\Organism;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class OrganismWebController  extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Organism::orderByDesc('organismID')->paginate(15);
        return view('pages.organism.index', compact('items'));
    }

    public function create()
    {
        return view('pages.organism.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Organism::create($data));
            return redirect()->route('organism.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Organism $organism)
    {
        return view('pages.organism.show', ['item' => $organism]);
    }

    public function edit(Organism $organism)
    {
        return view('pages.organism.edit', ['item' => $organism]);
    }

    public function update(Request $request, Organism $organism)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $organism->update($data));
            return redirect()->route('organism.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Organism $organism)
    {
        try {
            $this->tx(fn () => $organism->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
