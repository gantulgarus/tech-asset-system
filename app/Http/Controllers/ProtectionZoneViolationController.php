<?php

namespace App\Http\Controllers;

use App\Models\Sum;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Province;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProtectionZoneViolation;

class ProtectionZoneViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $violations = ProtectionZoneViolation::paginate(25);

        $query = ProtectionZoneViolation::query();

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->input('province_id'));
        }
        if ($request->filled('sum_id')) {
            $query->where('sum_id', $request->input('sum_id'));
        }
        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }

        if ($request->filled('output_name')) {
            $query->where('output_name', 'like', '%' . $request->input('output_name') . '%');
        }

        // Paginate results
        $violations = $query->paginate(20)->appends($request->query());

        $branches = Branch::all();
        $stations = Station::all();
        $provinces = Province::all();
        $sums = Sum::all();

        return view('protection_zone_violations.index', compact('violations', 'branches', 'provinces', 'sums', 'stations'));
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

        LogActivity::addToLog("Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай хадгалагдлаа.");

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай хадгалагдлаа.');
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

        LogActivity::addToLog("Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $violation = ProtectionZoneViolation::findOrFail($id);

        $violation->delete();

        LogActivity::addToLog("Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай устгагдлаа.");

        return redirect()->route('protection-zone-violations.index')
            ->with('success', 'Хамгаалалтын зурвас судалгаа мэдээлэл амжилттай устгагдлаа.');
    }
}