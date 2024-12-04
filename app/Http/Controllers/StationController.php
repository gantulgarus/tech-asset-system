<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Schema;
use App\Models\Station;
use App\Models\Equipment;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Exports\StationsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Station::query();

        if ($request->filled('station_type')) {
            $query->where('station_type', $request->station_type);
        }

        if ($request->filled('branch_id')) {
            // dd($request->input('station'));
            $query->where('branch_id', $request->input('branch_id'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        if ($request->filled('create_year')) {
            $query->where('create_year', $request->input('create_year'));
        }

        if ($request->filled('installed_capacity')) {
            $query->where('installed_capacity', $request->input('installed_capacity'));
        }

        if ($request->filled('desc')) {
            $query->where('desc', 'like', '%' . $request->input('desc') . '%');
        }

        if ($request->filled('is_user_station')) {
            $query->where('is_user_station', $request->input('is_user_station'));
        }

        if ($request->filled('station_category')) {
            $query->where('station_category', $request->station_category);
        }


        $stations = $query->paginate(25)->appends($request->query());

        $branches = Branch::all();
        $volts = Volt::orderBy('order', 'asc')->get();

        return view('stations.index', compact('stations', 'branches', 'volts'))
            ->with('i', (request()->input('page', 1) - 1) * 25);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $volts = Volt::orderBy('order', 'asc')->get();
        return view('stations.create', compact('branches', 'volts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'volt_ids' => 'required|array',
            'volt_ids.*' => 'exists:volts,id',
            'installed_capacity' => 'required',
            'create_year' => ['required', 'numeric', 'regex:/^\d{4}$/'],
            'desc' => 'nullable',
            'station_type' => ['required', 'in:Дэд станц,Хуваарилах байгууламж'],
        ]);

        $station = Station::create($request->only(['name', 'branch_id', 'desc', 'installed_capacity', 'create_year', 'is_user_station', 'station_type', 'station_category']));

        LogActivity::addToLog("Дэд станцын мэдээлэл амжилттай хадгаллаа.");

        $station->volts()->attach($request->volt_ids);

        return redirect()->route('stations.index')->with('success', 'Дэд станцын мэдээлэл амжилттай хадгаллаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $station = Station::findOrFail($id);
        $qrCode = QrCode::size(200)->generate(route('stations.show', $station->uuid));
        $equipments = Equipment::where('station_id', $id)->get();
        $schemas = Schema::where('station_id', $id)->get();

        return view('stations.show', compact('station', 'qrCode', 'equipments', 'schemas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Station $station)
    {
        $branches = Branch::all();
        $volts = Volt::orderBy('order', 'asc')->get();
        return view('stations.edit', compact('station', 'branches', 'volts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Station $station)
    {
        // dd($station);
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'volt_ids' => 'required|array',
            'volt_ids.*' => 'exists:volts,id',
            'installed_capacity' => 'required',
            'create_year' => ['required', 'numeric', 'regex:/^\d{4}$/'],
            'desc' => 'nullable',
            'station_type' => ['required', 'in:Дэд станц,Хуваарилах байгууламж'],
        ]);

        $station->update($request->only(['name', 'branch_id', 'desc', 'installed_capacity', 'create_year', 'is_user_station', 'station_type', 'station_category']));

        LogActivity::addToLog("Дэд станцын мэдээлэл амжилттай хадгаллаа.");

        $station->volts()->sync($request->volt_ids);

        return redirect()->route('stations.index')->with('success', 'Дэд станцын мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Station $station)
    {
        $station->delete();

        LogActivity::addToLog("Дэд станцын мэдээлэл амжилттай устгалаа.");

        return redirect()->route('stations.index')->with('success', 'Дэд станцын мэдээлэл амжилттай устгалаа.');
    }
    /**
     * Export stations to Excel.
     */
    public function export(Request $request)
    {
        $query = Station::query();

        if ($request->filled('station_type')) {
            $query->where('station_type', $request->station_type);
        }

        if ($request->filled('branch_id')) {
            // dd($request->input('station'));
            $query->where('branch_id', $request->input('branch_id'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('volt_id')) {
            $voltId = $request->input('volt_id');
            $query->whereHas('volts', function ($query) use ($voltId) {
                $query->where('volts.id', $voltId);
            });
        }

        if ($request->filled('create_year')) {
            $query->where('create_year', $request->input('create_year'));
        }

        if ($request->filled('installed_capacity')) {
            $query->where('installed_capacity', $request->input('installed_capacity'));
        }

        if ($request->filled('desc')) {
            $query->where('desc', 'like', '%' . $request->input('desc') . '%');
        }

        if ($request->filled('is_user_station')) {
            $query->where('is_user_station', $request->input('is_user_station'));
        }

        if ($request->filled('station_category')) {
            $query->where('station_category', $request->station_category);
        }

        // Get the filtered data
        $stations = $query->get();


        return Excel::download(new StationsExport($stations), 'station_data.xlsx');
    }
}