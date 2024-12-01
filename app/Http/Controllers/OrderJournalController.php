<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Equipment;
use App\Models\OrderType;
use App\Helpers\LogActivity;
use App\Models\OrderJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderJournals = OrderJournal::latest()->paginate(25);
        return view('order-journals.index', compact('orderJournals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
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
        $input['branch_id'] = $user->branch_id;
        $input['created_user_id'] = $user->id;
        $input['order_status_id'] = 1; // Илгээсэн

        // Get the current year
        $currentYear = now()->year;

        // Find the latest order for the current year and get its number
        $latestOrder = OrderJournal::whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();

        // If there is an order in the current year, increment the number, otherwise start from 1
        $orderNumber = $latestOrder ? $latestOrder->order_number + 1 : 1;
        $input['order_number'] = $orderNumber;

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
        $stations = Station::all();
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

    public function receive(Request $request, OrderJournal $orderJournal)
    {
        $user = Auth::user();
        // Update the order status to 2
        $orderJournal->update([
            'order_status_id' => $request->order_status_id,
            'received_user_id' => $user->id,
            'received_at' => now(),  // Set the received_at timestamp
        ]);

        LogActivity::addToLog("Захиалга амжилттай хүлээн авлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга амжилттай хүлээн авлаа.');
    }

    public function approve(Request $request, OrderJournal $orderJournal)
    {
        $user = Auth::user();
        // Update the order status to 3 (Approved)
        $orderJournal->update([
            'order_status_id' => $request->order_status_id,
            'approved_user_id' => $user->id,
            'approved_at' => now(),  // Set the approved_at timestamp
        ]);

        LogActivity::addToLog("Захиалга амжилттай хүлээн батлагдлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга амжилттай хүлээн батлагдлаа.');
    }

    public function cancel(Request $request, OrderJournal $orderJournal)
    {
        // Update the order status to 4 (Cancelled)
        $orderJournal->update([
            'order_status_id' => $request->order_status_id,
            'canceled_at' => now(),  // Set the canceled_at timestamp
        ]);

        LogActivity::addToLog("Захиалга цуцлагдлаа.");

        return redirect()->route('order-journals.index')
            ->with('success', 'Захиалга цуцлагдлаа.');
    }
}