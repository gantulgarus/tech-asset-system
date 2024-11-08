<?php

namespace App\Http\Controllers;

use App\DataTables\PowerOutageDataTable;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\Protection;
use App\Models\CauseOutage;
use App\Models\PowerOutage;
use App\Models\Volt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PowerOutageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = PowerOutage::query();

        $query->join('stations', 'power_outages.station_id', '=', 'stations.id')
            ->select('power_outages.*', 'stations.name as station_name')
            ->orderBy('power_outages.start_time', 'desc');

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

        // Paginate results
        $powerOutages = $query->paginate(20)->appends($request->query());

        $volts = Volt::all();

        // $powerOutages = PowerOutage::paginate(10);
        return view('power_outages.index', compact('powerOutages', 'volts'));
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

        return redirect()->route('power_outages.index')
            ->with('success', 'Power outage created successfully.');
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

            return redirect()->back()->with('success', 'Act uploaded successfully!');
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

        return redirect()->route('power_outages.index')
            ->with('success', 'Power outage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PowerOutage $powerOutage)
    {
        $powerOutage->delete();

        return redirect()->route('power_outages.index')
            ->with('success', 'Power outage deleted successfully.');
    }
}
