<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();

        return view('barang_index', [
            'barangs' => $barang
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barang = new Barang();
        $barang->kodeBarang = $request->kodeBarang;
        $barang->namaBarang = $request->namaBarang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->hargaBeli = $request->hargaBeli;
        $barang->hargaJual = $request->hargaJual;
        $barang->save();

        $barangs = Barang::all();

        return view('barang_index', [
            'barangs' => $barangs
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
        // mengambil data pegawai berdasarkan id yang dipilih
        $barang = DB::table('barang')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('barang_edit',['barang' => $barang]);
     
    }

    public function update(Request $request, $id)
    {
        // update data supplier
	    DB::table('barang')->where('id',$request->id)->update([
		'kodeBarang' => $request->kodeBarang,
		'namaBarang' => $request->namaBarang,
        'hargaBeli' => $request->hargaBeli,
        'hargaJual' => $request->hargaJual
        ]);
        // alihkan halaman ke halaman supplier
        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        $barangs = Barang::all();

        return view('barang_index', [
            'barangs' => $barangs        ]);
    }
}
