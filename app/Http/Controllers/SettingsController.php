<?php

namespace App\Http\Controllers;

use App\Models\Volt;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $volts = Volt::all();
        // dd($volts);

        return view('settings.index', compact('volts'));
    }
}
