<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use Illuminate\Http\Request;

class VoltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volts = Volt::orderBy('id', 'desc')->get();
        return view('volts.index', compact('volts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('volts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Volt::create($request->post());

        return redirect()->route('volts.index')->with('success', 'Volt has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Volt $volt)
    {
        return view('volts.show', compact('volt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Volt $volt)
    {
        return view('volts.edit', compact('volt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Volt $volt)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $volt->fill($request->post())->save();

        return redirect()->route('volts.index')->with('success', 'Volt has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Volt $volt)
    {
        $volt->delete();
        return redirect()->route('volts.index')->with('success', 'Volt has been deleted successfully.');
    }
}
