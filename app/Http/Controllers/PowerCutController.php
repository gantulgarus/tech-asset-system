<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\CauseCut;
use App\Models\PowerCut;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PowerCutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $powerCuts = PowerCut::all();
        return view('power_cuts.index', compact('powerCuts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $causeCuts = CauseCut::all();

        return view('power_cuts.create', compact('stations', 'equipments', 'causeCuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;

        $request->validate([
            'station_id' => 'required',
            'equipment_id' => 'required',
            'cause_cut_id' => 'required',
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'duration' => 'required',
            'ude' => 'required|numeric',
            'approved_by' => 'required',
            'created_by' => 'required',
        ]);

        PowerCut::create($input);

        return redirect()->route('power_cuts.index')->with('success', 'Power cut created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerCut $powerCut)
    {
        return view('power_cuts.show', compact('powerCut'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerCut $powerCut)
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $causeCuts = CauseCut::all();

        return view('power_cuts.edit', compact('powerCut', 'stations', 'equipments', 'causeCuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerCut $powerCut)
    {
        $validatedData = $request->validate([
            'station_id' => 'required',
            'equipment_id' => 'required',
            'cause_cut_id' => 'required',
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'duration' => 'required',
            'ude' => 'required|numeric',
            'approved_by' => 'required',
            'created_by' => 'required',
        ]);

        $powerCut->update($validatedData);
        return redirect()->route('power_cuts.index')->with('success', 'Power cut updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerCut $powerCut)
    {
        $powerCut->delete();
        return redirect()->route('power_cuts.index')->with('success', 'Power cut deleted successfully.');
    }
}