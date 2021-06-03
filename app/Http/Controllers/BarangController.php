<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();

        return view('barang_index', [
            'user' => $user,
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
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'kodeBarang' => 'required|unique:barang,kodeBarang|string',
                'namaBarang' => 'required|string',
                'qty' => 'required|integer',
                'satuan' => 'required|string',
                'hargaBeli' => 'required|integer',
                'hargaJual' => 'required|integer'
            ], $customMessages
        );

        $barang = new Barang();
        $barang->kodeBarang = $request->kodeBarang;
        $barang->namaBarang = $request->namaBarang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->hargaBeli = $request->hargaBeli;
        $barang->hargaJual = $request->hargaJual;
        $barang->save();

        toastr()->success('Barang berhasil ditambah');
        return redirect()->route('barang.index');
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
        $user = Auth::user();
        // mengambil data pegawai berdasarkan id yang dipilih
        $barang = DB::table('barang')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('barang_edit',['user' => $user, 'barang' => $barang]);
     
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'kodeBarang' => 'required|unique:barang,kodeBarang,'.$id.'|string',
                'namaBarang' => 'required|string',
                'satuan' => 'required|string',
                'hargaBeli' => 'required|integer',
                'hargaJual' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::findOrFail($id);
        $barang->kodeBarang = $request->kodeBarang;
        $barang->namaBarang = $request->namaBarang;
        $barang->satuan = $request->satuan;
        $barang->hargaBeli = $request->hargaBeli;
        $barang->hargaJual = $request->hargaJual;
        $barang->save();

        toastr()->success('Barang berhasil diubah');
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

        toastr()->success('Barang berhasil dihapus');
        return redirect()->route('barang.index');
    }
}
