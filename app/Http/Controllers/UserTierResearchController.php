<?php

namespace App\Http\Controllers;

use App\Models\Sum;
use App\Models\Branch;
use App\Models\Province;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\UserTierResearch;

class UserTierResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $userTierResearches = UserTierResearch::all();
        $query = UserTierResearch::query();

        // if ($request->filled('branch_id')) {
        //     $query->where('branch_id', $request->input('branch_id'));
        // }
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->input('province_id'));
        }
        if ($request->filled('sum_id')) {
            $query->where('sum_id', $request->input('sum_id'));
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->input('username') . '%');
        }
        if ($request->filled('user_tier')) {
            $query->where('user_tier', $request->input('user_tier'));
        }

        // Paginate results
        $userTierResearches = $query->paginate(20)->appends($request->query());

        $branches = Branch::all();
        $provinces = Province::all();
        $sums = Sum::all();

        return view('user_tier_research.index', compact('userTierResearches', 'branches', 'provinces', 'sums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $sums = Sum::orderBy('name')->get();

        return view('user_tier_research.create', compact('provinces', 'sums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'province_id' => 'required|integer',
            'username' => 'required|string',
            'user_tier' => 'required|integer|in:1,2',
            'source_con_schema' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'diesel_generator' => 'required|string',
            'motor' => 'required|string',
            'backup_power' => 'required|integer',
            'backup_status' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        if ($request->hasFile('schema')) {
            $file = $request->file('schema');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validatedData['source_con_schema'] = 'images/' . $filename;
            $file->storeAs('images', $filename, 'public');
        }

        UserTierResearch::create($validatedData);

        LogActivity::addToLog("1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай хадгалагдлаа.");

        return redirect()->route('user_tier_research.index')
            ->with('success', '1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserTierResearch $userTierResearch)
    {
        return view('user_tier_research.show', compact('userTierResearch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTierResearch $userTierResearch)
    {
        $provinces = Province::orderBy('name')->get();
        $sums = Sum::orderBy('name')->get();

        return view('user_tier_research.edit', compact('userTierResearch', 'provinces', 'sums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserTierResearch $userTierResearch)
    {
        $validatedData = $request->validate([
            'province_id' => 'required|integer',
            'username' => 'required|string',
            'user_tier' => 'required|integer|in:1,2',
            'source_con_schema' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'diesel_generator' => 'required|string',
            'motor' => 'required|string',
            'backup_power' => 'required|integer',
            'backup_status' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        if ($request->hasFile('schema')) {
            $file = $request->file('schema');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validatedData['source_con_schema'] = 'images/' . $filename;

            // Store new file
            $file->storeAs('images', $filename, 'public');
        }

        $userTierResearch->update($validatedData);

        LogActivity::addToLog("1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай шинэчлэгдлээ.");

        return redirect()->route('user_tier_research.index')
            ->with('success', '1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай шинэчлэгдлээ.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTierResearch $userTierResearch)
    {
        $userTierResearch->delete();

        LogActivity::addToLog("1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай устгагдлаа.");

        return redirect()->route('user_tier_research.index')
            ->with('success', '1, 2-р зэрэглэлийн Хэрэглэгчийн судалгаа амжилттай устгагдлаа.');
    }
}