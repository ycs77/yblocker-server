<?php

namespace App\Http\Controllers\Users;

use App\Charts\BrowseDomainsChart;
use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

    public function show(Request $request, User $user)
    {
        return Inertia::render('User/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'connected_at' => $user->connected_at->format('Y/m/d H:i'),
                'connected' => $user->connected,
            ],
            'browseDomainsChart' => function () use ($user) {
                $historiesForChart = $user->histories()
                    ->whereBetween('created_at', [now()->subDays(7), now()])
                    ->get();

                return BrowseDomainsChart::make($historiesForChart, 10);
            },
            'histories' => function () use ($request, $user) {
                /** @var \Illuminate\Pagination\LengthAwarePaginator */
                $histories = $user->histories()
                    ->when($request->input('url'), fn (Builder $query, string $url) =>
                        $query->where('url', 'LIKE', '%'.$url.'%')
                    )
                    ->when($request->input('hostname'), fn (Builder $query, array $hostname) =>
                        $query->whereIn('hostname', $hostname)
                    )
                    ->when($request->input('created_period'),
                        fn (Builder $query, array $createdPeriod) =>
                            $query->whereBetween('created_at',
                                count($request->input('created_period', [])) === 2 ? [
                                    now()->parse($createdPeriod[0])->setTime(0, 0),
                                    now()->parse($createdPeriod[1])->setTime(23, 59, 59),
                                ] : []
                            )
                    )
                    ->latest('id')
                    ->paginate(20);

                return $histories->through(fn (History $history) => [
                    'id' => $history->id,
                    'url' => $history->url,
                    'hostname' => $history->hostname,
                    'created_at' => $history->created_at->format('Y/m/d H:i'),
                ]);
            },
            'historyFilters' => [
                'url' => $request->input('url'),
                'hostname' => $request->input('hostname'),
                'created_period' => $request->input('created_period'),
            ],
            'tokens' => fn () =>
                $user->tokens()
                    ->latest('id')
                    ->get()
                    ->map(fn ($token) => [
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
