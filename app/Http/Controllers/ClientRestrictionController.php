<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Models\ClientRestriction;

class ClientRestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientRestrictions = ClientRestriction::all();
        return view('client_restrictions.index', compact('clientRestrictions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $stations = Station::orderBy('name', 'asc')->get();

        return view('client_restrictions.create', compact('branches', 'stations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'output_name' => 'required|string|max:255',
        ]);

        ClientRestriction::create($validated);

        return redirect()->route('client-restrictions.index')->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientRestriction $clientRestriction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientRestriction $clientRestriction)
    {
        $branches = Branch::all();
        $stations = Station::orderBy('name', 'asc')->get();

        return view('client_restrictions.edit', compact('clientRestriction', 'branches', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientRestriction $clientRestriction)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'station_id' => 'required|exists:stations,id',
            'output_name' => 'required|string|max:255',
        ]);

        $clientRestriction->update($validated);

        return redirect()->route('client-restrictions.index')->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientRestriction $clientRestriction)
    {
        $clientRestriction->delete();
        return redirect()->route('client-restrictions.index')->with('success', 'Амжилттай устгалаа.');
    }
}