<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BudgetPlan;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgetPlans = BudgetPlan::with('branch')->paginate(25);
        return view('budget-plans.index', compact('budgetPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('budget-plans.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'year' => 'required|integer|digits:4',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('budget_files', 'public') : null;

        BudgetPlan::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'year' => $request->year,
            'file_path' => $filePath,
        ]);

        LogActivity::addToLog("Батлагдсан төсөв амжилттай хадгалагдлаа.");

        return redirect()->route('budget-plans.index')->with('success', 'Батлагдсан төсөв амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetPlan $budgetPlan)
    {
        return view('budget-plans.show', compact('budgetPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetPlan $budgetPlan)
    {
        $branches = Branch::all();
        return view('budget-plans.edit', compact('budgetPlan', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetPlan $budgetPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'year' => 'required|integer|digits:4',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('budget_files', 'public');
            $budgetPlan->file_path = $filePath;
        }

        $budgetPlan->update([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'year' => $request->year,
        ]);

        LogActivity::addToLog("Батлагдсан төсөв амжилттай засагдлаа.");

        return redirect()->route('budget-plans.index')->with('success', 'Батлагдсан төсөв амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetPlan $budgetPlan)
    {
        if ($budgetPlan->file_path) {
            Storage::disk('public')->delete($budgetPlan->file_path);
        }
        $budgetPlan->delete();

        LogActivity::addToLog("Батлагдсан төсөв амжилттай устгагдлаа.");

        return redirect()->route('budget-plans.index')->with('success', 'Батлагдсан төсөв амжилттай устгагдлаа.');
    }
}