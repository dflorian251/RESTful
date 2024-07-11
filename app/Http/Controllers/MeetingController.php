<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
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
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:d-m-Y H:i',
            'user_id' => 'required'
        ]);

        $title = $validated['title'];
        $description = $validated['description'];
        $time = \DateTime::createFromFormat('d-m-Y H:i', $validated['time']);
        $user_id = $validated['user_id'];

        $meeting = new Meeting([
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'user_id' => $user_id
        ]);

        if ($meeting->save()) {
            $meeting->view_meeting =  [
                'href' => 'api/v1/meeting/' . $meeting->id,
                'method' => 'GET'
            ];

            $response = [
                'msg' => 'Meeting created.',
                'meeting' => $meeting
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
        $meeting = Meeting::find($id);

        $response = [
            'msg' => 'Meeting with ID=' . $meeting->id . ' retrieved.',
            'meeting' => $meeting
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:d-m-Y H:i'
        ]);

        $title = $validated['title'];
        $description = $validated['description'];
        $time = \DateTime::createFromFormat('d-m-Y H:i', $validated['time']);

        $meeting = Meeting::find($id);

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
        $meeting = Meeting::find($id);

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

        $response = [
            'msg' => 'An erro occurred.'
        ];

        return response()->json($response, 202);
    }
}
