<?php

namespace App\Http\Controllers\Web\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Location\GeorefStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GeorefStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = GeorefStatus::orderByDesc('georef_status_id')->paginate(15);
        return view('pages.vocab-location-georef-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-location-georef-status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => GeorefStatus::create($data));
            return redirect()->route('vocab-location-georef-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(GeorefStatus $georefStatus)
    {
        return view('pages.vocab-location-georef-status.show', ['item' => $georefStatus]);
    }

    public function edit(GeorefStatus $georefStatus)
    {
        return view('pages.vocab-location-georef-status.edit', ['item' => $georefStatus]);
    }

    public function update(Request $request, GeorefStatus $georefStatus)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $georefStatus->update($data));
            return redirect()->route('vocab-location-georef-status.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(GeorefStatus $georefStatus)
    {
        try {
            $this->tx(fn () => $georefStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
