<?php

namespace App\Http\Controllers;

use App\Charts\BrowseDomainsChart;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return Inertia::render('User/Index', [
            'users' => $users->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'connected_at' => $user->connected_at->format('Y/m/d H:i'),
                'connected' => $user->connected,
            ]),
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
        $historiesForChart = $user->histories()
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->get();
        $browseDomainsChart = BrowseDomainsChart::make($historiesForChart, 10);

        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $histories = $user->histories()
            ->latest('id')
            ->paginate(20);

        $tokens = $user->tokens()
            ->latest('id')
            ->get();

        return Inertia::render('User/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'connected_at' => $user->connected_at->format('Y/m/d H:i'),
                'connected' => $user->connected,
            ],
            'browseDomainsChart' => $browseDomainsChart,
            'histories' => $histories->through(fn (History $history) => [
                'id' => $history->id,
                'url' => $history->url,
                'hostname' => $history->hostname,
                'created_at' => $history->created_at->format('Y/m/d H:i'),
            ]),
            'tokens' => $tokens->map(fn ($token) => [
                'id' => $token->id,
                'name' => $token->name,
            ]),
            'created_token' => session('token'),
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
