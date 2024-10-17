<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Equipment;
use App\Models\OrderType;
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

        // dd($input);

        $request->validate([
            // 'branch_id' => 'required',
            'order_type_id' => 'required',
            'content' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            // 'created_user_id' => 'required',
        ]);

        OrderJournal::create($input);

        return redirect()->route('order-journals.index')
            ->with('success', 'Order Journal created successfully.');
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
        return view('order-journals.edit', compact('orderJournal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderJournal $orderJournal)
    {
        $request->validate([
            'branch_id' => 'required',
            'order_type_id' => 'required',
            'order_number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'created_user_id' => 'required',
            'status_id' => 'required',
        ]);

        $orderJournal->update($request->all());

        return redirect()->route('order-journals.index')
            ->with('success', 'Order Journal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderJournal $orderJournal)
    {
        $orderJournal->delete();

        return redirect()->route('order-journals.index')
            ->with('success', 'Order Journal deleted successfully.');
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

        return redirect()->route('order-journals.index')
            ->with('success', 'Order received successfully.');
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

        return redirect()->route('order-journals.index')
            ->with('success', 'Order approved successfully.');
    }

    public function cancel(Request $request, OrderJournal $orderJournal)
    {
        // Update the order status to 4 (Cancelled)
        $orderJournal->update([
            'order_status_id' => $request->order_status_id,
            'canceled_at' => now(),  // Set the canceled_at timestamp
        ]);

        return redirect()->route('order-journals.index')
            ->with('success', 'Order cancelled successfully.');
    }
}
