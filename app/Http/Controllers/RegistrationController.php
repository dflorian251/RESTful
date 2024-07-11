<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\User;

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

        $meeting = Meeting::findOrFail($meeting_id);
        $user = User::findOrFail($user_id);

        $response = [
            'msg' => 'User is alreay registered for this meeting.',
            'user' => $user_id,
            'meeting' => $meeting_id,
            'unregister' => [
                'href' => 'api/v1/registration/' . $meeting->id,
                'method' => 'DELETE',
                'params' => 'meeting_id, user_id'
            ]
        ];

        if ($meeting->users()->where('user_id', $user_id)->first()) {
            return response()->json($response, 404);
        }

        $user->meetings()->attach($meeting);

        $registration = [
            'meeting_id' => $meeting_id,
            'user_id' => $user_id,
            'unregister' => [
                'href' => 'api/v1/registration/' . $meeting_id,
                'method' => 'DELETE',
                'params' => 'meeting_id, user_id'
            ]
        ];

        $response = [
            'msg' => 'Registration completed.',
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
