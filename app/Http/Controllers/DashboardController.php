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

        $totalFirst = Order::whereHas('stock', function ($query) {
            $query->where('position_id', '1');
        })
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->sum('total_price');
        $totalSecond = Order::whereHas('stock', function ($query) {
            $query->where('position_id', '2');
        })
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->sum('total_price');

        return view('dashboard', compact('totalToday', 'totalMonth', 'totalFirst', 'totalSecond', 'currentMonth'));
    }

    public function chart()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        // $orders = Order::selectRaw('YEAR(created_at) year, MONTH(created_at) month, SUM(total_price) total')
        //     ->groupBy('year', 'month')
        //     ->whereMonth('created_at', $currentMonth)
        //     ->whereYear('created_at', $currentYear)->get();


        $monthlyOrders = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, sum(total_price) as total_orders')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // Format data untuk chart
        $labelsOrder = $monthlyOrders->pluck('month')->map(function ($month) {
            return Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });

        $valuesOrder = $monthlyOrders->pluck('total_orders');


        $firstShop = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as totals')
            ->groupBy('date')
            ->orderBy('date')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('stock', function ($query) {
                $query->where('position_id', '1');
            })->get();

        $secondShop = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as totals')
            ->groupBy('date')
            ->orderBy('date')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('stock', function ($query) {
                $query->where('position_id', '2');
            })->get();

        // dd($orders);
        // $formattedOrders = $orders->map(function ($order) {
        //     $order->totals = formatRupiah($order->totals);
        //     return $order;
        // });
        // \Log::info('firstShop:', $firstShop->toArray());
        // \Log::info('Second Shop:', $secondShop->toArray());
        return response()->json([
            'shop1' => $firstShop,
            'shop2' => $secondShop,
            'labelsOrder' => $labelsOrder,
            'valuesOrder' => $valuesOrder
        ]);
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
