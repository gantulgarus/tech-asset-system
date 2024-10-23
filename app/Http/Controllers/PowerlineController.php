<?php

namespace App\Http\Controllers;

use App\Models\Powerline;
use App\Models\PowerlineGeojson;
use App\Models\Station;
use App\Models\Volt;
use Illuminate\Http\Request;

class PowerlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $powerlines = Powerline::paginate(25);
        return view('powerlines.index', compact('powerlines'))->with('i', (request()->input('page', 1) - 1) * 25);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $volts = Volt::all();

        return view('powerlines.create', compact('stations', 'volts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name' => 'required|string|max:255',
            'volt_id' => 'required|exists:volts,id',
            'create_year' => 'required|date',
            'line_mark' => 'required|string|max:255',
            'tower_mark' => 'required|string|max:255',
            'tower_count' => 'required|integer',
            'line_length' => 'required|numeric',
            'isolation_mark' => 'required|string|max:255',
        ]);

        Powerline::create($request->all());

        return redirect()->route('powerlines.index')->with('success', 'Powerline created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Powerline $powerline)
    {
        // $geojsonFiles = PowerlineGeojson::where('powerline_id', $powerline->id)->get();
        $geojson = $powerline->geojson;

        return view('powerlines.show', compact('powerline', 'geojson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Powerline $powerline)
    {
        $stations = Station::all();
        $volts = Volt::all();

        return view('powerlines.edit', compact('powerline', 'stations', 'volts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Powerline $powerline)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name' => 'required|string|max:255',
            'volt_id' => 'required|exists:volts,id',
            'create_year' => 'required|date',
            'line_mark' => 'required|string|max:255',
            'tower_mark' => 'required|string|max:255',
            'tower_count' => 'required|integer',
            'line_length' => 'required|numeric',
            'isolation_mark' => 'required|string|max:255',
        ]);

        $powerline->update($request->all());

        return redirect()->route('powerlines.index')->with('success', 'Powerline updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Powerline $powerline)
    {
        $powerline->delete();

        return redirect()->route('powerlines.index')->with('success', 'Powerline deleted successfully.');
    }
}