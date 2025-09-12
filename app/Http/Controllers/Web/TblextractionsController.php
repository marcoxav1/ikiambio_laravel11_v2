<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Http\Controllers\Controller;
use App\Models\Tblextractions;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TblextractionsController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        
         $pk = (new Tblextractions)->getKeyName(); // 'idExtracciones'
        $items = Tblextractions::orderByDesc($pk)->paginate(15);
        
        return view('pages.tblextractions.index', compact('items'));
    }

    public function create()
    {
        return view('pages.tblextractions.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Tblextractions::create($data));
            return redirect()->route('tbl-extractions.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Tblextractions $tblextractions)
    {
        return view('pages.tblextractions.show', ['item' => $tblextractions]);
    }

    public function edit(Tblextractions $tblextractions)
    {
        return view('pages.tblextractions.edit', ['item' => $tblextractions]);
    }

    public function update(Request $request, Tblextractions $tblextractions)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $tblextractions->update($data));
            return redirect()->route('tbl-extractions.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Tblextractions $tblextractions)
    {
        try {
            $this->tx(fn () => $tblextractions->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
