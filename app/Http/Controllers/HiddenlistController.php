<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HiddenlistController extends Controller
{
    public function index()
    {
        if (! Storage::exists('hiddenlist.txt')) {
            Storage::write('hiddenlist.txt', '');
        }

        $hiddenlist = Storage::get('hiddenlist.txt');

        return Inertia::render('Hiddenlist', [
            'hiddenlist' => $hiddenlist,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hiddenlist' => ['nullable', 'string'],
        ]);

        $hiddenlist = $request->input('hiddenlist');

        Storage::write('hiddenlist.txt', $hiddenlist ?? '');

        return back();
    }
}
