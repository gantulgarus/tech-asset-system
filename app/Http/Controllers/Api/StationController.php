<?php

namespace App\Http\Controllers\Api;

use App\Models\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StationController extends Controller
{
    // Get all stations
    public function index()
    {
        $stations = Station::all(); // Retrieve all stations from the database
        return response()->json($stations); // Return the stations as a JSON response
    }
}
