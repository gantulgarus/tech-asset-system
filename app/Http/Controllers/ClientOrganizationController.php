<?php

namespace App\Http\Controllers;

use App\Models\ClientOrganization;
use Illuminate\Http\Request;

class ClientOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = ClientOrganization::all();
        return view('client_organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client_organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ClientOrganization::create($request->all());
        return redirect()->route('client-organizations.index')->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientOrganization $clientOrganization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientOrganization $clientOrganization)
    {
        return view('client_organizations.edit', compact('clientOrganization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientOrganization $clientOrganization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $clientOrganization->update($request->all());
        return redirect()->route('client-organizations.index')->with('success', 'Амжилттай хадгалагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientOrganization $clientOrganization)
    {
        $clientOrganization->delete();
        return redirect()->route('client-organizations.index')->with('success', 'Амжилттай устгагдлаа.');
    }
}