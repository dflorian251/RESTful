<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                'params' => 'name, email, password'
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
        $email = $request->input('email');
        $password = $request->input('password');
        return 'User signin...';
    }
}
