<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Collectioncode;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CollectionCodeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Collectioncode::orderByDesc('collectionCode_id')->paginate(15);
        return view('pages.vocab-record-level-collection-code.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-collection-code.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Collectioncode::create($data));
            return redirect()->route('vocab-record-level-collection-code.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Collectioncode $collectionCode)
    {
        return view('pages.vocab-record-level-collection-code.show', ['item' => $collectionCode]);
    }

    public function edit(Collectioncode $collectionCode)
    {
        return view('pages.vocab-record-level-collection-code.edit', ['item' => $collectionCode]);
    }

    public function update(Request $request, Collectioncode $collectionCode)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $collectionCode->update($data));
            return redirect()->route('vocab-record-level-collection-code.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Collectioncode $collectionCode)
    {
        try {
            $this->tx(fn () => $collectionCode->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
