<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\Scanner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ScannerController extends Controller
{
    public function index() {
        $role_id = null;
        $role = Role::where('name', 'Scanner')->first();
        if ($role) {
            $role_id = $role->id;
        }

        $users = User::whereNull('deleted_at')
            ->where('is_active', true)
            ->where('role_id', $role_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response(json_encode(['users' => UserResource::collection($users)]));
    }

    public function store(Request $request) {
        $role_id = null;
        $role = Role::where('name', 'Scanner')->first();
        if ($role) {
            $role_id = $role->id;
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role_id
        ]);

        Scanner::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
            'barangay_id' => $request->barangay_id,
            'coordinates' => $request->coordinates
        ]);

        return response('', 201);
    }

    public function destroy($id) {
        $scanner = Scanner::find($id);
        if ($scanner) {
            $scanner->timestamps = false;
            $scanner->delete();
        }

        return response('');
    }
}
