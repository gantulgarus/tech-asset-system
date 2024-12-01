<?php

namespace App\Http\Controllers;

use App\Models\CauseCut;
use Illuminate\Http\Request;

class CauseCutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $causeCuts = CauseCut::all();
        return view('cause_cuts.index', compact('causeCuts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cause_cuts.create');
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

        CauseCut::create($request->all());

        return redirect()->route('cause_cuts.index')
            ->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CauseCut $causeCut)
    {
        return view('cause_cuts.show', compact('causeCut'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CauseCut $causeCut)
    {
        return view('cause_cuts.edit', compact('causeCut'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CauseCut $causeCut)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $causeCut->update($request->all());

        return redirect()->route('cause_cuts.index')
            ->with('success', 'Амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CauseCut $causeCut)
    {
        $causeCut->delete();

        return redirect()->route('cause_cuts.index')
            ->with('success', 'Амжилттай устгагдлаа.');
    }
}