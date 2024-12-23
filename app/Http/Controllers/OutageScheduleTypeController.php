<?php

namespace App\Http\Controllers;

use App\Models\OutageScheduleType;
use Illuminate\Http\Request;

class OutageScheduleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = OutageScheduleType::all();
        return view('outage_schedule_types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('outage_schedule_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        OutageScheduleType::create($request->all());

        return redirect()->route('outage-schedule-types.index')
            ->with('success', 'Таслалтын графикийн төрөл амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutageScheduleType $outageScheduleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutageScheduleType $outageScheduleType)
    {
        return view('outage_schedule_types.edit', compact('outageScheduleType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutageScheduleType $outageScheduleType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $outageScheduleType->update($request->all());

        return redirect()->route('outage-schedule-types.index')
            ->with('success', 'Таслалтын графикийн төрөл амжилттай хадгалагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutageScheduleType $outageScheduleType)
    {
        $outageScheduleType->delete();

        return redirect()->route('outage-schedule-types.index')
            ->with('success', 'Таслалтын графикийн төрөл амжилттай устгагдлаа.');
    }
}