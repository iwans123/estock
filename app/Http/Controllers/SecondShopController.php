<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class SecondShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positionId = 2;
        $search = $request->input('search');

        return view('second_shop.index', [
            "stocks" => Stock::searchByPositionAndItemName($positionId, $search)->latest()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'integer|min:0',
        ]);

        $stock = Stock::findOrFail($id);
        if ($request->status) {
            // save stock
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock + $data['quantity'];
            $stock->position_id = $stock->position_id;
            $stock->status = $request->status;
            $stock->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } elseif ($request->position == 'TOKO_1' && $stock->stock >= 1) {
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock - $data['quantity'];
            $stock->position_id = $stock->position_id;
            $stock->status = $stock->status;
            $stock->save();

            $stock_one = Stock::where('item_id', $stock->item_id)->where('position_id', '1')->firstOrFail();
            $stock_one->item_id = $stock_one->item_id;
            $stock_one->stock = $stock_one->stock + $data['quantity'];
            $stock_one->position_id = $stock_one->position_id;
            $stock_one->status = $stock_one->status;
            $stock_one->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } elseif ($request->position == 'GUDANG' && $stock->stock >= 1) {
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock - $data['quantity'];
            $stock->position_id = $stock->position_id;
            $stock->status = $stock->status;
            $stock->save();

            $stock_three = Stock::where('item_id', $stock->item_id)->where('position_id', '3')->firstOrFail();
            $stock_three->item_id = $stock_three->item_id;
            $stock_three->stock = $stock_three->stock + $data['quantity'];
            $stock_three->position_id = $stock_three->position_id;
            $stock_three->status = $stock_three->status;
            $stock_three->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } else {
            return back()->with('error', 'Stock gagal dimasukkan!');
        }
        return back();
        // return redirect()->route('first-shop')->with('success', 'Data barang berhasil diubah!');
    }
}
