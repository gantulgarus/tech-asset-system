<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Station;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\LoadReductionProgram;

class LoadReductionProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = LoadReductionProgram::all();
        // dd($programs);

        $total_reduction_capacity = $programs->sum('reduction_capacity');
        $total_pre_reduction_capacity = $programs->sum('pre_reduction_capacity');
        $total_reduced_capacity = $programs->sum('reduced_capacity');
        $total_post_reduction_capacity = $programs->sum('post_reduction_capacity');
        $total_energy_not_supplied = $programs->sum('energy_not_supplied');

        return view('load_reduction_programs.index', compact(
            'programs',
            'total_reduction_capacity',
            'total_pre_reduction_capacity',
            'total_reduced_capacity',
            'total_post_reduction_capacity',
            'total_energy_not_supplied'
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

        return view('load_reduction_programs.create', compact('branches', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'branch_id' => 'required|integer',
            'station_id' => 'required|integer',
            'company_name' => 'required|string|max:255',
            'output_name' => 'required|string|max:255',
        ]);

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

        return view('load_reduction_programs.edit', compact('loadReductionProgram', 'branches', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoadReductionProgram $loadReductionProgram)
    {
        $input = $request->all();

        $request->validate([
            'branch_id' => 'required|integer',
            'station_id' => 'required|integer',
            'company_name' => 'required|string|max:255',
            'output_name' => 'required|string|max:255',
        ]);

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
}