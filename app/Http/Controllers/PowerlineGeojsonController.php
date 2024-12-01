<?php

namespace App\Http\Controllers;

use App\Models\Powerline;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\PowerlineGeojson;
use Illuminate\Support\Facades\Storage;

class PowerlineGeojsonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $geojsonFiles = PowerlineGeojson::all();
        return view('powerlinegeojson.index', compact('geojsonFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $powerlines = Powerline::all();

        return view('powerlinegeojson.create', compact('powerlines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'powerline_id' => 'required|exists:powerlines,id',
            // 'geojson_file' => 'required|mimes:geo+json|max:2048',
        ]);

        if ($request->hasFile('geojson_file')) {

            $file = $request->file('geojson_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('geojson', $filename, 'public');
        }


        PowerlineGeojson::create([
            'powerline_id' => $request->powerline_id,
            'filename' => $filename,
            'path' => $path,
        ]);

        LogActivity::addToLog("GeoJSON файл амжилттай хадгалагдлаа.");

        return redirect()->route('powerlinegeojson.index')->with('success', 'GeoJSON файл амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $geojsonFile = PowerlineGeojson::findOrFail($id);
        return view('powerlinegeojson.edit', compact('geojsonFile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'powerline_id' => 'required|exists:powerlines,id',
            'geojson_file' => 'nullable|mimes:geojson|max:2048',
        ]);

        $geojsonFile = PowerlineGeojson::findOrFail($id);

        if ($request->hasFile('geojson_file')) {
            // Delete the old file
            Storage::disk('public')->delete($geojsonFile->path);

            $file = $request->file('geojson_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('geojson', $filename, 'public');

            $geojsonFile->update([
                'filename' => $filename,
                'path' => $path,
            ]);
        }

        $geojsonFile->update([
            'powerline_id' => $request->powerline_id,
        ]);

        LogActivity::addToLog("GeoJSON файл амжилттай засагдлаа.");

        return redirect()->route('powerlinegeojson.index')->with('success', 'GeoJSON файл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $geojsonFile = PowerlineGeojson::findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($geojsonFile->path);

        // Delete the database record
        $geojsonFile->delete();

        LogActivity::addToLog("GeoJSON файл амжилттай устгагдлаа.");

        return redirect()->route('powerlinegeojson.index')->with('success', 'GeoJSON файл амжилттай устгагдлаа.');
    }
}