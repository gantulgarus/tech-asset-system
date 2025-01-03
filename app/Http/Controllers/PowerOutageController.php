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

        if ($request->filled('protection_id')) {
            $query->where('protection_id', $request->input('protection_id'));
        }

        if ($request->filled('cause_outage_id')) {
            $query->where('cause_outage_id', $request->input('cause_outage_id'));
        }

        if ($request->filled('start_time')) {
            $query->where('start_time', 'like', '%' . $request->input('start_time') . '%');
        }
        if ($request->filled('end_time')) {
            $query->where('end_time', 'like', '%' . $request->input('end_time') . '%');
        }

        if ($request->filled('weather')) {
            $query->where('weather', 'like', '%' . $request->input('weather') . '%');
        }
        if ($request->filled('incident_resolution')) {
            $query->where('incident_resolution', 'like', '%' . $request->input('incident_resolution') . '%');
        }
        if ($request->filled('create_user')) {
            $query->where('create_user', 'like', '%' . $request->input('create_user') . '%');
        }
        if ($request->filled('technological_violation')) {
            $query->where('technological_violation', $request->input('technological_violation'));
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Paginate results
        $powerOutages = $query->latest()->paginate(25)->appends($request->query());

        $volts = Volt::all();
        $protections = Protection::all();
        $causeOutages = CauseOutage::all();

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        // $powerOutages = PowerOutage::paginate(10);
        return view('power_outages.index', compact('powerOutages', 'volts', 'branches', 'protections', 'causeOutages'))->with('i', (request()->input('page', 1) - 1) * 25);
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

        if ($request->filled('protection_id')) {
            $query->where('protection_id', $request->input('protection_id'));
        }

        if ($request->filled('cause_outage_id')) {
            $query->where('cause_outage_id', $request->input('cause_outage_id'));
        }

        if ($request->filled('start_time')) {
            $query->where('start_time', 'like', '%' . $request->input('start_time') . '%');
        }
        if ($request->filled('end_time')) {
            $query->where('end_time', 'like', '%' . $request->input('end_time') . '%');
        }

        if ($request->filled('weather')) {
            $query->where('weather', 'like', '%' . $request->input('weather') . '%');
        }
        if ($request->filled('incident_resolution')) {
            $query->where('incident_resolution', 'like', '%' . $request->input('incident_resolution') . '%');
        }
        if ($request->filled('create_user')) {
            $query->where('create_user', 'like', '%' . $request->input('create_user') . '%');
        }
        if ($request->filled('technological_violation')) {
            $query->where('technological_violation', $request->input('technological_violation'));
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('equipment.volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        // Get the filtered data
        $powerOutages = $query->latest()->get();


        return Excel::download(new PowerOutageExport($powerOutages), 'tasralt.xlsx');
    }
}
