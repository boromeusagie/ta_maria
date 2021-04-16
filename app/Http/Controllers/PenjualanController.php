<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPenjualan;
use App\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\toastr;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::all();

        return view('penjualan_index', [
            'penjualan' => $penjualan
        ]);
    }

    /**
     * Display a order pembelian form.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderPenjualan()
    {
        $barangs = Barang::all();

        return view('penjualan', [
            'barangs' => $barangs
        ]);
    }

    /**
     * Display a order pembelian form.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanShow($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $barangs = Barang::all();

        return view('penjualanShow', [
            'penjualan' => $penjualan,
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
                'noPenjualan' => 'required|unique:penjualan,noPenjualan',
                'kodeBarang' => 'string',
                'qty' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::where('kodeBarang', $request->namaBarang)->first();

        $newPenjualan = new Penjualan();
        $newPenjualan->tanggal = $request->tanggal;
        $newPenjualan->noPenjualan = $request->noPenjualan;
        $newPenjualan->save();

        $newItem = new ItemPenjualan();
        $newItem->noFaktur = $newPenjualan->noPenjualan;
        $newItem->noItemPenjualan = ItemPenjualan::count() + 1;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga = (int) $barang->hargaJual * (int) $request->qty;
        $newItem->save();


        toastr()->success('Barang berhasil ditambahkan');
        return redirect()->route('penjualan.ordershow', $newPenjualan->id);
    }

    public function orderPenjualanStore(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);

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

        $newItem = new ItemPenjualan();
        $newItem->noPenjualan = $penjualan->noPenjualan;
        $newItem->noItemPenjualan = ItemPenjualan::count() + 1;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga = (int) $barang->hargaJual * (int) $request->qty;
        $newItem->save();


        toastr()->success('Barang berhasil ditambahkan');
        return redirect()->route('penjualan.ordershow', $penjualan->id);
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
        $penjualan = Penjualan::findOrFail($id);

        $item = ItemPenjualan::findOrFail($itemId);
        $item->delete();

        toastr()->success('Barang berhasil dihapus');
        return redirect()->route('penjualan.ordershow', $penjualan->id);
    }
}
