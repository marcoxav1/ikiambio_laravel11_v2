<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Rightsholder;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RightsHolderController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Rightsholder::orderByDesc('rightsHolder_id')->paginate(15);
        return view('pages.vocab-record-level-rights-holder.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-rights-holder.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Rightsholder::create($data));
            return redirect()->route('vocab-record-level-rights-holder.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Rightsholder $rightsHolder)
    {
        return view('pages.vocab-record-level-rights-holder.show', ['item' => $rightsHolder]);
    }

    public function edit(Rightsholder $rightsHolder)
    {
        return view('pages.vocab-record-level-rights-holder.edit', ['item' => $rightsHolder]);
    }

    public function update(Request $request, Rightsholder $rightsHolder)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $rightsHolder->update($data));
            return redirect()->route('vocab-record-level-rights-holder.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Rightsholder $rightsHolder)
    {
        try {
            $this->tx(fn () => $rightsHolder->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
