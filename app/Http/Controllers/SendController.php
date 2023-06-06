<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SendController extends Controller
{
    protected int $extendConnectedMinutes = 12;

    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'histories' => ['array'],
            'histories.*.url' => ['required', 'string', 'max:255'],
            'histories.*.hostname' => ['required', 'string', 'max:255'],
            'histories.*.created_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ]);

        /** @var \App\Models\User */
        $user = $request->user();

        $this->insertHistory($user, $validatedData['histories']);

        $user->update([
            'connected_at' => now()->addMinutes($this->extendConnectedMinutes),
        ]);

        $blacklist = $this->getBlacklist();

        return response()->json([
            'message' => 'Sent successfully',
            'blacklist' => $blacklist,
        ]);
    }

    protected function insertHistory(User $user, array $histories): void
    {
        $columns = ['url', 'hostname', 'created_at', 'updated_at', 'user_id'];

        $data = collect($histories)
            ->map(fn (array $history) => [
                $history['url'],
                $history['hostname'],
                $history['created_at'],
                $history['created_at'],
                $user->id,
            ])
            ->toArray();

        if (count($data)) {
            History::batchInsert($columns, $data);
        }
    }

    protected function getBlacklist()
    {
        if (! Storage::exists('blacklist.txt')) {
            Storage::write('blacklist.txt', '');
        }

        return Storage::get('blacklist.txt');
    }
}
