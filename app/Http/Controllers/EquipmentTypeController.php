<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipmentTypes = EquipmentType::all();
        return view('equipment_types.index', compact('equipmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipment_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        EquipmentType::create($request->all());

        return redirect()->route('equipment-types.index')->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
        return view('equipment_types.show', compact('equipmentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
        return view('equipment_types.edit', compact('equipmentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $equipmentType = EquipmentType::findOrFail($id);
        $equipmentType->update($request->all());

        return redirect()->route('equipment-types.index')->with('success', 'Амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipmentType = EquipmentType::findOrFail($id);
        $equipmentType->delete();

        return redirect()->route('equipment-types.index')->with('success', 'Амжилттай устгагдлаа.');
    }
}