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
        $supplier = new Supplier();
        $supplier->kodeSupplier = $request->kodeSupplier;
        $supplier->namaSupplier = $request->namaSupplier;
        $supplier->almtSupplier = $request->almtSupplier;
        $supplier->tlpSupplier = $request->tlpSupplier;
        $supplier->save();

        $supplier = Supplier::all();

        return view('supplier_index', [
            'supplier' => $supplier
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
        $supplier = DB::table('supplier')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('supplier_edit',['supplier' => $supplier]);
     
    }

    public function update(Request $request, $id)
    {
        // update data supplier
	    DB::table('supplier')->where('id',$request->id)->update([
        'kodeSupplier' => $request->kodeSupplier,
		'namaSupplier' => $request->namaSupplier,
		'almtSupplier' => $request->almtSupplier,
		'tlpSupplier' => $request->tlpSupplier
        ]);
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

        $supplier = Supplier::all();

        return view('supplier_index', [
            'supplier' => $supplier
        ]);
    }
}
