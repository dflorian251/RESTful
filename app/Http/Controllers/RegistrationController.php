<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'meeting_id' => 'required',
            'user_id' => 'required'
        ]);

        $meeting_id = $validated['meeting_id'];
        $user_id = $validated['user_id'];

        $registration = [
            'meeting_id' => $meeting_id,
            'user_id' => $user_id,
            'delete registration' => [
                'href' => 'api/v1/registration/meeting_id',
                'method' => 'DELETE'
            ]
        ];

        $response = [
            'msg' => 'Registration created.',
            'registration' => $registration
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = [
            'msg' => 'Registration deleted.',
            'create registration' => [
                'href' => 'api/v1/registration',
                'method' => 'POST',
                'params' => 'meeting_id, user_id'
            ]
        ];

        return response()->json($response, 200);
    }
}
