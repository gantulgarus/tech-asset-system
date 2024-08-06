<?php

namespace App\Http\Controllers;

use App\Models\Schema;
use App\Models\Station;
use Illuminate\Http\Request;

class SchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schemas = Schema::all();
        return view('schemas.index', compact('schemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        return view('schemas.create', compact('stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'station_id' => 'required|exists:stations,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Schema::create([
            'name' => $validatedData['name'],
            'station_id' => $validatedData['station_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('schemas.index')->with('success', 'Schema created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schema $schema)
    {
        return view('schemas.show', compact('schema'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schema $schema)
    {
        $stations = Station::all();
        return view('schemas.edit', compact('schema', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schema $schema)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'station_id' => 'required|exists:stations,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $schema->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $schema->update([
            'name' => $validatedData['name'],
            'station_id' => $validatedData['station_id'],
            'image' => $imagePath,
        ]);

        return redirect()->route('schemas.index')->with('success', 'Schema updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schema $schema)
    {
        $schema->delete();
        return redirect()->route('schemas.index')->with('success', 'Schema deleted successfully.');
    }
}