<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\OrderType;
use App\Helpers\LogActivity;
use App\Models\OrderJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\OrderJournalExport;
use App\Models\JournalStatusChange;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;

class OrderJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $orderJournals = OrderJournal::latest()->paginate(25);
        $query = OrderJournal::query();

        // Get the authenticated user's branch_id
        $userBranchId = auth()->user()->branch_id;

        // Check if the user's branch_id is not 6
        if ($userBranchId != 8) {
            $query->where('branch_id', $userBranchId);
        }

        // Apply branch filter from the request if branch_id = 6 or the user wants to filter
        if ($userBranchId == 8 && $request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }

        if ($request->filled('order_type_id')) {
            $query->where('order_type_id', $request->input('order_type_id'));
        }

        if ($request->filled('starttime') && $request->filled('endtime')) {
            $query->whereBetween('created_at', [$request->input('starttime'), $request->input('endtime')]);
        }

        // Paginate results
        $orderJournals = $query->latest()->paginate(25)->appends($request->query());

        $branches = Branch::orderBy('name', 'asc')->get();
        $orderTypes = OrderType::all();

        return view('order-journals.index', compact('orderJournals', 'branches', 'orderTypes'))
            ->with('i', (request()->input('page', 1) - 1) * 25);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userBranchId = auth()->user()->branch_id;

        // Retrieve stations conditionally
        if ($userBranchId != 8) {
            // If the user's branch_id is not 6, retrieve only stations for their branch
            $stations = Station::where('branch_id', $userBranchId)->get();
        } else {
            // If the user's branch_id is 6, retrieve all stations
            $stations = Station::all();
        }

        $equipments = Equipment::all();
        $orderTypes = OrderType::all();

        return view('order-journals.create', compact('stations', 'equipments', 'orderTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        $hour = now()->hour; // Get the current hour (24-hour format)

        // Check if the user is allowed to bypass restrictions
        $canBypass = $user->role->name == 'admin' || $user->can_bypass_restrictions;

        if (!$canBypass && ($hour < 9 || $hour > 11) && ($input['order_type_id'] ?? null) != 3) {
            return redirect()->back()->withErrors(['error' => 'Зөвхөн 09:00 цагаас 11:00 цагийн хооронд захиалга бүртгэх боломжтой.']);
        }


        $input['branch_id'] = $user->branch_id;
        $input['created_user_id'] = $user->id;
        $input['order_status_id'] = 1; // Илгээсэн

        // Get the current year
        $currentYear = now()->year;

        // Find the latest order for the current year and get its number
        $latestOrder = OrderJournal::whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();

        // If there is an order in the current year, increment the number, otherwise start from 1
        // $orderNumber = $latestOrder ? $latestOrder->order_number + 1 : 1;
        // $input['order_number'] = $orderNumber;

        $request->validate([
            'order_type_id' => 'required',
            'content' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        OrderJournal::create($input);

        LogActivity::addToLog("Захиалга амжилттай хадгалагдлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга амжилттай хадгалагдлаа.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderJournal $orderJournal)
    {
        return view('order-journals.show', compact('orderJournal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderJournal $orderJournal)
    {
        $userBranchId = auth()->user()->branch_id;

        // Retrieve stations conditionally
        if ($userBranchId != 8) {
            // If the user's branch_id is not 6, retrieve only stations for their branch
            $stations = Station::where('branch_id', $userBranchId)->get();
        } else {
            // If the user's branch_id is 6, retrieve all stations
            $stations = Station::all();
        }

        $equipments = Equipment::all();
        $orderTypes = OrderType::all();

        return view('order-journals.edit', compact('orderJournal', 'stations', 'equipments', 'orderTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderJournal $orderJournal)
    {
        $request->validate([
            'order_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $orderJournal->update($request->all());

        LogActivity::addToLog("Захиалга амжилттай засагдлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderJournal $orderJournal)
    {
        $orderJournal->delete();

        LogActivity::addToLog("Захиалга амжилттай устгагдлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга амжилттай устгагдлаа.');
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_status_id' => 'required|integer',
            'order_journal_id' => 'required|exists:order_journals,id',
            'comment' => 'required|string',
        ]);

        // Update the order journal's status
        $orderJournal = OrderJournal::find($request->order_journal_id);
        $orderJournal->order_status_id = $request->order_status_id;
        $orderJournal->save();

        // Save the comment in a separate table
        JournalStatusChange::create([
            'order_journal_id' => $request->order_journal_id,
            'status_id' => $request->order_status_id,
            'comment' => $request->comment,
            'changed_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Статус амжилттай өөрчлөгдлөө!']);
    }

    public function getStatusChanges(OrderJournal $orderJournal)
    {
        $statusChanges = $orderJournal->statusChanges()
            ->with(['status', 'changedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($statusChanges);
    }



    public function export(Request $request)
    {
        $query = OrderJournal::query();

        // Apply filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('order_type_id')) {
            $query->where('order_type_id', $request->input('order_type_id'));
        }

        // Get the filtered data
        $orderJournals = $query->get();

        return Excel::download(new OrderJournalExport($orderJournals), 'order_journal_data.xlsx');
    }
}
