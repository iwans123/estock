<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalMonth = Order::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('total_price');
        $totalToday = Order::whereDate('created_at', Carbon::today())->sum('total_price');
        return view('dashboard', compact('totalToday', 'totalMonth'));
    }

    public function chart()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $orders = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as totals')->groupBy('date')->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->get();

        // dd($orders);
        // $formattedOrders = $orders->map(function ($order) {
        //     $order->totals = formatRupiah($order->totals);
        //     return $order;
        // });
        return response()->json($orders);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
