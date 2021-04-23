<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();

        return view('supplier_index', [
            'supplier' => $supplier       ]);
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
                'kodeSupplier' => 'required|unique:supplier,kodeSupplier|string',
                'namaSupplier' => 'required|string',
                'almtSupplier' => 'required|string',
                'tlpSupplier' => 'required|string'
            ], $customMessages
        );

        $supplier = new Supplier();
        $supplier->kodeSupplier = $request->kodeSupplier;
        $supplier->namaSupplier = $request->namaSupplier;
        $supplier->almtSupplier = $request->almtSupplier;
        $supplier->tlpSupplier = $request->tlpSupplier;
        $supplier->save();

        toastr()->success('Supplier berhasil dibuat');
        return redirect()->route('supplier.index');
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
        $supplier = DB::table('supplier')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('supplier_edit',['supplier' => $supplier]);
     
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'kodeSupplier' => 'required|unique:supplier,kodeSupplier,'.$id.'|string',
                'namaSupplier' => 'required|string',
                'almtSupplier' => 'required|string',
                'tlpSupplier' => 'required|string'
            ], $customMessages
        );

        // update data supplier
        $supplier = Supplier::findOrFail($id);
	    $supplier->kodeSupplier = $request->kodeSupplier;
        $supplier->namaSupplier = $request->namaSupplier;
        $supplier->almtSupplier = $request->almtSupplier;
        $supplier->tlpSupplier = $request->tlpSupplier;
        $supplier->save();

        toastr()->success('Supplier berhasil diubah');
        // alihkan halaman ke halaman supplier
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        toastr()->success('Supplier berhasil dihapus');
        // alihkan halaman ke halaman supplier
        return redirect()->route('supplier.index');
    }
}
