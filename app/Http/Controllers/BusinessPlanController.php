<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Helpers\LogActivity;
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

        LogActivity::addToLog("Бизнес төлөвлөгөө амжилттай хадгалагдлаа.");

        return redirect()->route('business-plans.index')->with('success', 'Бизнес төлөвлөгөө амжилттай хадгалагдлаа.');
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

        LogActivity::addToLog("Бизнес төлөвлөгөө амжилттай засагдлаа.");

        return redirect()->route('business-plans.index')->with('success', 'Бизнес төлөвлөгөө амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessPlan $businessPlan)
    {
        $businessPlan->delete();

        LogActivity::addToLog("Бизнес төлөвлөгөө амжилттай устгагдлаа.");

        return redirect()->route('business-plans.index')->with('success', 'Бизнес төлөвлөгөө амжилттай устгагдлаа.');
    }

    public function showUploadPage($id)
    {
        $businessPlan = BusinessPlan::findOrFail($id);
        return view('business_plans.upload-act', compact('businessPlan'));
    }

    // New action to handle the act file upload
    public function uploadAct(Request $request, $id)
    {
        // Validate the request to ensure a PDF file is provided
        $request->validate([
            'act_file' => 'required|mimes:pdf|max:2048', // Only allow PDF files up to 2MB
        ]);

        $businessPlan = BusinessPlan::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('act_file')) {
            // Get the uploaded file
            $file = $request->file('act_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('acts', $filename, 'public'); // Store the file in the 'public/acts' folder

            // Save the file path in the database
            $businessPlan->act_file_path = $path;
            $businessPlan->save();

            return redirect()->route('business-plans.index')->with('success', 'Файл амжилттай орууллаа!');
        }

        return redirect()->back()->withErrors('Алдаа гарлаа.');
    }
}