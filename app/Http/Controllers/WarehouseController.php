<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positionId = 3;
        $search = $request->input('search');

        return view('warehouse.index', [
            "stocks" => Stock::searchByPositionAndItemName($positionId, $search)->latest()->paginate(10),
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
        $selisih_stock = $stock->stock - $request->quantity;
        if ($request->stock) {
            // save stock
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock + $request->stock;
            $stock->position_id = $stock->position_id;
            if ($stock->stock > 0) {
                $stock->status = 'aktif';
            }
            $stock->save();
            return back()->with('success', 'Stok barang berhasil dimasukkan!');
        } elseif ($request->position == 'TOKO_1' && $stock->stock >= 1 && $selisih_stock >= 0) {
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock - $data['quantity'];
            $stock->position_id = $stock->position_id;
            if ($stock->stock > 0) {
                $stock->status = 'aktif';
            } else {
                $stock->status = 'nonaktif';
            }
            $stock->save();

            $stock_one = Stock::where('item_id', $stock->item_id)->where('position_id', '1')->firstOrFail();
            $stock_one->item_id = $stock_one->item_id;
            $stock_one->stock = $stock_one->stock + $data['quantity'];
            $stock_one->position_id = $stock_one->position_id;
            if ($stock_one->stock > 0) {
                $stock_one->status = 'aktif';
            } else {
                $stock_one->status = 'nonaktif';
            }
            $stock_one->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } elseif ($request->position == 'TOKO_2' && $stock->stock >= 1 && $selisih_stock >= 0) {
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock - $data['quantity'];
            $stock->position_id = $stock->position_id;
            if ($stock->stock > 0) {
                $stock->status = 'aktif';
            } else {
                $stock->status = 'nonaktif';
            }
            $stock->save();

            $stock_two = Stock::where('item_id', $stock->item_id)->where('position_id', '2')->firstOrFail();
            $stock_two->item_id = $stock_two->item_id;
            $stock_two->stock = $stock_two->stock + $data['quantity'];
            $stock_two->position_id = $stock_two->position_id;
            if ($stock_two->stock > 0) {
                $stock_two->status = 'aktif';
            } else {
                $stock_two->status = 'nonaktif';
            }
            $stock_two->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } else {
            return back()->with('error', 'Stock gagal dimasukkan!');
        }

        return back();
        // return redirect()->route('first-shop')->with('success', 'Data barang berhasil diubah!');
    }
}
