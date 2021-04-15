<?php

namespace App\Http\Controllers;

use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'penjualan' => $penjualan       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = new Penjualan();
        $penjualan->tanggal = $request->tanggal;
        $penjualan->noPenjualan = $request->noPenjualan;
        $penjualan->kodeBarang = $request->kodeBarang;
        $penjualan->namaBarang = $request->namaBarang;
        $penjualan->qty = $request->qty;
        $penjualan->harga = $request->harga;
        $penjualan->totalHarga = $request->totalHarga;
        $penjualan->totalBayar = $request->totalBayar;
        $penjualan->disc = $request->disc;
        $penjualan->totalPembayaran = $request->totalPembayaran;
        $penjualan->kembalian = $request->kembalian;
        $penjualan->save();

        $penjualan = Penjualan::all();

        return view('penjualan_index', [
            'penjualan' => $penjualan
        ]);
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

    public function edit($id)
    {
        $penjualan = DB::table('penjualan')->where('id',$id)->get();
        return view('penjualan_edit',['penjualan' => $penjualan]);
    }

    public function update(Request $request, $id)
    {
        // update data supplier
	    DB::table('penjualan')->where('id',$request->id)->update([
		'tanggal' => $request->tanggal,
		'noPenjualan' => $request->noPenjualan,
		'kodeBarang' => $request->kodeBarang,
        'namaBarang' => $request->namaBarang,
        'qty' => $request->qty,
        'satuan' => $request->satuan,
        'harga' => $request->harga,
        'totalHarga' => $request->totalHarga,
        'totalBayar' => $request->totalBayar,
        'disc' => $request->disc,
        'totalPembayaran' => $request->totalPembayaran,
        'kembalian' => $request->kembalian,
        ]);
        // alihkan halaman ke halaman supplier
        return redirect()->route('penjualan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        $penjualan = Penjualan::all();

        return view('penjualan_index', [
            'penjualan' => $penjualan
        ]);
    }
}
