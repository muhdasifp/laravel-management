<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentController extends Controller
{
    public function registerStudent(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'nullable|string',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(['message' => 'Student registered successfully', 'token' => $token], 201);
    }

    public function loginStudent(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        $token = JWTAuth::attempt($credentials);
        return response()->json(['message' => 'Student login successfully', 'token' => $token], 200);
    }

    public function studentProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user, 200);
    }

    public function deleteStudentProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->delete();
        return response()->json(['message' => 'Student profile deleted successfully'], 200);
    }
}
