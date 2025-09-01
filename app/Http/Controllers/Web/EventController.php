<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WrapsTransactions;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EventController extends Controller
{
    use WrapsTransactions;

    public function index()
    {
        $items = Event::orderByDesc('id')->paginate(15);
        return view('pages.event.index', compact('items'));
    }

    public function create()
    {
        return view('pages.event.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->tx(fn () => Event::create($data));
            return redirect()->route('event.index')->with('ok','Creado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo crear.')->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('pages.event.show', ['item' => $event]);
    }

    public function edit(Event $event)
    {
        return view('pages.event.edit', ['item' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->all();
        try {
            $this->tx(fn () => $event->update($data));
            return redirect()->route('event.index')->with('ok','Actualizado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo actualizar.')->withInput();
        }
    }

    public function destroy(Event $event)
    {
        try {
            $this->tx(fn () => $event->delete());
            return back()->with('ok','Eliminado');
        } catch (QueryException $e) {
            return back()->withErrors('No se pudo eliminar (posibles FKs).');
        }
    }
}
