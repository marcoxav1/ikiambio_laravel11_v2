<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\IkiambioUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IkiambioUserController extends Controller
{
    /* public function index()
    {
        return IkiambioUser::orderByDesc('createdDate')->paginate(15);
    } */

    public function index(\Illuminate\Http\Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 1), 1), 100);
        $q = trim((string) $request->query('q', ''));

        $query = \App\Models\IkiambioUser::query()->orderByDesc('createdDate');

        if ($q !== '') {
            // Para PostgreSQL: operador ILIKE (case-insensitive)
            $like = "%{$q}%";
            $query->where(function ($w) use ($like) {
                $w->where('firstName', 'ilike', $like)
                ->orWhere('lastName', 'ilike', $like)
                ->orWhere('username', 'ilike', $like)
                ->orWhere('identification', 'ilike', $like);
            });
        }

        return $query->paginate($perPage);
    }    

    public function store(Request $request)
    {
        $data = $request->validate([
            'utplId'        => ['nullable','string','max:255','unique:ikiambio_users,utplId'],
            'firstName'     => ['required','string','max:255'],
            'lastName'      => ['required','string','max:255'],
            'identification'=> ['nullable','string','max:255','unique:ikiambio_users,identification'],
            'username'      => ['required','string','max:255','unique:ikiambio_users,username'],
        ]);

        $user = IkiambioUser::create($data);
        return response()->json($user, 201);
    }

    public function show(IkiambioUser $ikiambioUser)
    {
        return $ikiambioUser;
    }

    public function update(Request $request, IkiambioUser $ikiambioUser)
    {
        $data = $request->validate([
            'utplId'        => ['nullable','string','max:255', Rule::unique('ikiambio_users','utplId')->ignore($ikiambioUser->id)],
            'firstName'     => ['required','string','max:255'],
            'lastName'      => ['required','string','max:255'],
            'identification'=> ['nullable','string','max:255', Rule::unique('ikiambio_users','identification')->ignore($ikiambioUser->id)],
            'username'      => ['required','string','max:255', Rule::unique('ikiambio_users','username')->ignore($ikiambioUser->id)],
        ]);

        $ikiambioUser->update($data);
        return $ikiambioUser;
    }

    public function destroy(IkiambioUser $ikiambioUser)
    {
        $ikiambioUser->delete();
        return response()->noContent();
    }
}
