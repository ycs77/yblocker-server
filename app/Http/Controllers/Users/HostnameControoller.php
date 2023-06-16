<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HostnameControoller extends Controller
{
    public function index(Request $request, User $user)
    {
        $results = [];

        if ($search = $request->input('search')) {
            $results = $user
                ->histories()
                ->where('hostname', 'LIKE', '%'.$search.'%')
                ->groupBy('hostname')
                ->take(10)
                ->get(['hostname'])
                ->map->hostname;
        }

        return response()->json([
            'results' => $results,
        ]);
    }
}
