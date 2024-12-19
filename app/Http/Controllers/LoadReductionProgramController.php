<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Station;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\ClientOrganization;
use App\Models\LoadReductionProgram;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoadReductionProgramExport;

class LoadReductionProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LoadReductionProgram::query();

        $user = auth()->user();

        if ($user->branch_id && $user->branch_id != 8) {
            // Restrict to stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('client_name')) {
            $query->whereHas('clientOrganization', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('client_name') . '%');
            });
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

        if ($request->filled('remarks')) {
            $query->where('remarks', 'like', '%' . $request->input('remarks') . '%');
        }

        $programs = $query->latest()->paginate(25)->appends($request->query());

        if ($user->branch_id == 8) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view('load_reduction_programs.index', compact(
            'programs',
            'branches'
        ))->with('i', (request()->input('page', 1) - 1) * 25);
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
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }
        $clientOrgs = ClientOrganization::orderBy('name', 'asc')->get();

        return view('load_reduction_programs.create', compact('branches', 'stations', 'clientOrgs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'client_organization_id' => 'required|integer|exists:client_organizations,id',
            'reduction_time' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);


        // Find the selected client organization
        $clientOrg = ClientOrganization::findOrFail($request->client_organization_id);

        $input['branch_id'] = $clientOrg->branch_id;
        $input['station_id'] = $clientOrg->station_id;
        $input['output_name'] = $clientOrg->output_name;
        $input['reduction_capacity'] = $clientOrg->reduction_capacity;

        LoadReductionProgram::create($input);

        LogActivity::addToLog("ААН-үүдийг ачаалал хөнгөлөх хөтөлбөрийн мэдээлэл амжилттай хадгаллаа.");

        return redirect()->route('load-reduction-programs.index')->with('success', 'Мэдээлэл амжилттай бүртгэгдлээ.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoadReductionProgram $loadReductionProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoadReductionProgram $loadReductionProgram)
    {
        // Get the logged-in user
        $user = auth()->user();

        // Determine branches based on the user's branch_id
        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $stations = Station::orderBy('name', 'asc')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $stations = Station::where('branch_id', $user->branch_id)->orderBy('name', 'asc')->get();
        }

        $clientOrgs = ClientOrganization::orderBy('name', 'asc')->get();

        return view('load_reduction_programs.edit', compact('loadReductionProgram', 'branches', 'stations', 'clientOrgs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoadReductionProgram $loadReductionProgram)
    {
        $input = $request->all();

        // Validate only the fields that are directly provided in the form
        $request->validate([
            'client_organization_id' => 'required|integer|exists:client_organizations,id',
            'reduction_time' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Find the selected client organization
        $clientOrg = ClientOrganization::findOrFail($request->client_organization_id);

        // Dynamically set values from the selected client organization
        $input['branch_id'] = $clientOrg->branch_id;
        $input['station_id'] = $clientOrg->station_id;
        $input['output_name'] = $clientOrg->output_name;
        $input['reduction_capacity'] = $clientOrg->reduction_capacity;

        // Update the LoadReductionProgram record with the new data
        $loadReductionProgram->update($input);

        LogActivity::addToLog("ААН-үүдийг ачаалал хөнгөлөх хөтөлбөрийн мэдээлэл амжилттай засагдлаа.");

        return redirect()->route('load-reduction-programs.index')->with('success', 'Мэдээлэл амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoadReductionProgram $loadReductionProgram)
    {
        $loadReductionProgram->delete();

        LogActivity::addToLog("ААН-үүдийг ачаалал хөнгөлөх хөтөлбөрийн мэдээлэл амжилттай устгалаа.");

        return redirect()->route('load-reduction-programs.index')->with('success', 'Мэдээлэл амжилттай устгалаа.');
    }

    public function export(Request $request)
    {
        $query = LoadReductionProgram::query();

        $user = auth()->user();

        if ($user->branch_id && $user->branch_id != 8) {
            // Restrict to stations belonging to the user's branch
            $query->where('branch_id', $user->branch_id);
        }
        if ($request->filled('branch_id') && $user->branch_id == 8) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('client_name')) {
            $query->whereHas('clientOrganization', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('client_name') . '%');
            });
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

        if ($request->filled('remarks')) {
            $query->where('remarks', 'like', '%' . $request->input('remarks') . '%');
        }

        $programs = $query->get();

        return Excel::download(new LoadReductionProgramExport($programs), 'achaalal_hongololt.xlsx');
    }
}
