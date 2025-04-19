<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // For all methods
        // $this->middleware('auth')->except(['index']); // Except for a specific method
        // $this->middleware('auth')->only(['myfiles']); // For only a specific method
    }

    public function allfiles()
    {
        $drives = DB::table('drives')->get();
        // return $drives;
        return view('drives.allfiles', compact('drives'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drives = Drive::with('user')->where('status', '=', 'public')->get();
        // return $drives;
        return view('drives.index')->with('drives', $drives);
    }

    public function myfiles()
    {
        $drives = Drive::where('user_id', '=', auth()->id())->get();
        // return $drives;
        return view('drives.myfiles', compact('drives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drives.create');
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
        $drive->user_id = auth()->id();
        $drive->save();

        return redirect()->route('drives.index')->with('success', 'Drive created successfully');
    }

    public function statusEdit(Drive $drive)
    {
        $drive->status = ($drive->status === 'public' ? 'private' : 'public');
        $drive->save();
        return redirect()->back()->with('success', "\"$drive->title\" Status changed to $drive->status.");
    }

    public function download(Drive $drive)
    {
        $full_path = public_path('drives/' . $drive->file_name);
        return response()->download($full_path);
    }

    /**
     * Display the specified resource.
     */
    public function show(Drive $drive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drive $drive)
    {
        return view('drives.edit', compact('drive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drive $drive)
    {
        $size = 5 * 1024; // 5 MB
        $request->validate([
            'title' => 'string|required|max:20|min:3',
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
        return redirect()->route('drives.index')->with('success', 'Drive updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drive $drive)
    {
        $path = public_path('drives/' . $drive->file_name);
        $drive->delete();
        if (file_exists($path)) {
            unlink($path);
        }
        return redirect()->route('drives.index')->with('success', 'Drive deleted successfully');
    }
}
