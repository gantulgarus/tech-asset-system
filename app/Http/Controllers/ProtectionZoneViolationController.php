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
        $query = ProtectionZoneViolation::query();

        // Get the logged-in user
        $user = auth()->user();

        // Check if the user is not in the main branch (branch_id = 8)
        if ($user->branch_id && $user->branch_id != 8) {
            // Restrict to stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }

        // Allow filtering by branch_id if the user is in the main branch
        if ($request->filled('branch_id') && $user->branch_id == 8) {
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
        $violations = $query->paginate(25)->appends($request->query());

        $provinces = Province::all();
        $sums = Sum::all();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::all(); // Main branch sees all stations
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->get(); // Filter stations by the user's branch
        }

        return view('protection_zone_violations.index', compact('violations', 'branches', 'provinces', 'sums', 'stations'))->with('i', (request()->input('page', 1) - 1) * 25);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the logged-in user
        $user = auth()->user();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::all(); // Main branch sees all stations
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->get(); // Filter stations by the user's branch
        }
        $provinces = Province::orderBy('name', 'asc')->get();
        $sums = Sum::orderBy('province_id', 'asc')->get();

        return view('protection_zone_violations.create', compact('branches', 'stations', 'provinces', 'sums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'branch_id' => 'required',
            'province_id' => 'required',
            'sum_id' => 'required',
            'station_id' => 'required',
            'output_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'action_taken' => 'nullable|string|max:255',
        ]);

        // Create the new ProtectionZoneViolation record
        ProtectionZoneViolation::create($input);

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

        // Get the logged-in user
        $user = auth()->user();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::all(); // Main branch sees all stations
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->get(); // Filter stations by the user's branch
        }


        $provinces = Province::orderBy('name', 'asc')->get();
        $sums = Sum::orderBy('province_id', 'asc')->orderBy('name', 'asc')->get();

        return view('protection_zone_violations.edit', compact('violation', 'branches', 'stations', 'provinces', 'sums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $violation = ProtectionZoneViolation::findOrFail($id);

        $request->validate([
            'branch_id' => 'required',
            'province_id' => 'required',
            'sum_id' => 'required',
            'station_id' => 'required',
            'output_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'action_taken' => 'nullable|string|max:255',
        ]);

        $violation->update($request->all());

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

    public function getSumsByProvince($provinceId)
    {
        $sums = Sum::where('province_id', $provinceId)->get();
        return response()->json($sums);
    }
}