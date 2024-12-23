<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\Protection;
use App\Models\CauseOutage;
use App\Models\PowerOutage;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Exports\PowerOutageExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\PowerOutageDataTable;

class PowerOutageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = PowerOutage::query();

        $query->join('stations', 'power_outages.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id')
            ->join('equipment', 'power_outages.equipment_id', '=', 'equipment.id')
            ->join('users', 'power_outages.user_id', '=', 'users.id')
            ->select('power_outages.*', 'stations.name as station_name', 'equipment.name as equipment_name')
            ->orderBy('power_outages.start_time', 'desc');

        // Apply filters
        if ($request->filled('station')) {
            $query->where('stations.name', 'like', '%' . $request->input('station') . '%');
        }

        if ($request->filled('equipment')) {
            $query->where('equipment.name', 'like', '%' . $request->input('equipment') . '%');
        }

        if ($request->filled('protection_id')) {
            $query->where('protection_id', $request->input('protection_id'));
        }

        if ($request->filled('cause_outage_id')) {
            $query->where('cause_outage_id', $request->input('cause_outage_id'));
        }

        if ($request->filled('start_time')) {
            $startTime = $request->input('start_time');

            if (preg_match('/^\d{4}$/', $startTime)) {
                // Search by year (e.g., 2024)
                $query->whereYear('power_outages.start_time', $startTime);
            } elseif (preg_match('/^\d{4}-\d{2}$/', $startTime)) {
                // Search by year and month (e.g., 2024-12)
                $query->whereYear('power_outages.start_time', substr($startTime, 0, 4))
                    ->whereMonth('power_outages.start_time', substr($startTime, 5, 2));
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $startTime)) {
                // Search by exact date (e.g., 2024-12-09)
                $query->whereDate('power_outages.start_time', $startTime);
            }
        }
        if ($request->filled('end_time')) {
            $endTime = $request->input('end_time');

            if (preg_match('/^\d{4}$/', $endTime)) {
                // Search by year (e.g., 2024)
                $query->whereYear('power_outages.end_time', $endTime);
            } elseif (preg_match('/^\d{4}-\d{2}$/', $endTime)) {
                // Search by year and month (e.g., 2024-12)
                $query->whereYear('power_outages.end_time', substr($endTime, 0, 4))
                    ->whereMonth('power_outages.end_time', substr($endTime, 5, 2));
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $endTime)) {
                // Search by exact date (e.g., 2024-12-09)
                $query->whereDate('power_outages.end_time', $endTime);
            }
        }

        if ($request->filled('weather')) {
            $query->where('weather', 'like', '%' . $request->input('weather') . '%');
        }
        if ($request->filled('incident_resolution')) {
            $query->where('incident_resolution', 'like', '%' . $request->input('incident_resolution') . '%');
        }
        if ($request->filled('user_name')) {
            $query->where('users.name', 'like', '%' . $request->input('user_name') . '%');
        }
        if ($request->filled('technological_violation')) {
            $query->where('technological_violation', $request->input('technological_violation'));
        }




        // Apply branch filter
        if ($request->filled('branch_id')) {
            $query->where('stations.branch_id', $request->input('branch_id'));
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('power_outages.start_time', [$request->input('starttime'), $request->input('endtime')]);
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Paginate results
        $powerOutages = $query->paginate(20)->appends($request->query());
        $branches = Branch::orderBy('name', 'asc')->get();
        $volts = Volt::all();
        $protections = Protection::all();
        $causeOutages = CauseOutage::all();

        // $powerOutages = PowerOutage::paginate(10);
        return view('power_outages.index', compact('powerOutages', 'volts', 'branches', 'protections', 'causeOutages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $protections = Protection::all();
        $causeOutages = CauseOutage::all();

        return view('power_outages.create', compact('stations', 'equipments', 'protections', 'causeOutages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        // dd($input);

        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'equipment_id' => 'required|exists:equipment,id',
            'protection_id' => 'required|exists:protections,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'duration' => 'nullable|integer',
            'weather' => 'nullable|string',
            'cause_outage_id' => 'required|exists:cause_outages,id',
            'current_voltage' => 'nullable|numeric',
            'current_amper' => 'nullable|numeric',
            'cosf' => 'nullable|numeric',
            'ude' => 'nullable|numeric',
            'technological_violation' => 'nullable|in:Аваар,1-р зэргийн саатал,2-р зэргийн саатал',
        ]);

        PowerOutage::create($input);

        LogActivity::addToLog("Тасралтын мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('power_outages.index')
            ->with('success', 'Тасралтын мэдээлэл амжилттай хадгаллаа.');
    }

    public function showUploadPage($id)
    {
        $powerOutage = PowerOutage::findOrFail($id);
        return view('power_outages.upload-act', compact('powerOutage'));
    }

    // New action to handle the act file upload
    public function uploadAct(Request $request, $id)
    {
        // Validate the request to ensure a PDF file is provided
        $request->validate([
            'act_file' => 'required|mimes:pdf|max:2048', // Only allow PDF files up to 2MB
        ]);

        // Find the existing PowerOutage entry
        $powerOutage = PowerOutage::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('act_file')) {
            // Get the uploaded file
            $file = $request->file('act_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('acts', $filename, 'public'); // Store the file in the 'public/acts' folder

            // Save the file path in the database
            $powerOutage->act_file_path = $path;
            $powerOutage->save();

            return redirect()->back()->with('success', 'Амжилттай хадгаллаа!');
        }

        return redirect()->back()->withErrors('File upload failed.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PowerOutage $powerOutage)
    {
        return view('power_outages.show', compact('powerOutage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PowerOutage $powerOutage)
    {
        $stations = Station::all();
        $equipments = Equipment::all();
        $protections = Protection::all();
        $causeOutages = CauseOutage::all();

        return view('power_outages.edit', compact('powerOutage', 'stations', 'equipments', 'protections', 'causeOutages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerOutage $powerOutage)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'equipment_id' => 'required|exists:equipment,id',
            'protection_id' => 'required|exists:protections,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'duration' => 'nullable|integer',
            'weather' => 'nullable|string',
            'cause_outage_id' => 'required|exists:cause_outages,id',
            'current_voltage' => 'nullable|numeric',
            'current_amper' => 'nullable|numeric',
            'cosf' => 'nullable|numeric',
            'ude' => 'nullable|numeric',
            'technological_violation' => 'nullable|in:Аваар,1-р зэргийн саатал,2-р зэргийн саатал',
        ]);

        $powerOutage->update($request->all());

        LogActivity::addToLog("Тасралтын мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('power_outages.index')
            ->with('success', 'Тасралтын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerOutage $powerOutage)
    {
        $powerOutage->delete();

        LogActivity::addToLog("Тасралтын мэдээлэл амжилттай устгалаа.");

        return redirect()->route('power_outages.index')
            ->with('success', 'Тасралтын мэдээлэл амжилттай устгалаа.');
    }

    public function export(Request $request)
    {
        $query = PowerOutage::query();

        // Apply filters
        $query->join('stations', 'power_outages.station_id', '=', 'stations.id')
            ->join('branches', 'stations.branch_id', '=', 'branches.id') // Assuming branches table exists
            ->select('power_outages.*', 'stations.name as station_name')
            ->orderBy('power_outages.start_time', 'desc');

        // Apply branch filter
        if ($request->filled('branch_id')) {
            $query->where('stations.branch_id', $request->input('branch_id'));
        }

        // Apply filters
        if ($request->filled('station')) {
            // dd($request->input('station'));
            $query->where('stations.name', 'like', '%' . $request->input('station') . '%');
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('power_outages.start_time', [$request->input('starttime'), $request->input('endtime')]);
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Get the filtered data
        $powerOutages = $query->get();


        return Excel::download(new PowerOutageExport($powerOutages), 'tasralt.xlsx');
    }
}