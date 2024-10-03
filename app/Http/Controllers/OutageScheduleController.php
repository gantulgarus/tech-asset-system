<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\OutageSchedule;

class OutageScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outageSchedules = OutageSchedule::paginate(15);
        return view('outage_schedules.index', compact('outageSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();

        return view('outage_schedules.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'branch_id' => 'required|integer',
            'substation_line_equipment' => 'required|string',
            'task' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'affected_users' => 'required|string',
            'responsible_officer' => 'required|string',
        ]);

        OutageSchedule::create($validatedData);

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Outage schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutageSchedule $outageSchedule)
    {
        return view('outage_schedules.show', compact('outageSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutageSchedule $outageSchedule)
    {
        $branches = Branch::all();

        return view('outage_schedules.edit', compact('outageSchedule', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutageSchedule $outageSchedule)
    {
        $validatedData = $request->validate([
            'branch_id' => 'required|integer',
            'substation_line_equipment' => 'required|string',
            'task' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'affected_users' => 'required|string',
            'responsible_officer' => 'required|string',
        ]);

        $outageSchedule->update($validatedData);

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Outage schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutageSchedule $outageSchedule)
    {
        $outageSchedule->delete();

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Outage schedule deleted successfully');
    }
}