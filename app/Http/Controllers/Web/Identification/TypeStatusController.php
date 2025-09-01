<?php

namespace App\Http\Controllers\Web\Identification;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\Identification\TypeStatus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TypeStatusController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = TypeStatus::orderByDesc('vocab_identification_typeStatus_id')->paginate(15);
        return view('pages.vocab-identification-type-status.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-identification-type-status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => TypeStatus::create($data));
            return redirect()->route('vocab-identification-type-status.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(TypeStatus $typeStatus)
    {
        return view('pages.vocab-identification-type-status.show', ['item' => $typeStatus]);
    }

    public function edit(TypeStatus $typeStatus)
    {
        return view('pages.vocab-identification-type-status.edit', ['item' => $typeStatus]);
    }

    public function update(Request $request, TypeStatus $typeStatus)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $typeStatus->update($data));
            return redirect()->route('vocab-identification-type-status.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(TypeStatus $typeStatus)
    {
        try {
            $this->tx(fn () => $typeStatus->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
