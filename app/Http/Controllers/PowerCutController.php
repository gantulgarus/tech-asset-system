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
use App\Models\OrderType;
use App\Models\PowerCutType;
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
        $query = PowerCut::query();

        // Get the logged-in user
        $user = auth()->user();

        // Check if the user is not in the main branch (branch_id = 8)
        if ($user->branch_id && $user->branch_id != 8) {
            // Filter by branch_id in the Station model
            $query->whereHas('station', function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            });
        }

        // Allow filtering by branch_id if the user is in the main branch
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('branch_id', $request->input('branch_id'));
            });
        }

        // Apply filters
        if ($request->filled('station')) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('station') . '%');
            });
        }

        if ($request->filled('equipment')) {
            $query->whereHas('equipment', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('equipment') . '%');
            });
        }

        if ($request->filled('cut_type_id')) {
            $query->where('cut_type_id', $request->input('cut_type_id'));
        }

        if ($request->filled('cause_cut')) {
            $query->where('cause_cut', 'like', '%' . $request->input('cause_cut') . '%');
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        if ($request->filled('start_time')) {
            $query->where('start_time', 'like', '%' . $request->input('start_time') . '%');
        }
        if ($request->filled('end_time')) {
            $query->where('end_time', 'like', '%' . $request->input('end_time') . '%');
        }

        if ($request->filled('approved_by')) {
            $query->where('approved_by', 'like', '%' . $request->input('approved_by') . '%');
        }

        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->input('order_number') . '%');
        }

        if ($request->filled('created_by')) {
            $query->where('created_by', 'like', '%' . $request->input('created_by') . '%');
        }

        // Paginate results
        $powerCuts = $query->latest()->paginate(25)->appends($request->query());

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        $volts = Volt::all();
        $cutTypes = PowerCutType::all();

        return view('power_cuts.index', compact('powerCuts', 'volts', 'branches', 'cutTypes'))->with('i', (request()->input('page', 1) - 1) * 25);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $cutTypes = PowerCutType::all();

        return view('power_cuts.create', compact('stations', 'equipments', 'cutTypes'));
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
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'cut_type_id' => 'required',
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
        $cutTypes = PowerCutType::all();

        return view('power_cuts.edit', compact('powerCut', 'stations', 'equipments', 'cutTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerCut $powerCut)
    {
        $input = $request->all();

        $request->validate([
            'station_id' => 'required',
            'equipment_id' => 'required',
            'current_voltage' => 'required|numeric',
            'current_amper' => 'required|numeric',
            'current_power' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'cut_type_id' => 'required',
        ]);

        $powerCut->update($input);

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

        // Get the logged-in user
        $user = auth()->user();

        // Check if the user is not in the main branch (branch_id = 8)
        if ($user->branch_id && $user->branch_id != 8) {
            // Filter by branch_id in the Station model
            $query->whereHas('station', function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            });
        }

        // Allow filtering by branch_id if the user is in the main branch
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('branch_id', $request->input('branch_id'));
            });
        }

        // Apply filters
        if ($request->filled('station')) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('station') . '%');
            });
        }

        if ($request->filled('equipment')) {
            $query->whereHas('equipment', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('equipment') . '%');
            });
        }

        if ($request->filled('cut_type_id')) {
            $query->where('cut_type_id', $request->input('cut_type_id'));
        }

        if ($request->filled('cause_cut')) {
            $query->where('cause_cut', 'like', '%' . $request->input('cause_cut') . '%');
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        if ($request->filled('start_time')) {
            $query->where('start_time', 'like', '%' . $request->input('start_time') . '%');
        }
        if ($request->filled('end_time')) {
            $query->where('end_time', 'like', '%' . $request->input('end_time') . '%');
        }

        if ($request->filled('approved_by')) {
            $query->where('approved_by', 'like', '%' . $request->input('approved_by') . '%');
        }

        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->input('order_number') . '%');
        }

        if ($request->filled('created_by')) {
            $query->where('created_by', 'like', '%' . $request->input('created_by') . '%');
        }

        // Paginate results
        $powerCuts = $query->latest()->get();


        return Excel::download(new PowerCutExport($powerCuts), 'taslalt.xlsx');
    }
}
