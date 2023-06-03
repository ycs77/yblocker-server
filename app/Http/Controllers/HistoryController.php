<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $user->histories()->create([
            'url' => $request->input('url'),
            'hostname' => $request->input('hostname'),
            'blocked' => $request->input('blocked'),
        ]);

        return response()->json(['message' => 'History stored'], 201);
    }
}
