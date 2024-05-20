<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin|toko-1')) {
            $positionId = 1;
        } elseif (auth()->user()->hasRole('admin|toko-2')) {
            $positionId = 2;
        }


        $search = $request->input('search');
        $searchOrder = $request->input('search_order');
        $searchItem = $request->input('search_item');

        // dd(Stock::searchByPositionAndItemName($positionId, $searchItem)->first());
        return view('order.index', [
            "data" => Stock::searchByPositionAndItemName($positionId, $search)->where('status', 'aktif')->paginate(10),
            "stock" => Stock::searchByPositionAndItemName($positionId, $searchItem)->first(),
            "orders" => Order::search($searchOrder)->whereDate('created_at', Carbon::today())->latest()->paginate(10),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $stock = Stock::find($data['id']);

        if ($stock->status == 'nonaktif') {
            flash('Data Tidak bisa dimasukkan')->error();
        } elseif ($stock->stock <= 0) {
            flash('Data Tidak bisa dimasukkan')->error();
        } else {
            // save order
            $order = new Order();
            $order->stock_id = $stock->id;
            $order->price = $stock->item->price_first;
            $order->quantity = $data['quantity'];
            $order->total_price = ($stock->item->price_first * $data['quantity']);
            $order->save();

            // save stock
            $stock->item_id = $stock->item_id;
            $stock->stock = ($stock->stock - $data['quantity']);
            $stock->position_id = $stock->position_id;
            $stock->save();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        $stock = Stock::find($order->stock->id);
        $stock->item_id = $stock->item_id;
        $stock->stock = $stock->stock + $order->quantity;
        $stock->position_id = $stock->position_id;
        $stock->save();

        return back();
    }
}
