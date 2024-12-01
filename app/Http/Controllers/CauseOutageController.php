<?php

namespace App\Http\Controllers;

use App\Models\CauseOutage;
use Illuminate\Http\Request;

class CauseOutageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $causeOutages = CauseOutage::all();
        return view('cause_outages.index', compact('causeOutages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cause_outages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        CauseOutage::create($request->all());

        return redirect()->route('cause_outages.index')
            ->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CauseOutage $causeOutage)
    {
        return view('cause_outages.show', compact('causeOutage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CauseOutage $causeOutage)
    {
        return view('cause_outages.edit', compact('causeOutage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CauseOutage $causeOutage)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $causeOutage->update($request->all());

        return redirect()->route('cause_outages.index')
            ->with('success', 'Амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CauseOutage $causeOutage)
    {
        $causeOutage->delete();

        return redirect()->route('cause_outages.index')
            ->with('success', 'Амжилттай устгагдлаа.');
    }
}