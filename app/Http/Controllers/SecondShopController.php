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
            "stocks" => Stock::searchByPositionAndItemName($positionId, $search)
                ->latest()
                ->paginate(100)
                ->appends(['search' => $search]),
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
        } elseif ($request->position == 'GUDANG' && $stock->stock >= 1 && $selisih_stock >= 0) {
            $stock->item_id = $stock->item_id;
            $stock->stock = $stock->stock - $data['quantity'];
            $stock->position_id = $stock->position_id;
            if ($stock->stock > 0) {
                $stock->status = 'aktif';
            } else {
                $stock->status = 'nonaktif';
            }
            $stock->save();

            $stock_three = Stock::where('item_id', $stock->item_id)->where('position_id', '3')->firstOrFail();
            $stock_three->item_id = $stock_three->item_id;
            $stock_three->stock = $stock_three->stock + $data['quantity'];
            $stock_three->position_id = $stock_three->position_id;
            if ($stock_three->stock > 0) {
                $stock_three->status = 'aktif';
            } else {
                $stock_three->status = 'nonaktif';
            }
            $stock_three->save();
            return back()->with('success', 'Stok barang berhasil diubah!');
        } else {
            return back()->with('error', 'Stock gagal dimasukkan!');
        }
        return back();
        // return redirect()->route('first-shop')->with('success', 'Data barang berhasil diubah!');
    }
}
