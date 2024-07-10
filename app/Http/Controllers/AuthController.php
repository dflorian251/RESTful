<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password, //should be hashed
            'signin' => [
                'href' => 'api/v1/user/signin',
                'method' => 'GET',
                'params' => 'name, email, password'
            ]
        ];

        $response = [
            'msg' => 'User created.',
            'user' => $user
        ];

        return response()->json($response, 201);
    }

    public function signin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        return 'User signin...';
    }
}
