<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\Powerline;
use App\Models\OrderJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $currentYear = Carbon::now()->year;

        $outages = DB::table('power_outages')
            ->selectRaw('MONTH(start_time) as month, COUNT(*) as outage_count')
            ->whereYear('start_time', now()->year)
            ->groupBy(DB::raw('MONTH(start_time)'))
            ->orderBy(DB::raw('MONTH(start_time)'))
            ->pluck('outage_count', 'month'); // Fetching data in [month => count] format

        $cuts = DB::table('power_cuts')
            ->selectRaw('MONTH(start_time) as month, COUNT(*) as outage_cut')
            ->whereYear('start_time', now()->year)
            ->groupBy(DB::raw('MONTH(start_time)'))
            ->orderBy(DB::raw('MONTH(start_time)'))
            ->pluck('outage_cut', 'month'); // Fetching data in [month => count] format

        $failures = DB::table('power_failures')
            ->selectRaw('MONTH(failure_date) as month, COUNT(*) as outage_failure')
            ->whereYear('failure_date', now()->year)
            ->groupBy(DB::raw('MONTH(failure_date)'))
            ->orderBy(DB::raw('MONTH(failure_date)'))
            ->pluck('outage_failure', 'month'); // Fetching data in [month => count] format

        // Generate months array with 0 values for months that have no data
        $labels = ['1 сар', '2 сар', '3 сар', '4 сар', '5 сар', '6 сар', '7 сар', '8 сар', '9 сар', '10 сар', '11 сар', '12 сар'];

        $dataOutages = [];
        $dataCuts = [];
        $dataFailures = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataOutages[] = $outages->get($i, 0); // If month data is missing, use 0
            $dataCuts[] = $cuts->get($i, 0); // If month data is missing, use 0
            $dataFailures[] = $failures->get($i, 0); // If month data is missing, use 0
        }

        // Query to get equipment count for each branch
        $equipments = DB::table('equipment')
            ->select(
                'branch_id',
                DB::raw("CONCAT(FLOOR(YEAR(production_date) / 10) * 10, '-', FLOOR(YEAR(production_date) / 10) * 10 + 9) AS decade"),
                DB::raw('COUNT(*) AS equipment_count')
            )
            ->groupBy('branch_id', 'decade')
            ->get();

        // Convert to array for JavaScript
        $equipmentsByBranch = [];
        foreach ($equipments as $equipment) {
            $equipmentsByBranch[$equipment->branch_id][$equipment->decade] = $equipment->equipment_count;
        }

        // Fetch all branches
        $branches = Branch::all(); // This retrieves all branches

        $orderJournals = OrderJournal::whereDate('created_at', '>=', Carbon::now()->subDays(3))->get();

        return view('home', compact('stationCount', 'equipmentCount', 'powerlineCount', 'userCount', 'labels', 'dataOutages', 'dataCuts', 'dataFailures', 'equipmentsByBranch', 'branches', 'orderJournals'));
    }
}