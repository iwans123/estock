<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        return view('item', [
            "items" => Item::filter($search)
                ->latest()
                ->paginate(100)
                ->appends(['search' => $search]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('item_form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            // 'code' => 'required|max:20|unique:items,code',
            'name' => 'required|max:255',
            // 'brand' => 'required|max:20',
            'category_id' => 'required',
            'part_number' => 'nullable|max:255|unique:items,part_number',
            'price_code' => 'nullable|max:255',
            'price_first' => 'required|numeric|min:0',
            'price_second' => 'nullable|numeric|min:0',
            'description' => 'nullable|max:255',
        ]);
        $category = Category::find($data['category_id']);
        $prefix = $category->code_category;
        $code = Item::generatePartNumber($prefix);

        $item = new Item();
        $item->code = $code;
        $item->name = $data['name'];
        $item->part_number = $data['part_number'];
        $item->category_id = $data['category_id'];
        $item->price_code = $data['price_code'];
        $item->price_first = $data['price_first'];
        $item->price_second = $data['price_second'];
        $item->description = $data['description'];
        $item->save();

        $stock_one = new Stock();
        $stock_one->item_id = $item->id;
        $stock_one->position_id = '1';
        $stock_one->stock = '0';
        $stock_one->save();

        $stock_two = new Stock();
        $stock_two->item_id = $item->id;
        $stock_two->position_id = '2';
        $stock_two->stock = '0';
        $stock_two->save();

        $stock_three = new Stock();
        $stock_three->item_id = $item->id;
        $stock_three->position_id = '3';
        $stock_three->stock = '0';
        $stock_three->save();

        // flash('Data berhasil disimpan')->success();
        return back()->with('success', 'Data barang berhasil ditambahkan!');
        // return redirect()->route('item')->with('success', 'Data barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     $item = Item::find($id);

    //     return view('items.show-modal', compact('item'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::get();

        return view('item_form', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            // 'code' => 'required|max:20|unique:items,code,' . $id,
            'name' => 'required|max:255',
            'part_number' => 'nullable|max:255|unique:items,part_number,' . $id,
            'category_id' => 'required',
            'price_code' => 'nullable|max:255',
            'price_first' => 'nullable|numeric|min:0',
            'price_second' => 'nullable|numeric|min:0',
            'description' => 'nullable|max:255',
        ]);

        $category = Category::find($data['category_id']);
        $prefix = $category->code_category;
        $newCode = Item::generatePartNumber($prefix);

        // $newCode = str_replace($item->category->code_category, $category->code_category, $item->code);

        $item = Item::findOrFail($id);

        if ($item->category_id == $data['category_id']) {
            $item->code = $item->code;
        } else {
            $item->code = $newCode;
        }

        $item->name = $data['name'];
        $item->part_number = $data['part_number'];
        $item->category_id = $data['category_id'];
        $item->price_code = $data['price_code'];
        $item->price_first = $data['price_first'];
        $item->price_second = $data['price_second'];
        $item->description = $data['description'];
        $item->save();


        // return back()->with('success', 'Data barang berhasil diubah!');
        // Item::find($id)->update($validate);

        return redirect()->route('item.index')->with('success', 'Data barang berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Stock::where('item_id', $id)->delete();
        Item::find($id)->delete();

        return back()->with('success', 'Data barang berhasil dihapus!');
    }

    public function generateBarcode($id)
    {
        $item = Item::find($id);
        // $d = new DNS1D();
        // $barcode = $d->getBarcodePNG("123456789", "C39");
        // $data = [
        //     'barcode' => $d->getBarcodeHTML("123456789", 'C39+', 3, 33)
        // ];
        $customPaper = array(0, 0, 400, 350);
        $pdf = FacadePdf::loadView('pdf.barcode', compact('item'));
        $pdf->setPaper($customPaper, 'potrait');
        return $pdf->stream('download.pdf');
    }

    // public function printBarcode()
    // {
    //     // Buat barcode
    //     $d = new DNS1D();
    //     $barcode = $d->getBarcodePNG("123456789", "C39");

    //     $profile = CapabilityProfile::load("simple");
    //     // Lokasi dan nama printer Anda
    //     $connector = new WindowsPrintConnector("thermalPrinter");

    //     $printer = new Printer($connector, $profile);

    //     // Cetak teks
    //     $printer->text("Barcode Test\n");

    //     // Cetak barcode
    //     $printer->setBarcodeHeight(30);
    //     $printer->barcode("123456789", Printer::BARCODE_CODE39);

    //     // Potong kertas (optional)
    //     // $printer->cut();

    //     // Tutup koneksi printer
    //     $printer->close();


    //     return back()->with('success', 'Data berhasil diprint!');
    // }
}
