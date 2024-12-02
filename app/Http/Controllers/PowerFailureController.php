<?php

namespace App\Http\Controllers;

use App\Exports\PowerFailureExport;
use App\Models\Volt;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Helpers\LogActivity;
use App\Models\PowerFailure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PowerFailureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $powerFailures = PowerFailure::paginate(20);
        $query = PowerFailure::query();

        $query->join('stations', 'power_failures.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id') // Assuming branches table exists
            ->select('power_failures.*', 'stations.name as station_name', 'branches.name as branch_name');

        // Apply filters
        if ($request->filled('station')) {
            // dd($request->input('station'));
            $query->where('stations.name', 'like', '%' . $request->input('station') . '%');
        }

        // Apply branch filter
        if ($request->filled('branch_id')) {
            $query->where('stations.branch_id', $request->input('branch_id'));
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('power_failures.failure_date', [$request->input('starttime'), $request->input('endtime')]);
        }

        // Paginate results
        $powerFailures = $query->paginate(20)->appends($request->query());
        $branches = Branch::orderBy('name', 'asc')->get();

        return view('power_failures.index', compact('powerFailures', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();

        return view('power_failures.create', compact('stations', 'equipments'));
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
            'failure_date' => 'required|date',
            'detector_name' => 'required|string|max:255',
            'failure_detail' => 'required|string',
            'notified_name' => 'required|string|max:255',
            'action_taken' => 'required|string',
            'fixer_name' => 'required|string|max:255',
            'inspector_name' => 'required|string|max:255',
        ]);

        PowerFailure::create($input);

        LogActivity::addToLog("Гэмдлийн мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('power_failures.index')
            ->with('success', 'Гэмдлийн мэдээлэл амжилттай хадгаллаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerFailure $powerFailure)
    {
        return view('power_failures.show', compact('powerFailure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerFailure $powerFailure)
    {
        $stations = Station::all();
        $equipments = Equipment::all();

        return view('power_failures.edit', compact('powerFailure', 'stations', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerFailure $powerFailure)
    {
        $request->validate([
            'failure_date' => 'required|date',
            'detector_name' => 'required|string|max:255',
            'failure_detail' => 'required|string',
            'notified_name' => 'required|string|max:255',
            'action_taken' => 'required|string',
            'fixer_name' => 'required|string|max:255',
            'inspector_name' => 'required|string|max:255',
        ]);

        $powerFailure->update($request->all());

        LogActivity::addToLog("Гэмдлийн мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('power_failures.index')
            ->with('success', 'Гэмдлийн мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerFailure $powerFailure)
    {
        $powerFailure->delete();

        LogActivity::addToLog("Гэмдлийн мэдээлэл амжилттай устгадлаа.");

        return redirect()->route('power_failures.index')
            ->with('success', 'Гэмдлийн мэдээлэл амжилттай устгадлаа.');
    }

    public function export(Request $request)
    {
        $query = PowerFailure::query();

        $query->join('stations', 'power_failures.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id') // Assuming branches table exists
            ->select('power_failures.*', 'stations.name as station_name', 'branches.name as branch_name');

        // Apply filters
        if ($request->filled('station')) {
            // dd($request->input('station'));
            $query->where('stations.name', 'like', '%' . $request->input('station') . '%');
        }

        // Apply branch filter
        if ($request->filled('branch_id')) {
            $query->where('stations.branch_id', $request->input('branch_id'));
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('power_failures.failure_date', [$request->input('starttime'), $request->input('endtime')]);
        }

        // Paginate results
        $powerFailures = $query->get();


        return Excel::download(new PowerFailureExport($powerFailures), 'gemtel.xlsx');
    }
}