<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\Disposition;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DispositionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Disposition::orderByDesc('disposition_id')->paginate(15);
        return view('pages.vocab-occurrence-disposition.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-disposition.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Disposition::create($data));
            return redirect()->route('vocab-occurrence-disposition.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Disposition $disposition)
    {
        return view('pages.vocab-occurrence-disposition.show', ['item' => $disposition]);
    }

    public function edit(Disposition $disposition)
    {
        return view('pages.vocab-occurrence-disposition.edit', ['item' => $disposition]);
    }

    public function update(Request $request, Disposition $disposition)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $disposition->update($data));
            return redirect()->route('vocab-occurrence-disposition.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Disposition $disposition)
    {
        try {
            $this->tx(fn () => $disposition->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
