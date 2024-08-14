<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentHistory;
use Illuminate\Support\Facades\Auth;

class EquipmentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipmentHistories = EquipmentHistory::all();
        return view('equipment_histories.index', compact('equipmentHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($equipment_id)
    {
        $equipments = Equipment::all();

        return view('equipment_histories.create', compact('equipments', 'equipment_id'));
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
            'equipment_id' => 'required|exists:equipment,id',
            'work_type' => 'required|string|max:255',
            'task_date' => 'required|date',
            'completed_task' => 'required|string',
            'team_members' => 'required|string',
        ]);

        $history = EquipmentHistory::create($input);
        $equipment = Equipment::find($history->equipment_id);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment history created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentHistory $equipmentHistory)
    {
        return view('equipment_histories.show', compact('equipmentHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentHistory $equipmentHistory)
    {
        $equipments = Equipment::all();

        return view('equipment_histories.edit', compact('equipmentHistory', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EquipmentHistory $equipmentHistory)
    {
        $request->validate([
            // 'equipment_id' => 'required|exists:equipment,id',
            'work_type' => 'required|string|max:255',
            'task_date' => 'required|date',
            'completed_task' => 'required|string',
            'team_members' => 'required|string',
        ]);

        $equipmentHistory->update($request->all());
        $equipment = Equipment::find($equipmentHistory->equipment_id);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment history updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentHistory $equipmentHistory)
    {
        $equipmentHistory->delete();
        $equipment = Equipment::find($equipmentHistory->equipment_id);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment history deleted successfully.');
    }
}