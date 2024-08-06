<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Equipment;
use App\Models\Schema;
use App\Models\Station;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::with('branch', 'volts')->get();
        return view('stations.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $volts = Volt::all();
        return view('stations.create', compact('branches', 'volts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'volt_ids' => 'required|array',
            'volt_ids.*' => 'exists:volts,id',
            'installed_capacity' => 'required',
            'create_year' => 'required|numeric',
            'desc' => 'nullable',
        ]);

        $station = Station::create($request->only(['name', 'branch_id', 'desc', 'installed_capacity', 'create_year']));

        $station->volts()->attach($request->volt_ids);

        return redirect()->route('stations.index')->with('success', 'Station created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $station = Station::findOrFail($id);
        $qrCode = QrCode::size(200)->generate(route('stations.show', $station->uuid));
        $equipments = Equipment::where('station_id', $id)->get();
        $schemas = Schema::where('station_id', $id)->get();

        return view('stations.show', compact('station', 'qrCode', 'equipments', 'schemas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Station $station)
    {
        $branches = Branch::all();
        $volts = Volt::all();
        return view('stations.edit', compact('station', 'branches', 'volts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Station $station)
    {
        // dd($station);
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'volt_ids' => 'required|array',
            'volt_ids.*' => 'exists:volts,id',
            'installed_capacity' => 'required',
            'create_year' => 'required|numeric',
            'desc' => 'nullable',
        ]);

        $station->update($request->only(['name', 'branch_id', 'desc', 'installed_capacity', 'create_year']));

        $station->volts()->sync($request->volt_ids);

        return redirect()->route('stations.index')->with('success', 'Station updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station)
    {
        $station->delete();
        return redirect()->route('stations.index')->with('success', 'Station deleted successfully.');
    }
}