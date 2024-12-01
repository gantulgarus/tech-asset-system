<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Powerline;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\PowerlineGeojson;

class PowerlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Powerline::query();

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }

        if ($request->filled('powerline')) {
            // dd($request->input('station'));
            $query->where('name', 'like', '%' . $request->input('powerline') . '%');
        }

        if ($request->filled('volt_id')) {
            $query->where('volt_id', $request->input('volt_id'));
        }

        $powerlines = $query->orderBy('station_id', 'asc')->paginate(25)->appends($request->query());

        $stations = Station::orderBy('name', 'asc')->get();
        $volts = Volt::orderBy('order', 'asc')->get();

        // $powerlines = Powerline::orderBy('station_id', 'asc')->paginate(25);
        return view('powerlines.index', compact('powerlines', 'stations', 'volts'))->with('i', (request()->input('page', 1) - 1) * 25);
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

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай хадгаллаа.');
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

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Powerline $powerline)
    {
        $powerline->delete();

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай устгагдлаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай устгагдлаа.');
    }
}