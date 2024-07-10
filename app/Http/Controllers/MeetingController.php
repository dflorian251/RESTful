<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('name');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Hello world';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $time = $request->input('time');
        $user_id = $request->input('user_id');

        $meeting = [
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'user_id' => $user_id,
            'view_meeting' => [
                'href' => 'api/v1/meeting/{dummyId}',
                'method' => 'GET'
            ]
        ];

        $response = [
            'msg' => 'Meeting created.',
            'meeting' => $meeting
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $time = $request->input('time');
        $user_id = $request->input('user_id');

        $meeting = [
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'user_id' => $user_id,
            'view_meeting' => [
                'href' => 'api/v1/meeting/{dummyId}',
                'method' => 'GET'
            ]
        ];

        $response = [
            'msg' => 'Meeting updated.',
            'meeting' => $meeting
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = [
            'msg' => 'Meeting deleted.',
            'create' => [
                'href' => 'api/v1/meeting',
                'method' => 'POST',
                'params' => 'title, description, time'
            ]
        ];

        return response()->json($response, 200);
    }
}
