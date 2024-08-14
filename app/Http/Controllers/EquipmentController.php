<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Image;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\EquipmentHistory;
use Illuminate\Http\Request;
use App\Models\EquipmentType;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipments = Equipment::all();
        return view('equipment.index', compact('equipments'));
    }

    public function getEquipments($stationId)
    {
        $equipments = Equipment::where('station_id', $stationId)->get();
        return response()->json($equipments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $stations = Station::all();
        $equipmentTypes = EquipmentType::all();
        $volts = Volt::all();

        return view('equipment.create', compact('branches', 'stations', 'equipmentTypes', 'volts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'mark' => 'required|string|max:255',
            'production_date' => 'required|date',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $equipment = Equipment::create($request->all());

        $equipment->volts()->attach($request->volt_ids);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                Image::create([
                    'equipment_id' => $equipment->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipmentHistories = EquipmentHistory::where('equipment_id', $equipment->id)->get();

        return view('equipment.show', compact('equipment', 'equipmentHistories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $branches = Branch::all();
        $stations = Station::all();
        $equipmentTypes = EquipmentType::all();
        $volts = Volt::all();

        return view('equipment.edit', compact('equipment', 'branches', 'stations', 'equipmentTypes', 'volts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'mark' => 'required|string|max:255',
            'production_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $equipment->update($request->all());

        $equipment->volts()->sync($request->volt_ids);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment deleted successfully.');
    }
}