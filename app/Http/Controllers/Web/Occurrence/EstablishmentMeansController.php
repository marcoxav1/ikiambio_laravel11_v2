<?php

namespace App\Http\Controllers\Web\Occurrence;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Occurrence\EstablishmentMeans;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EstablishmentMeansController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = EstablishmentMeans::orderByDesc('vocab_occurrence_establishmentMeans')->paginate(15);
        return view('pages.vocab-occurrence-establishment-means.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-occurrence-establishment-means.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => EstablishmentMeans::create($data));
            return redirect()->route('vocab-occurrence-establishment-means.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(EstablishmentMeans $establishmentMeans)
    {
        return view('pages.vocab-occurrence-establishment-means.show', ['item' => $establishmentMeans]);
    }

    public function edit(EstablishmentMeans $establishmentMeans)
    {
        return view('pages.vocab-occurrence-establishment-means.edit', ['item' => $establishmentMeans]);
    }

    public function update(Request $request, EstablishmentMeans $establishmentMeans)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $establishmentMeans->update($data));
            return redirect()->route('vocab-occurrence-establishment-means.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(EstablishmentMeans $establishmentMeans)
    {
        try {
            $this->tx(fn () => $establishmentMeans->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
