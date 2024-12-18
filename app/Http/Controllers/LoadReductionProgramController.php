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
        $date = $request->input('date', now()->setTimezone('Asia/Ulaanbaatar')->toDateString());
        $branchId = $request->input('branch_id');

        $programs = LoadReductionProgram::when($date, function ($query, $date) {
            $query->whereDate('reduction_time', $date);
        })
            ->when($branchId, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->latest()->get();

        $total_reduction_capacity = $programs->sum('reduction_capacity');
        $total_pre_reduction_capacity = $programs->sum('pre_reduction_capacity');
        $total_reduced_capacity = $programs->sum('reduced_capacity');
        $total_post_reduction_capacity = $programs->sum('post_reduction_capacity');
        $total_energy_not_supplied = $programs->sum('energy_not_supplied');
        $branches = Branch::all();

        return view('load_reduction_programs.index', compact(
            'programs',
            'total_reduction_capacity',
            'total_pre_reduction_capacity',
            'total_reduced_capacity',
            'total_post_reduction_capacity',
            'total_energy_not_supplied',
            'date',
            'branches'
        ));
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
        $filter = $request->only('date', 'branch_id');
        return Excel::download(new LoadReductionProgramExport($filter), 'achaalal_hongololt.xlsx');
    }
}