<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPembelian;
use App\ItemReturnPembelian;
use App\Pembelian;
use App\ReturnPembelian;
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

    public function return(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'noReturn' => 'required|string',
                'checks' => 'required'
            ], $customMessages
        );

        $pembelian = Pembelian::findOrFail($id);

        $newReturn = new ReturnPembelian();
        $newReturn->tanggal = $request->tanggal;
        $newReturn->noReturn = $request->noReturn;
        $newReturn->noFaktur = $request->noFaktur;
        $newReturn->kodeSupplier = $pembelian->kodeSupplier;
        $newReturn->save();

        foreach ($request->checks as $key => $value) {
            $itemPembelian = ItemPembelian::findOrFail($key);

            $newItemReturn = new ItemReturnPembelian();
            $newItemReturn->noReturn = $newReturn->noReturn;
            $newItemReturn->kodeBarang = $itemPembelian->kodeBarang;
            $newItemReturn->qty = $itemPembelian->qty;
            $newItemReturn->totalHarga = $itemPembelian->totalHarga;
            $newItemReturn->save();

            $newReturn->totalReturn += $newItemReturn->totalHarga;
            $newReturn->save();

            $status = StatusItem::where('noItemPembelian', $itemPembelian->noItemPembelian)->first();
            $status->status = 'Return';
            $status->save();

            $pembelian->totalBayar -= $newItemReturn->totalHarga;
            $pembelian->save();
        }

        toastr()->success('Barang berhasil di return');
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
