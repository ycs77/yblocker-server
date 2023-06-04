<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'histories' => ['array'],
            'histories.*.url' => ['required', 'string', 'max:255'],
            'histories.*.hostname' => ['required', 'string', 'max:255'],
            'histories.*.blocked' => ['required', 'boolean'],
            'histories.*.created_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ]);

        /** @var \App\Models\User */
        $user = $request->user();

        $columns = ['url', 'hostname', 'blocked', 'created_at', 'updated_at', 'user_id'];

        $data = collect($validatedData['histories'])
            ->map(fn (array $history) => [
                $history['url'],
                $history['hostname'],
                $history['blocked'],
                $history['created_at'],
                $history['created_at'],
                $user->id,
            ])
            ->toArray();

        if (count($data)) {
            History::batchInsert($columns, $data);
        }

        $user->update([
            'connected_at' => now()->addMinutes(12),
        ]);

        return response()->json(['message' => 'History stored'], 201);
    }
}
