<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Drive;
use Illuminate\Http\Request;

class DriveApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drives = Drive::all();
        $response = [
            'message' => 'Drives retrieved Successfully.',
            'data' => $drives,
            'status' => 200
        ];
        return response($response, 200);
        // return $drives;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $size = 5 * 1024; // 5 MB
        $request->validate([
            'title' => 'string|required|max:20|min:3',
            'description' => 'string|required|min:3',
            'file' => "file|required|max:$size|mimes:mp4,png,pdf,jpg,jpeg,docx,doc"
        ]);

        $drive = new Drive();
        $drive->title = $request->title;
        $drive->description = $request->description;

        $file = $request->file('file');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file_type = $file->getClientMimeType();
        $file->move(public_path('drives'), $file_name);

        $drive->file_name = $file_name;
        $drive->file_type = $file_type;
        $drive->user_id = 1;
        $drive->save();

        $response = [
            'message' => 'Drive created Successfully.',
            'data' => $drive,
            'status' => 201
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $drive = Drive::find($id);
        if (!empty($drive)) {
            $response = [
                'message' => 'Drive retrieved Successfully.',
                'data' => $drive,
                'status' => 200
            ];
            return response($response, 200);
        } else {
            $response = [
                'message' => 'Requested Drive doesn\'t Exist.',
                'status' => 404
            ];
            return response($response, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $drive = Drive::find($id);
        if (!empty($drive)) {
            $size = 5 * 1024; // 5 MB
            $request->validate([
                'title' => 'string|required|max:30|min:3',
                'description' => 'string|required|min:3',
                'file' => "file|max:$size|mimes:mp4,png,pdf,jpg,jpeg,docx,doc"
            ]);

            $drive->title = $request->title;
            $drive->description = $request->description;

            $file = $request->file('file');
            if ($file) {
                // echo "There is a File . <br>";
                $path = public_path('drives/' . $drive->file_name);
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file_type = $file->getClientMimeType();
                $file->move(public_path('drives'), $file_name);
                $drive->file_name = $file_name;
                $drive->file_type = $file_type;
                unlink($path);
            }
            $drive->save();

            $response = [
                'message' => 'Drive updated Successfully.',
                'data' => $drive,
                'status' => 200
            ];
        } else {
            $response = [
                'message' => 'Requested Drive doesn\'t exist.',
                'status' => 404
            ];
        }
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $drive = Drive::find($id);
        if (!empty($drive)) {
            $path = public_path('drives/' . $drive->file_name);
            $drive->delete();
            if (file_exists($path)) {
                unlink($path);
            }
            $response = [
                'message' => 'Drive deleted Successfully.',
                'data' => $drive,
                'status' => 204
            ];
            return response($response, 200);
        } else {
            $response = [
                'message' => 'Requested Drive doesn\'t Exist.',
                'status' => 404
            ];
            return response($response, 404);
        }
    }
}
