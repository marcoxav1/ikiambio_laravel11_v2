<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\ReproductiveCondition;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ReproductiveConditionController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = ReproductiveCondition::orderByDesc('vocab_occurrence_reproductiveCondition')->paginate(15);
        return view('pages.vocab-occurrence-reproductive-condition.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-reproductive-condition.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => ReproductiveCondition::create($data));
            return redirect()->route('vocab-occurrence-reproductive-condition.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(ReproductiveCondition $reproductiveCondition)
    {
        return view('pages.vocab-occurrence-reproductive-condition.show', ['item' => $reproductiveCondition]);
    }

    public function edit(ReproductiveCondition $reproductiveCondition)
    {
        return view('pages.vocab-occurrence-reproductive-condition.edit', ['item' => $reproductiveCondition]);
    }

    public function update(Request $request, ReproductiveCondition $reproductiveCondition)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $reproductiveCondition->update($data));
            return redirect()->route('vocab-occurrence-reproductive-condition.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(ReproductiveCondition $reproductiveCondition)
    {
        try {
            $this->tx(fn () => $reproductiveCondition->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
