<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\History;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all()->map(fn (Client $client) => [
            'id' => $client->id,
            'title' => $client->title,
            'connected' => $client->connected,
        ]);

        return Inertia::render('Client/Index', [
            'clients' => $clients,
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

    public function show(Client $client)
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $histories = $client->histories()
            ->latest('id')
            ->paginate(20);

        return Inertia::render('Client/Show', [
            'client' => [
                'id' => $client->id,
                'title' => $client->title,
                'connected' => $client->connected,
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
