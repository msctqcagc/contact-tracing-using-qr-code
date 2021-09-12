<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        $user = User::whereNull('deleted_at')
            ->where('is_active', true)
            ->where(function($query) use ($request) {
                $query->where('email', $request->identity)
                    ->orWhere('username', $request->identity);
            })->first();

        if (
            $user &&
            strtolower($user->role->name) === 'scanner' &&
            Hash::check($request->password, $user->password)
        ) {
            $token = $user->createToken('api-token')->plainTextToken;
            return json_encode(['token' => $token]);
        }

        return response(json_encode(['message' => 'Invalid credentials']), 401);
    }

    public function logout(Request $request) {
        $user = User::find($request->id);
        if ($user) {
            $user->tokens()->delete();
        }

        return json_encode(['message' => 'Logged out']);
    }
}
