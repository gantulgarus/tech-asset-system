<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Station;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\PowerLimitAdjustment;

class PowerLimitAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString()); // Default to current date if no date is selected

        $adjustments = PowerLimitAdjustment::whereDate('created_at', $date)->latest()->get();

        $totalMinutes = $adjustments->sum('duration_minutes');
        $totalHours = $adjustments->sum('duration_hours');
        $totalPower = $adjustments->sum('power');
        $totalEnergyNotSupplied = $adjustments->sum('energy_not_supplied');
        $totalUserCount = $adjustments->sum('user_count');

        return view('power-limit-adjustments.index', compact('adjustments', 'totalMinutes', 'totalHours', 'totalPower', 'totalEnergyNotSupplied', 'totalUserCount', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the logged-in user
        $user = auth()->user();

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        return view('power-limit-adjustments.create', compact('branches', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'output_name' => 'required|string|max:255',
        ]);

        PowerLimitAdjustment::create($input);

        LogActivity::addToLog("Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай хадгалагдлаа.");

        return redirect()->route('power-limit-adjustments.index')
            ->with('success', 'Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerLimitAdjustment $powerLimitAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerLimitAdjustment $powerLimitAdjustment)
    {
        // Get the logged-in user
        $user = auth()->user();

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        return view('power-limit-adjustments.edit', compact('powerLimitAdjustment', 'branches', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerLimitAdjustment $powerLimitAdjustment)
    {
        $input = $request->all();

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'output_name' => 'required|string|max:255',
        ]);

        $powerLimitAdjustment->update($input);

        LogActivity::addToLog("Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('power-limit-adjustments.index')
            ->with('success', 'Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerLimitAdjustment $powerLimitAdjustment)
    {
        $powerLimitAdjustment->delete();

        LogActivity::addToLog("Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай устгагдлаа.");

        return redirect()->route('power-limit-adjustments.index')
            ->with('success', 'Хөнгөлөлт, хязгаарлалтын мэдээлэл амжилттай устгагдлаа.');
    }
}