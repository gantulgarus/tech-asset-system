<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Powerline;
use App\Models\LogActivity;
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
    public function index(Request $request)
    {
        // Get the logged-in user
        $user = auth()->user();

        if ($user->branch_id == 8) {
            $branches = Branch::all();
            $branchId = $request->get('branch_id');
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
            $branchId = $user->branch_id;
        }

        $stationCountUser = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Дэд станц')->where('is_user_station', 0)->count();

        $stationCountOwn = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Дэд станц')->where('is_user_station', 1)->count();


        $ortooCountUser = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Дэд өртөө')->where('is_user_station', 0)->count();
        $ortooCountOwn = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Дэд өртөө')->where('is_user_station', 1)->count();

        $baiguulamjCountUser = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Хуваарилах байгууламж')->where('is_user_station', 0)->count();
        $baiguulamjCountOwn = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->where('station_type', 'Хуваарилах байгууламж')->where('is_user_station', 1)->count();


        $equipmentCount = Equipment::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->count();

        $powerlineCount = Powerline::when($branchId, function ($query, $branchId) {
            return $query->whereHas('station', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            });
        })->count();

        $totalCapacityUser = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })
            ->where('station_category', 'Түгээх')
            ->where('is_user_station', 0)
            ->selectRaw('SUM(COALESCE(installed_capacity, 0) + COALESCE(second_capacity, 0)) as total_capacity')
            ->value('total_capacity');


        $totalCapacityOwn = Station::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })
            ->where('station_category', 'Түгээх')
            ->where('is_user_station', 1)
            ->selectRaw('SUM(COALESCE(installed_capacity, 0) + COALESCE(second_capacity, 0)) as total_capacity')
            ->value('total_capacity');


        $powerlineLength = Powerline::when($branchId, function ($query, $branchId) {
            return $query->whereHas('station', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            });
        })->where('line_type', 'ЦДАШ')->sum('line_length');
        $powercableLength = Powerline::when($branchId, function ($query, $branchId) {
            return $query->whereHas('station', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            });
        })->where('line_type', 'ЦДКШ')->sum('line_length');

        // $cablelineLength = Equipment::when($branchId, function ($query, $branchId) {
        //     return $query->whereHas('station', function ($query) use ($branchId) {
        //         $query->where('branch_id', $branchId);
        //     });
        // })->sum('');


        $userCount = User::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })->count();

        $currentYear = Carbon::now()->year;

        $outages = DB::table('power_outages')
            ->join('stations', 'power_outages.station_id', '=', 'stations.id') // Join with stations
            ->selectRaw('MONTH(power_outages.start_time) as month, COUNT(*) as outage_count')
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('stations.branch_id', $branchId);
            })
            ->whereYear('power_outages.start_time', $currentYear)
            ->groupBy(DB::raw('MONTH(power_outages.start_time)'))
            ->orderBy(DB::raw('MONTH(power_outages.start_time)'))
            ->pluck('outage_count', 'month');

        $cuts = DB::table('power_cuts')
            ->join('stations', 'power_cuts.station_id', '=', 'stations.id') // Join with stations
            ->selectRaw('MONTH(power_cuts.start_time) as month, COUNT(*) as outage_cut')
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('stations.branch_id', $branchId);
            })
            ->whereYear('power_cuts.start_time', $currentYear)
            ->groupBy(DB::raw('MONTH(power_cuts.start_time)'))
            ->orderBy(DB::raw('MONTH(power_cuts.start_time)'))
            ->pluck('outage_cut', 'month');

        $failures = DB::table('power_failures')
            ->join('stations', 'power_failures.station_id', '=', 'stations.id') // Join with stations
            ->selectRaw('MONTH(power_failures.failure_date) as month, COUNT(*) as outage_failure')
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('stations.branch_id', $branchId);
            })
            ->whereYear('power_failures.failure_date', $currentYear)
            ->groupBy(DB::raw('MONTH(power_failures.failure_date)'))
            ->orderBy(DB::raw('MONTH(power_failures.failure_date)'))
            ->pluck('outage_failure', 'month');

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
        // $branches = Branch::all(); // This retrieves all branches

        $orderJournals = OrderJournal::when($branchId, function ($query, $branchId) {
            return $query->where('branch_id', $branchId);
        })
            ->where('created_at', '>=', now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('stationCountUser', 'stationCountOwn', 'equipmentCount', 'powerlineCount', 'userCount', 'labels', 'dataOutages', 'dataCuts', 'dataFailures', 'equipmentsByBranch', 'branches', 'orderJournals', 'branchId', 'powerlineLength', 'baiguulamjCountUser', 'baiguulamjCountOwn', 'totalCapacityUser', 'totalCapacityOwn', 'powercableLength', 'ortooCountUser', 'ortooCountOwn'));
    }

    public function logActivity()
    {
        $logs = LogActivity::latest()->paginate(25);
        // dd($logs);

        return view('log-activity', compact('logs'));
    }
}
