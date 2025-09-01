<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\LifeStage;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class LifeStageController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = LifeStage::orderByDesc('lifestage_id')->paginate(15);
        return view('pages.vocab-occurrence-life-stage.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-life-stage.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => LifeStage::create($data));
            return redirect()->route('vocab-occurrence-life-stage.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(LifeStage $lifeStage)
    {
        return view('pages.vocab-occurrence-life-stage.show', ['item' => $lifeStage]);
    }

    public function edit(LifeStage $lifeStage)
    {
        return view('pages.vocab-occurrence-life-stage.edit', ['item' => $lifeStage]);
    }

    public function update(Request $request, LifeStage $lifeStage)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $lifeStage->update($data));
            return redirect()->route('vocab-occurrence-life-stage.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(LifeStage $lifeStage)
    {
        try {
            $this->tx(fn () => $lifeStage->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
