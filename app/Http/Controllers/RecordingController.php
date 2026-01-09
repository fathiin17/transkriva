<?php

namespace App\Http\Controllers;

use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordingController extends Controller
{
    public function index()
    {
        $recordings = Recording::where('user_id', Auth::id())->get();
        return view('recordings.index', compact('recordings'));
    }

    public function store(Request $request)
{
    $request->validate([
        'audio' => 'required|file',
        'title' => 'required|string',
        'notes' => 'nullable|string',
        'transcript' => 'nullable|string',
    ]);

    $path = $request->file('audio')->store('recordings', 'public');

    Recording::create([
        'title' => $request->title,
        'notes' => $request->notes,
        'file_path' => $path,
        'transcript' => $request->transcript,
        'user_id' => $request->user()->id,
    ]);

    return redirect()->route('recordings.index');
}



    public function destroy($id)
    {
        Recording::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }
}
