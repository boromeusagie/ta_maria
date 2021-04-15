<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPembelian;
use App\Pembelian;
use App\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::all();

        return view('pembelian_index', [
            'pembelian' => $pembelian
        ]);
    }

    /**
     * Display a order pembelian form.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderPembelian()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('order_pembelian', [
            'suppliers' => $suppliers,
            'barangs' => $barangs
        ]);
    }

    /**
     * Display a order pembelian form.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderPembelianShow($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('order_pembelian_show', [
            'pembelian' => $pembelian,
            'suppliers' => $suppliers,
            'barangs' => $barangs
        ]);
    }

    public function getSatuan(Request $request, $kodeBarang)
    {
        $barang = Barang::where('kodeBarang', $kodeBarang)->first();
        $satuan = $barang->satuan;

        return response()->json(['satuan' => $satuan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'tanggal' => 'required|date',
                'noFaktur' => 'required|unique:pembelian,noFaktur',
                'supplier' => 'string',
                'kodeBarang' => 'string',
                'qty' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::where('kodeBarang', $request->namaBarang)->first();

        $newPembelian = new Pembelian();
        $newPembelian->tanggal = $request->tanggal;
        $newPembelian->noFaktur = $request->noFaktur;
        $newPembelian->kodeSupplier = $request->kodeSupplier;
        $newPembelian->save();

        $newItem = new ItemPembelian();
        $newItem->noFaktur = $newPembelian->noFaktur;
        $newItem->noItemPembelian = ItemPembelian::count() + 1;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga = (int) $barang->hargaBeli * (int) $request->qty;
        $newItem->save();


        toastr()->success('Barang berhasil ditambahkan');
        return redirect()->route('pembelian.ordershow', $newPembelian->id);
    }

    public function orderPembelianStore(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'kodeBarang' => 'string',
                'qty' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::where('kodeBarang', $request->namaBarang)->first();

        $newItem = new ItemPembelian();
        $newItem->noFaktur = $pembelian->noFaktur;
        $newItem->noItemPembelian = ItemPembelian::count() + 1;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga = (int) $barang->hargaBeli * (int) $request->qty;
        $newItem->save();


        toastr()->success('Barang berhasil ditambahkan');
        return redirect()->route('pembelian.ordershow', $pembelian->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function itemDestroy($id, $itemId)
    {
        $pembelian = Pembelian::findOrFail($id);

        $item = ItemPembelian::findOrFail($itemId);
        $item->delete();

        toastr()->success('Barang berhasil dihapus');
        return redirect()->route('pembelian.ordershow', $pembelian->id);
    }
}
