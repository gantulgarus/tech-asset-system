<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Powerline;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\PowerlineGeojson;

class PowerlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Powerline::query();

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

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }
        if ($request->filled('line_type')) {
            $query->where('line_type', $request->input('line_type'));
        }

        if ($request->filled('powerline')) {
            // dd($request->input('station'));
            $query->where('name', 'like', '%' . $request->input('powerline') . '%');
        }

        if ($request->filled('volt_id')) {
            $query->where('volt_id', $request->input('volt_id'));
        }

        if ($request->filled('create_year')) {
            $query->where('create_year', 'like', '%' . $request->input('create_year') . '%');
        }
        if ($request->filled('line_mark')) {
            $query->where('line_mark', 'like', '%' . $request->input('line_mark') . '%');
        }
        if ($request->filled('tower_mark')) {
            $query->where('tower_mark', 'like', '%' . $request->input('tower_mark') . '%');
        }
        if ($request->filled('isolation_mark')) {
            $query->where('isolation_mark', 'like', '%' . $request->input('isolation_mark') . '%');
        }

        $powerlines = $query->with(['station.branch'])->orderBy('station_id', 'asc')->paginate(25)->appends($request->query());

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        $volts = Volt::orderBy('order', 'asc')->get();

        return view('powerlines.index', compact('powerlines', 'branches', 'stations', 'volts'))->with('i', (request()->input('page', 1) - 1) * 25);
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
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        $volts = Volt::all();

        return view('powerlines.create', compact('stations', 'volts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name' => 'required|string|max:255',
            'volt_id' => 'required|exists:volts,id',
            'create_year' => 'required|date',
            'line_mark' => 'required|string|max:255',
            // 'tower_mark' => 'required|string|max:255',
            // 'tower_count' => 'required|integer',
            'line_length' => 'required|numeric',
            // 'isolation_mark' => 'required|string|max:255',
        ]);

        Powerline::create($request->all());

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай хадгаллаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Powerline $powerline)
    {
        // $geojsonFiles = PowerlineGeojson::where('powerline_id', $powerline->id)->get();
        $geojson = $powerline->geojson;

        return view('powerlines.show', compact('powerline', 'geojson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Powerline $powerline)
    {
        // Get the logged-in user
        $user = auth()->user();
        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        $volts = Volt::all();

        return view('powerlines.edit', compact('powerline', 'stations', 'volts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Powerline $powerline)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name' => 'required|string|max:255',
            'volt_id' => 'required|exists:volts,id',
            'create_year' => 'required|date',
            'line_mark' => 'required|string|max:255',
            // 'tower_mark' => 'required|string|max:255',
            // 'tower_count' => 'required|integer',
            'line_length' => 'required|numeric',
            // 'isolation_mark' => 'required|string|max:255',
        ]);

        $powerline->update($request->all());

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Powerline $powerline)
    {
        $powerline->delete();

        LogActivity::addToLog("Шугамын мэдээлэл амжилттай устгагдлаа.");

        return redirect()->route('powerlines.index')->with('success', 'Шугамын мэдээлэл амжилттай устгагдлаа.');
    }
}
