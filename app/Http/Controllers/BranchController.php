<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        LogActivity::addToLog("Салбар амжилттай хадгалагдлаа.");

        Branch::create($request->all());
        return redirect()->route('branches.index')->with('success', 'Салбар амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        $branch->update($request->all());

        LogActivity::addToLog("Салбар амжилттай засагдлаа.");

        return redirect()->route('branches.index')->with('success', 'Салбар амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        LogActivity::addToLog("Салбар амжилттай устгагдлаа.");

        return redirect()->route('branches.index')->with('success', 'Салбар амжилттай устгагдлаа.');
    }
}