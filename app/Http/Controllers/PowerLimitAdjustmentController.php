<?php

namespace App\Http\Controllers;

use App\Exports\PowerLimitAdjustmentsExport;
use App\Models\Branch;
use App\Models\Station;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\ClientRestriction;
use App\Models\PowerLimitAdjustment;
use Maatwebsite\Excel\Facades\Excel;

class PowerLimitAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PowerLimitAdjustment::query();

        $user = auth()->user();

        if ($user->branch_id && $user->branch_id != 8) {
            // Restrict to stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('station_name')) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('station_name') . '%');
            });
        }
        if ($request->filled('output_name')) {
            $query->where('output_name', 'like', '%' . $request->input('output_name') . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('reduction_time', $request->date);
        }

        $adjustments = $query->latest()->paginate(25)->appends($request->query());

        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view('power-limit-adjustments.index', compact('adjustments', 'branches'))->with('i', (request()->input('page', 1) - 1) * 25);
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
            $clients = ClientRestriction::orderBy('output_name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
            $clients = ClientRestriction::where('branch_id', $user->branch_id)->orderBy('output_name', 'asc')->get();
        }

        return view('power-limit-adjustments.create', compact('branches', 'stations', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'client_restriction_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Find the selected client organization
        $client = ClientRestriction::findOrFail($request->client_restriction_id);

        $input['branch_id'] = $client->branch_id;
        $input['station_id'] = $client->station_id;
        $input['output_name'] = $client->output_name;

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
            $clients = ClientRestriction::orderBy('output_name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
            $clients = ClientRestriction::where('branch_id', $user->branch_id)->orderBy('output_name', 'asc')->get();
        }

        return view('power-limit-adjustments.edit', compact('powerLimitAdjustment', 'branches', 'stations', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PowerLimitAdjustment $powerLimitAdjustment)
    {
        $input = $request->all();

        $request->validate([
            'client_restriction_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Find the selected client organization
        $client = ClientRestriction::findOrFail($request->client_restriction_id);

        $input['branch_id'] = $client->branch_id;
        $input['station_id'] = $client->station_id;
        $input['output_name'] = $client->output_name;

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

    public function export(Request $request)
    {
        $query = PowerLimitAdjustment::query();

        $user = auth()->user();

        if ($user->branch_id && $user->branch_id != 8) {
            // Restrict to stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('station_name')) {
            $query->whereHas('station', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('station_name') . '%');
            });
        }
        if ($request->filled('output_name')) {
            $query->where('output_name', 'like', '%' . $request->input('output_name') . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('reduction_time', $request->date);
        }

        $adjustments = $query->latest()->get();

        return Excel::download(new PowerLimitAdjustmentsExport($adjustments), 'hyzgaarlalt.xlsx');
    }
}