<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->map(fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
            'connected' => $user->connected,
        ]);

        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $histories = $user->histories()
            ->latest('id')
            ->paginate(20);

        return Inertia::render('User/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'connected' => $user->connected,
            ],
            'histories' => $histories->through(fn (History $history) => [
                'id' => $history->id,
                'url' => $history->url,
                'hostname' => $history->hostname,
                'blocked' => $history->blocked,
                'created_at' => $history->created_at->format('Y/m/d H:i'),
            ]),
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
