<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPembelian;
use App\Pembelian;
use App\StatusItem;
use Illuminate\Http\Request;

class ReturnPembelianController extends Controller
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

        return view('returnpembelian_index', ['pembelian' => $pembelian]);
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

        return view('returnpembelian_show', ['pembelian' => $pembelian, 'pembelians' => $pembelians]);
    }

    public function return($id, $idItem)
    {
        $pembelian = Pembelian::findOrFail($id);
        $item = ItemPembelian::findOrFail($idItem);
        $status = StatusItem::where('noItemPembelian', $item->noItemPembelian)->first();
        $barang = Barang::where('kodeBarang', $item->kodeBarang)->first();

        $status->status = 'Sudah Diterima';
        $status->save();

        $barang->qty += $item->qty;
        $barang->save();

        return redirect()->route('return-pembelian.show', $pembelian->id);
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
