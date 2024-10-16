<?php

namespace App\Http\Controllers;

use App\Models\Sum;
use App\Models\Station;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProtectionZoneViolation;

class ProtectionZoneViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $violations = ProtectionZoneViolation::paginate(25);
        return view('protection_zone_violations.index', compact('violations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $sums = Sum::orderBy('province_id', 'asc')->get();

        return view('protection_zone_violations.create', compact('stations', 'provinces', 'sums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'branch_id' => 'required',
            'province_id' => 'required',
            'sum_id' => 'required',
            'station_id' => 'required',
            'output_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'action_taken' => 'nullable|string|max:255',
        ]);

        // Get the logged-in user's branch_id
        $branchId = Auth::user()->branch_id;

        // Create the new ProtectionZoneViolation record
        $violation = new ProtectionZoneViolation([
            'branch_id' => $branchId,
            'province_id' => $request->province_id,
            'sum_id' => $request->sum_id,
            'station_id' => $request->station_id,
            'output_name' => $request->output_name,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'certificate_number' => $request->certificate_number,
            'action_taken' => $request->action_taken,
        ]);

        // Save the record
        $violation->save();

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Violation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProtectionZoneViolation $violation)
    {
        return view('protection_zone_violations.show', compact('violation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $violation = ProtectionZoneViolation::findOrFail($id);

        $stations = Station::orderBy('name', 'asc')->get();
        $provinces = Province::orderBy('name', 'asc')->get();
        $sums = Sum::orderBy('province_id', 'asc')->orderBy('name', 'asc')->get();

        return view('protection_zone_violations.edit', compact('violation', 'stations', 'provinces', 'sums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $violation = ProtectionZoneViolation::findOrFail($id);

        $validated = $request->validate([
            // 'branch_id' => 'required',
            'province_id' => 'required',
            'sum_id' => 'required',
            'station_id' => 'required',
            'output_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'action_taken' => 'nullable|string|max:255',
        ]);

        $violation->update($validated);

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Violation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $violation = ProtectionZoneViolation::findOrFail($id);

        $violation->delete();

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Violation deleted successfully.');
    }
}