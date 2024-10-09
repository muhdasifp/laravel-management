<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeacherController extends Controller
{
    public function registerTeacher(Request $request)
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
            'role' => 'teacher',
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(['message' => 'Teacher registered successfully', 'token' => $token], 201);
    }

    public function loginTeacher(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        $token = JWTAuth::attempt($credentials);
        return response()->json(['message' => 'Teacher login successfully', 'token' => $token], 200);
    }

    public function teacherProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user, 200);
    }

    public function deleteTeacherProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->delete();
        return response()->json(['message' => 'Teacher profile deleted successfully'], 200);
    }
}
