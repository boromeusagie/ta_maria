<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPembelian;
use App\Kas;
use App\Pembelian;
use App\StatusItem;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::whereHas('items', function($q) {
            $q->whereHas('status', function($s) {
                $s->where('status', 'Belum Diterima');
            });
        })->get();

        return view('penerimaanbarang_index', ['pembelian' => $pembelian]);
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
        $pembelian = Pembelian::findOrFail($id);
        $pembelians = Pembelian::whereHas('items', function($q) {
            $q->whereHas('status', function($s) {
                $s->where('status', 'Belum Diterima');
            });
        })->get();

        return view('penerimaanbarang_show', ['pembelian' => $pembelian, 'pembelians' => $pembelians]);
    }

    public function terimaBarang($id, $idItem)
    {
        $pembelian = Pembelian::findOrFail($id);
        $item = ItemPembelian::findOrFail($idItem);
        $status = StatusItem::where('noItemPembelian', $item->noItemPembelian)->first();
        $barang = Barang::where('kodeBarang', $item->kodeBarang)->first();
        $kas = Kas::whereHas('pembelian', function ($q) use ($id) {
            $q->where('id', $id);
        })->first();

        $beforePrice = $item->totalHarga;
        $afterPrice = $barang->hargaBeli * $item->qty;

        $status->status = 'Sudah Diterima';
        $status->save();

        if ($beforePrice != $afterPrice) {
            $pembelian->totalBayar -= $item->totalHarga;
            $pembelian->save();
            $item->totalHarga = (int) $barang->hargaBeli * (int) $item->qty;
            $item->save();
            $pembelian->totalBayar += $item->totalHarga;
            $pembelian->save();
        }


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
