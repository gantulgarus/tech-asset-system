<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\OutageSchedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OutageScheduleExport;

class OutageScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $outageSchedules = OutageSchedule::paginate(15);
        $query = OutageSchedule::query();

        // // Get the authenticated user's branch_id
        // $userBranchId = auth()->user()->branch_id;

        // // Check if the user's branch_id is not 6
        // if ($userBranchId != 6) {
        //     $query->where('branch_id', $userBranchId);
        // }

        // Apply branch filter from the request if branch_id = 6 or the user wants to filter
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('substation_line_equipment')) {
            $query->where('substation_line_equipment', 'like', '%' . $request->input('substation_line_equipment') . '%');
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('start_date', [$request->input('starttime'), $request->input('endtime')]);
        }

        $outageSchedules = $query->paginate(15)->appends($request->query());

        $branches = Branch::orderBy('name', 'asc')->get();

        foreach ($outageSchedules as $schedule) {
            $schedule->customDateFormat = Carbon::parse($schedule->start_date)->format('Y.m.d')
                . '-'
                . Carbon::parse($schedule->end_date)->format('d');
            $schedule->startTime = Carbon::parse($schedule->start_date)->format('H:i'); // Extract time (hours:minutes)
            $schedule->endTime = Carbon::parse($schedule->end_date)->format('H:i');
        }

        return view('outage_schedules.index', compact('outageSchedules', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();

        return view('outage_schedules.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = now()->day;

        if ($today > 25) {
            return redirect()->back()->withErrors(['error' => 'Таслалтын графикийг зөвхөн сар бүрийн 1-25-ний хооронд бүртгэх боломжтой.']);
        }

        $validatedData = $request->validate([
            'branch_id' => 'required|integer',
            'substation_line_equipment' => 'required|string',
            'task' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'affected_users' => 'required|string',
            'responsible_officer' => 'required|string',
        ]);

        OutageSchedule::create($validatedData);

        LogActivity::addToLog("Таслалтын график амжилттай хадгалагдлаа.");

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Таслалтын график амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutageSchedule $outageSchedule)
    {
        return view('outage_schedules.show', compact('outageSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutageSchedule $outageSchedule)
    {
        $branches = Branch::all();

        return view('outage_schedules.edit', compact('outageSchedule', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutageSchedule $outageSchedule)
    {
        $today = now()->day;

        // Block updates if today's date is 25 or later
        if ($today > 25) {
            return redirect()->back()->withErrors(['error' => 'Сар бүрийн 25-наас хойш таслалтын графикийг засах боломжгүй.']);
        }

        $validatedData = $request->validate([
            'branch_id' => 'required|integer',
            'substation_line_equipment' => 'required|string',
            'task' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'affected_users' => 'required|string',
            'responsible_officer' => 'required|string',
        ]);

        $outageSchedule->update($validatedData);

        LogActivity::addToLog("Таслалтын график амжилттай засагдлаа.");

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Таслалтын график амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutageSchedule $outageSchedule)
    {
        $outageSchedule->delete();

        LogActivity::addToLog("Таслалтын график амжилттай устгагдлаа.");

        return redirect()->route('outage_schedules.index')
            ->with('success', 'Таслалтын график амжилттай устгагдлаа.');
    }

    public function export(Request $request)
    {
        $query = OutageSchedule::query();

        // Apply filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // Get the filtered data
        $stations = $query->get();


        return Excel::download(new OutageScheduleExport($stations), 'outage_data.xlsx');
    }
}