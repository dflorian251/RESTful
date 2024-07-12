<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $password = $validated['password'];

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        if ($user->save()) {
            $user->signin = [
                'href' => 'api/v1/user/signin',
                'method' => 'GET',
                'params' => 'email, password'
            ];

            $response = [
                'msg' => 'User created.',
                'user' => $user
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occurred.'
        ];

        return response()->json($response, 404);
    }


    public function signin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $validated['email'];
        $password = $validated['password'];

        $credentials = $request->only('email', 'password');

        try {
            if ( !$token = JWTAuth::attempt($credentials) ) {
                return response()->json(['msg' => 'Invalid credentials.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['msg' => 'Could not create token. ' . $e->getMessage()], 500);
        }

        return response()->json(['token' => $token], 200);
    }
}
