<?php

namespace App\Http\Controllers;

use App\Models\WorkType;
use App\Models\Equipment;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\MaintenancePlan;

class MaintenancePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenancePlans = MaintenancePlan::with(['equipment', 'workType'])->get();
        return view('maintenance_plans.index', compact('maintenancePlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($equipment_id)
    {
        $equipment = Equipment::all();
        $workTypes = WorkType::all();
        return view('maintenance_plans.create', compact('equipment', 'workTypes', 'equipment_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'year' => 'required|integer',
            'work_type_id' => 'required|exists:work_types,id',
        ]);

        $plan = MaintenancePlan::create($request->all());
        // return redirect()->route('maintenance-plans.index')->with('success', 'Maintenance Plan created successfully.');

        $equipment = Equipment::find($plan->equipment_id);

        LogActivity::addToLog("Олон жилийн график амжилттай хадгалагдлаа.");

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Олон жилийн график амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenancePlan $maintenancePlan)
    {
        return view('maintenance_plans.show', compact('maintenancePlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenancePlan $maintenancePlan)
    {
        $equipment = Equipment::all();
        $workTypes = WorkType::all();
        return view('maintenance_plans.edit', compact('maintenancePlan', 'equipment', 'workTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenancePlan $maintenancePlan)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'year' => 'required|integer',
            'work_type_id' => 'required|exists:work_types,id',
        ]);

        $maintenancePlan->update($request->all());
        // return redirect()->route('maintenance-plans.index')->with('success', 'Maintenance Plan updated successfully.');

        $equipment = Equipment::find($maintenancePlan->equipment_id);

        LogActivity::addToLog("Олон жилийн график амжилттай засагдлаа.");

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Олон жилийн график амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenancePlan $maintenancePlan)
    {
        $maintenancePlan->delete();
        // return redirect()->route('maintenance-plans.index')->with('success', 'Maintenance Plan deleted successfully.');
        $equipment = Equipment::find($maintenancePlan->equipment_id);

        LogActivity::addToLog("Олон жилийн график амжилттай устгагдлаа.");

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Олон жилийн график амжилттай устгагдлаа.');
    }
}