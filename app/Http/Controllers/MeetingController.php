<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MeetingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = Meeting::all();
        foreach ($meetings as $meeting) {
            $meeting->view_meeting = [
                'href' => 'api/v1/meeting/' . $meeting->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'List of all Meetings',
            'meetings' => $meetings
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg' => 'User not found', 404]);
        }

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:d-m-Y H:i'
        ]);

        $title = $validated['title'];
        $description = $validated['description'];
        $datetime = \DateTime::createFromFormat('d-m-Y H:i', $validated['time']);
        $time = $datetime->format('Y-m-d H:i:s');
        $user_id = $user->id;

        $meeting = new Meeting([
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'user_id' => $user->id
        ]);

        if ($meeting->save()) {
            $meeting->users()->attach($user_id);
            $meeting->view_meeting =  [
                'href' => 'api/v1/meeting/' . $meeting->id,
                'method' => 'GET'
            ];

            $response = [
                'msg' => 'Meeting created.',
                'meeting' => $meeting,
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occurred.'
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meeting = Meeting::with('users')->where('id', $id)->firstOrFail();

        $meeting->view_meetings = [
            'href' => '/api/v1/meeting',
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Meeting retrieved.',
            'meeting' => $meeting
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg' => 'User not found', 404]);
        }

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:d-m-Y H:i',
        ]);

        $title = $validated['title'];
        $description = $validated['description'];
        $time = \DateTime::createFromFormat('d-m-Y H:i', $validated['time']);
        $user_id = $user->id;

        $meeting = Meeting::with('users')->findOrFail($id);

        if (!$meeting->users()->where('users.id', $user_id)->first()) {
            return response()->json([
                'msg' => 'User not registred for meeting. Update not successful.'
            ], 401);
        }

        $meeting->title = $title;
        $meeting->description = $description;
        $meeting->time = $time;

        if ($meeting->save()) {
            $meeting->view_meeting =  [
                'href' => 'api/v1/meeting/' . $meeting->id,
                'method' => 'GET'
            ];

            $response = [
                'msg' => 'Meeting successfully updated.',
                'meeting' => $meeting
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occurred.',
            'meeting' => $meeting
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meeting = Meeting::findOrFail($id);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg' => 'User not found', 404]);
        }
        if (!$meeting->users()->where('users.id', $user->id)->first()) {
            return response()->json([
                'msg' => 'User not registred for meeting. Update not successful.'
            ], 401);
        }

        $users = $meeting->users;
        $meeting->users()->detach();
        if ($meeting->delete()) {
            $response = [
                'msg' => 'Meeting succefully deleted.',
                'create_meeting' => [
                    'href' => 'api/v1/meeting',
                    'method' => 'POST',
                    'params' => 'title, description, time, user_id'
                ]
            ];

            return response()->json($response, 200);
        }
        foreach ($users as $user) {
            $meeting->users()->attach($user);
        }

        $response = [
            'msg' => 'An erro occurred.'
        ];

        return response()->json($response, 202);
    }
}
