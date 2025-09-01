<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\Type;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TypeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Type::orderByDesc('type_id')->paginate(15);
        return view('pages.vocab-record-level-type.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-type.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => Type::create($data));
            return redirect()->route('vocab-record-level-type.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Type $type)
    {
        return view('pages.vocab-record-level-type.show', ['item' => $type]);
    }

    public function edit(Type $type)
    {
        return view('pages.vocab-record-level-type.edit', ['item' => $type]);
    }

    public function update(Request $request, Type $type)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $type->update($data));
            return redirect()->route('vocab-record-level-type.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Type $type)
    {
        try {
            $this->tx(fn () => $type->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
