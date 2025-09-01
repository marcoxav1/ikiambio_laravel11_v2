<?php

namespace App\Http\Controllers\Web\RecordLevel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Vocab\RecordLevel\OwnerInstitutionCode;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class OwnerInstitutionCodeController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = OwnerInstitutionCode::orderByDesc('ownerinstitutioncode_id')->paginate(15);
        return view('pages.vocab-record-level-owner-institution-code.index', compact('items'));
    }

    public function create()
    {
        return view('pages.vocab-record-level-owner-institution-code.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $item = $this->tx(fn () => OwnerInstitutionCode::create($data));
            return redirect()->route('vocab-record-level-owner-institution-code.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(OwnerInstitutionCode $ownerInstitutionCode)
    {
        return view('pages.vocab-record-level-owner-institution-code.show', ['item' => $ownerInstitutionCode]);
    }

    public function edit(OwnerInstitutionCode $ownerInstitutionCode)
    {
        return view('pages.vocab-record-level-owner-institution-code.edit', ['item' => $ownerInstitutionCode]);
    }

    public function update(Request $request, OwnerInstitutionCode $ownerInstitutionCode)
    {
        $data = $request->all();

        try {
            $this->tx(fn () => $ownerInstitutionCode->update($data));
            return redirect()->route('vocab-record-level-owner-institution-code.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(OwnerInstitutionCode $ownerInstitutionCode)
    {
        try {
            $this->tx(fn () => $ownerInstitutionCode->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
