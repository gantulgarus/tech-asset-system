<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Equipment;
use App\Models\PowerFailure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PowerFailureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $powerFailures = PowerFailure::paginate(20);
        return view('power_failures.index', compact('powerFailures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();

        return view('power_failures.create', compact('stations', 'equipments'));
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
            'failure_date' => 'required|date',
            'detector_name' => 'required|string|max:255',
            'failure_detail' => 'required|string',
            'notified_name' => 'required|string|max:255',
            'action_taken' => 'required|string',
            'fixer_name' => 'required|string|max:255',
            'inspector_name' => 'required|string|max:255',
        ]);

        PowerFailure::create($input);

        return redirect()->route('power_failures.index')
            ->with('success', 'Power failure recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerFailure $powerFailure)
    {
        return view('power_failures.show', compact('powerFailure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerFailure $powerFailure)
    {
        $stations = Station::all();
        $equipments = Equipment::all();

        return view('power_failures.edit', compact('powerFailure', 'stations', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerFailure $powerFailure)
    {
        $request->validate([
            'failure_date' => 'required|date',
            'detector_name' => 'required|string|max:255',
            'failure_detail' => 'required|string',
            'notified_name' => 'required|string|max:255',
            'action_taken' => 'required|string',
            'fixer_name' => 'required|string|max:255',
            'inspector_name' => 'required|string|max:255',
        ]);

        $powerFailure->update($request->all());

        return redirect()->route('power_failures.index')
            ->with('success', 'Power failure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerFailure $powerFailure)
    {
        $powerFailure->delete();

        return redirect()->route('power_failures.index')
            ->with('success', 'Power failure deleted successfully.');
    }
}