<?php

namespace App\Http\Controllers;

use App\Models\Protection;
use Illuminate\Http\Request;

class ProtectionController extends Controller
{
    public function index()
    {
        $protections = Protection::all();
        return view('protections.index', compact('protections'));
    }

    public function create()
    {
        return view('protections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable'
        ]);

        Protection::create($request->all());
        return redirect()->route('protections.index');
    }

    public function show(Protection $protection)
    {
        return view('protections.show', compact('protection'));
    }

    public function edit(Protection $protection)
    {
        return view('protections.edit', compact('protection'));
    }

    public function update(Request $request, Protection $protection)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable'
        ]);

        $protection->update($request->all());
        return redirect()->route('protections.index');
    }

    public function destroy(Protection $protection)
    {
        $protection->delete();
        return redirect()->route('protections.index');
    }
}
