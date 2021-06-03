<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPembelian;
use App\Kas;
use App\Pembelian;
use App\PenerimaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pembelian = Pembelian::whereHas('items', function($q) {
            $q->where('status', 'Belum Diterima');
        })->get();

        return view('penerimaanbarang_index', ['user' => $user, 'pembelian' => $pembelian]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $pembelian = Pembelian::findOrFail($id);
        $pembelians = Pembelian::whereHas('items', function($q) {
            $q->where('status', 'Belum Diterima');
        })->get();

        return view('penerimaanbarang_show', ['user' => $user, 'pembelian' => $pembelian, 'pembelians' => $pembelians]);
    }

    public function terimaBarang(Request $request, $id, $idItem)
    {
        $pembelian = Pembelian::findOrFail($id);
        $item = ItemPembelian::findOrFail($idItem);
        $barang = Barang::where('kodeBarang', $item->kodeBarang)->first();
        $kas = Kas::whereHas('pembelian', function ($q) use ($id) {
            $q->where('id', $id);
        })->first();

        // $qty = 'qty'.$item->noItemPembelian;

        $beforePrice = $item->totalHarga;
        $afterPrice = $barang->hargaBeli * $item->qty;

        $item->status = 'Sudah Diterima';
        $item->save();

        if ($beforePrice != $afterPrice) {
            $pembelian->totalBayar -= $item->totalHarga;
            $pembelian->save();
            $item->totalHarga = (int) $barang->hargaBeli * (int) $item->qty;
            $item->save();
            $pembelian->totalBayar += $item->totalHarga;
            $pembelian->save();
        }

        $newPenerimaan = new PenerimaanBarang();
        $newPenerimaan->noItemPembelian = $item->noItemPembelian;
        $newPenerimaan->kodeBarang = $item->kodeBarang;
        $newPenerimaan->qty = $request->qty;
        $newPenerimaan->harga = $barang->hargaBeli;
        $newPenerimaan->totalHarga = $request->qty * $barang->hargaBeli;
        $newPenerimaan->save();


        $barang->qty += $item->qty;
        $barang->save();

        $kas->kasKeluar = $pembelian->totalBayar;
        $kas->save();

        toastr()->success($barang->namaBarang.' sudah diterima');
        return redirect()->route('penerimaan-barang.show', $pembelian->id);
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
}
