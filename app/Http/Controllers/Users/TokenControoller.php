<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class TokenControoller extends Controller
{
    public function create(User $user)
    {
        $token = $user->createToken(now()->format('Y/m/d H:i:s'));

        return back()->with('token', $token->plainTextToken);
    }

    public function destroy(User $user, string $id)
    {
        $user->tokens()->where('id', $id)->delete();

        return back();
    }
}
