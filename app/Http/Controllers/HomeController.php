<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Powerline;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stationCount = Station::count();
        $equipmentCount = Equipment::count();
        $powerlineCount = Powerline::count();
        $userCount = User::count();

        return view('home', compact('stationCount', 'equipmentCount', 'powerlineCount', 'userCount'));
    }
}