<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class FirstShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positionId = 1;
        $search = $request->input('search');

        return view('first_shop.index', [
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
            // flash('Data berhasil dimasukkan')->success();
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
            $stock_two->status = $stock_two->status;
            if ($stock_two->stock > 0) {
                $stock_two->status = 'aktif';
            } else {
                $stock_two->status = 'nonaktif';
            }
            $stock_two->save();

            return back()->with('success', 'Stok barang berhasil ditransfer!');
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
            $stock_three->status = $stock_three->status;
            if ($stock_three->stock > 0) {
                $stock_three->status = 'aktif';
            } else {
                $stock_three->status = 'nonaktif';
            }
            $stock_three->save();

            return back()->with('success', 'Stok barang berhasil ditransfer!');
        } else {
            return back()->with('error', 'Stock gagal dimasukkan!');
            // flash('Data gagal dimasukkan')->error();
        }
        return redirect()->back()->withInput()->withErrors(['quantity' => 'Validation failed!']);
        // return redirect()->route('first-shop')->with('success', 'Data barang berhasil diubah!');
    }
}
