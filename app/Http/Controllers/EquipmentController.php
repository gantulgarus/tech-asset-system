<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Image;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Models\MaintenancePlan;
use App\Exports\EquipmentExport;
use App\Models\EquipmentHistory;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipment::query();

        // Get the logged-in user
        $user = auth()->user();

        // Check if the user belongs to a specific branch
        if ($user->branch_id) {
            // Show only stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->filled('branch_id')) {
            // Allow filtering by branch_id only if the user is in the main branch
            if ($user->branch_id == 8) {
                $query->where('branch_id', $request->input('branch_id'));
            }
        }

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }
        if ($request->filled('equipment_type_id')) {
            $query->where('equipment_type_id', $request->input('equipment_type_id'));
        }


        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        $equipments = $query->paginate(25)->appends($request->query());

        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        $stations = Station::orderBy('name', 'asc')->get();
        $equipment_types = EquipmentType::orderBy('name', 'asc')->get();
        $volts = Volt::orderBy('order', 'asc')->get();

        return view('equipment.index', compact('equipments', 'branches', 'stations', 'equipment_types', 'volts'))->with('i', (request()->input('page', 1) - 1) * 25);
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
        // Get the logged-in user
        $user = auth()->user();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        $stations = Station::all();
        $equipmentTypes = EquipmentType::all();
        $volts = Volt::orderBy('order', 'asc')->get();

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

        LogActivity::addToLog("Тоноглолын мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('equipment.index')
            ->with('success', 'Тоноглолын мэдээлэл амжилттай хадгаллаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipmentHistories = EquipmentHistory::where('equipment_id', $equipment->id)->get();
        $maintenancePlans = MaintenancePlan::where('equipment_id', $equipment->id)->get();

        return view('equipment.show', compact('equipment', 'equipmentHistories', 'maintenancePlans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        // Get the logged-in user
        $user = auth()->user();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        $stations = Station::all();
        $equipmentTypes = EquipmentType::all();
        $volts = Volt::orderBy('order', 'asc')->get();

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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                Image::create([
                    'equipment_id' => $equipment->id,
                    'file_path' => $path,
                ]);
            }
        }

        $equipment->update($request->all());

        LogActivity::addToLog("Тоноглолын мэдээлэл амжилттай засагдлаа.");

        $equipment->volts()->sync($request->volt_ids);

        return redirect()->route('equipment.index')
            ->with('success', 'Тоноглолын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        LogActivity::addToLog("Тоноглолын мэдээлэл амжилттай устгалаа.");

        return redirect()->route('equipment.index')
            ->with('success', 'Тоноглолын мэдээлэл амжилттай устгалаа.');
    }

    public function export(Request $request)
    {
        $query = Equipment::query();

        // Apply filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }

        if ($request->filled('equipment_type_id')) {
            $query->where('equipment_type_id', $request->input('equipment_type_id'));
        }

        if ($request->has('volt_id')) {
            $query->whereExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('volts')
                    ->join('equipment_volt', 'volts.id', '=', 'equipment_volt.volt_id')
                    ->whereRaw('equipment.id = equipment_volt.equipment_id')
                    ->where('volts.id', $request->volt_id);
            });
        }

        // Get the filtered data
        $equipments = $query->get();


        return Excel::download(new EquipmentExport($equipments), 'equipment_data.xlsx');
    }
}