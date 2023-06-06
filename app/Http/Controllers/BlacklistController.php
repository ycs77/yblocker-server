<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BlacklistController extends Controller
{
    public function index()
    {
        if (! Storage::exists('blacklist.txt')) {
            Storage::write('blacklist.txt', '');
        }

        $blacklist = Storage::get('blacklist.txt');

        return Inertia::render('Blacklist', [
            'blacklist' => $blacklist,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'blacklist' => ['nullable', 'string'],
        ]);

        $blacklist = $request->input('blacklist');

        Storage::write('blacklist.txt', $blacklist ?? '');

        return back();
    }
}
