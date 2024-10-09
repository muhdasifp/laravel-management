<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    public function getAllUser()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function login(Request $request)
    {
        if ($request->email === 'admin' && $request->password === 'password') {
            $credential = $request->only(['email', 'password']);
            $token = JWTAuth::attempt($credential);
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // if ($token = JWTAuth::attempt($credential)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // } else {
        //     return response()->json(['message' => 'Logging Succesfull', 'token' => $token], 200);
        // }
    }

    public function reisterAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required|string',
            'name' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);
        return response()->json(['message' => 'Admin Registed Succesfully', $user], 201);
    }
}
