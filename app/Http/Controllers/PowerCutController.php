<?php

namespace App\Http\Controllers;

use App\Exports\PowerCutExport;
use App\Models\Volt;
use App\Models\Branch;
use App\Models\Station;
use App\Models\CauseCut;
use App\Models\PowerCut;
use App\Models\Equipment;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PowerCutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $powerCuts = PowerCut::paginate(25);

        $query = PowerCut::query();

        $query->join('stations', 'power_cuts.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id') // Assuming branches table exists
            ->select('power_cuts.*', 'stations.name as station_name')
            ->orderBy('power_cuts.start_time', 'desc');

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
            $query->whereBetween('power_cuts.start_time', [$request->input('starttime'), $request->input('endtime')]);
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Paginate results
        $powerCuts = $query->paginate(20)->appends($request->query());
        $branches = Branch::orderBy('name', 'asc')->get();
        $volts = Volt::all();

        return view('power_cuts.index', compact('powerCuts', 'volts', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $causeCuts = CauseCut::all();

        return view('power_cuts.create', compact('stations', 'equipments', 'causeCuts'));
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
            'station_id' => 'required',
            'equipment_id' => 'required',
            'cause_cut_id' => 'required',
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            // 'duration' => 'required',
            // 'ude' => 'required|numeric',
            // 'approved_by' => 'required',
            // 'created_by' => 'required',
            // 'order_number' => 'required',
        ]);

        PowerCut::create($input);

        LogActivity::addToLog("Таслалтын мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('power_cuts.index')->with('success', 'Таслалтын мэдээлэл амжилттай хадгаллаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerCut $powerCut)
    {
        return view('power_cuts.show', compact('powerCut'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerCut $powerCut)
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $causeCuts = CauseCut::all();

        return view('power_cuts.edit', compact('powerCut', 'stations', 'equipments', 'causeCuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerCut $powerCut)
    {
        $validatedData = $request->validate([
            'station_id' => 'required',
            'equipment_id' => 'required',
            'cause_cut_id' => 'required',
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            // 'duration' => 'required',
            // 'ude' => 'required|numeric',
            // 'approved_by' => 'required',
            // 'created_by' => 'required',
            // 'order_number' => 'required',
        ]);

        $powerCut->update($validatedData);

        LogActivity::addToLog("Таслалтын мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('power_cuts.index')->with('success', 'Таслалтын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerCut $powerCut)
    {
        $powerCut->delete();

        LogActivity::addToLog("Таслалтын мэдээлэл амжилттай устгалаа.");

        return redirect()->route('power_cuts.index')->with('success', 'Таслалтын мэдээлэл амжилттай устгалаа.');
    }

    public function export(Request $request)
    {
        $query = PowerCut::query();

        $query->join('stations', 'power_cuts.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id') // Assuming branches table exists
            ->select('power_cuts.*', 'stations.name as station_name')
            ->orderBy('power_cuts.start_time', 'desc');

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
            $query->whereBetween('power_cuts.start_time', [$request->input('starttime'), $request->input('endtime')]);
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Paginate results
        $powerCuts = $query->get();


        return Excel::download(new PowerCutExport($powerCuts), 'taslalt.xlsx');
    }
}