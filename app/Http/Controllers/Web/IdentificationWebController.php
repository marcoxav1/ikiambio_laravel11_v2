<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentificationWebController extends Controller
{
    public function index()
    {
        $items = Identification::orderBy('identificationID')->paginate(15);
        return view('pages.identification.index', compact('items'));
    }

    public function show(Identification $identification)
    {
        $identification->load(['typeStatusRef','verificationStatusRef']);
        return view('pages.identification.show', ['item' => $identification]);
    }

    public function create()
    {
        return view('pages.identification.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['identificationID'])) $data['identificationID'] = (string) \Illuminate\Support\Str::uuid();
        DB::transaction(fn()=> Identification::create($data));
        return redirect()->route('identification.index')->with('ok','Creado');
    }

    public function edit(Identification $identification)
    {
        return view('pages.identification.edit', ['item' => $identification]);
    }

    public function update(Request $request, Identification $identification)
    {
        $data = $request->all();
        DB::transaction(fn()=> $identification->update($data));
        return redirect()->route('identification.show', $identification)->with('ok','Actualizado');
    }

    public function destroy(Identification $identification)
    {
        DB::transaction(fn()=> $identification->delete());
        return back()->with('ok','Eliminado');
    }
}
