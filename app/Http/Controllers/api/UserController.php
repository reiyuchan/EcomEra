<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($request->all());

        $user->assignRole('user');

        return $user;
    }

    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request, $id)
    {
        $$request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users',
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());

        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->destroy();

        return response()->json([
            'message' => "user {$id} deleted"
        ], Response::HTTP_OK);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken($request->email, ['*'], now()->addWeek());

        return response([
            'token' => $token->plainTextToken
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out'
        ]);
    }
}
