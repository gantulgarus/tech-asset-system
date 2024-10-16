<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Sum;
use Illuminate\Http\Request;
use App\Models\UserTierResearch;

class UserTierResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTierResearches = UserTierResearch::all();
        return view('user_tier_research.index', compact('userTierResearches'));
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

        return redirect()->route('user_tier_research.index')
            ->with('success', 'User Tier Research created successfully.');
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
        return view('user_tier_research.edit', compact('userTierResearch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTierResearch $userTierResearch)
    {
        $userTierResearch->delete();

        return redirect()->route('user_tier_research.index')
            ->with('success', 'User Tier Research deleted successfully.');
    }
}