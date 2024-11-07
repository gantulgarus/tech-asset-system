<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BusinessPlan;
use Illuminate\Http\Request;

class BusinessPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $businessPlans = BusinessPlan::all();
        return view('business_plans.index', compact('businessPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();

        return view('business_plans.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plan_type' => 'required',
            'branch_id' => 'required|integer',
            'infrastructure_name' => 'required|string',
            'task_name' => 'required|string',
            'unit' => 'required|string',
            'quantity' => 'required|numeric',
            'budget_without_vat' => 'required|numeric',
            'performance_amount' => 'required|numeric',
            'variance_amount' => 'required|numeric',
            'desc' => 'nullable|string',
            'performance_percentage' => 'required|numeric',
        ]);

        BusinessPlan::create($validatedData);

        return redirect()->route('business-plans.index')->with('success', 'Business plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessPlan $businessPlan)
    {
        return view('business_plans.show', compact('businessPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessPlan $businessPlan)
    {
        $branches = Branch::all();

        return view('business_plans.edit', compact('businessPlan', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessPlan $businessPlan)
    {
        $validatedData = $request->validate([
            'plan_type' => 'required',
            'branch_id' => 'required|integer',
            'infrastructure_name' => 'required|string',
            'task_name' => 'required|string',
            'unit' => 'required|string',
            'quantity' => 'required|numeric',
            'budget_without_vat' => 'required|numeric',
            'performance_amount' => 'required|numeric',
            'variance_amount' => 'required|numeric',
            'desc' => 'nullable|string',
            'performance_percentage' => 'required|numeric',
        ]);

        $businessPlan->update($validatedData);

        return redirect()->route('business-plans.index')->with('success', 'Business plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessPlan $businessPlan)
    {
        $businessPlan->delete();

        return redirect()->route('business-plans.index')->with('success', 'Business plan deleted successfully.');
    }
}
