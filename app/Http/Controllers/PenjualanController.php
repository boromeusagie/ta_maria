<?php

namespace App\Http\Controllers;

use App\Barang;
use App\ItemPenjualan;
use App\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\toastr;
use App\Kas;
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
            'penjualan' => $penjualan
        ]);
    }

    /**
     * Display a order penjualan form.
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
    public function orderPenjualanShow($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $barangs = Barang::all();

        return view('penjualan_Show', [
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
                'namaBarang' => 'string',
                'qty' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::where('kodeBarang', $request->namaBarang)->first();

        $newPenjualan = new Penjualan();
        $newPenjualan->tanggal = $request->tanggal;
        $newPenjualan->noPenjualan = $request->noPenjualan;
        $newPenjualan->save();

        $newItem = new ItemPenjualan();
        $newItem->noPenjualan = $newPenjualan->noPenjualan;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga = (int) $barang->hargaJual * (int) $request->qty;
        $newItem->save();

        $newPenjualan->totalBayar += $newPenjualan->items->sum('totalHarga');
        $newPenjualan->save();
        $barang->qty -= $request->qty;
        $barang->save();


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
                'namaBarang' => 'string',
                'qty' => 'required|integer'
            ], $customMessages
        );

        $barang = Barang::where('kodeBarang', $request->namaBarang)->first();

        $newItem = new ItemPenjualan();
        $newItem->noPenjualan = $penjualan->noPenjualan;
        $newItem->kodeBarang = $request->namaBarang;
        $newItem->qty = (int) $request->qty;
        $newItem->totalHarga += (int) $barang->hargaJual * (int) $request->qty;
        $newItem->save();
        $penjualan->totalBayar = $penjualan->items->sum('totalHarga');
        $penjualan->save();
        $barang->qty -= $request->qty;
        $barang->save();


        toastr()->success('Barang berhasil ditambahkan');
        return redirect()->route('penjualan.ordershow', $penjualan->id);
    }

    public function cashierPenjualan(Request $request, $id){
        $penjualan = Penjualan::findOrFail($id);

        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'disc' => 'nullable|integer',
                'totalPembayaran' => 'required|integer'
            ], $customMessages
        );

        if ($penjualan->totalBayar > $request->totalPembayaran) {
            toastr()->error('Total Pembayaran Kurang!');
            return redirect()->route('penjualan.ordershow', $penjualan->id);
        }

        $penjualan->disc = isset($request->disc) ? ($request->disc / 100) * $request->totalPembayaran : 0;
        $penjualan->totalPembayaran = $request->totalPembayaran;
        $bayar = $penjualan->totalBayar - $penjualan->disc;
        $penjualan->kembalian = $penjualan->totalPembayaran - $bayar;
        $penjualan->save();

        $lastKas = Kas::count() > 0 ? DB::table('kas')->latest()->first()->id : 0;
        $newKas = new Kas();
        $newKas->noKas = (int) $lastKas + 1;
        $newKas->tanggal = $request->tanggal;
        $newKas->detailTransaksi = 'Penjualan dengan No Penjualan: ' . $penjualan->noPenjualan;
        $newKas->tag = 'masuk';
        $newKas->kasMasuk = $penjualan->totalBayar;
        $newKas->save();

        $penjualan->noKas = $newKas->noKas;
        $penjualan->save();

        toastr()->success('Transaksi Berhasil');
        return redirect()->route('penjualan.ordershow', $penjualan->id);
    }

    public function itemDestroy($id, $itemId)
    {
        $penjualan = Penjualan::findOrFail($id);

        $item = ItemPenjualan::findOrFail($itemId);
        $barang = Barang::where('kodeBarang', $item->kodeBarang)->first();
        $barang->qty += $item->qty;
        $barang->save();

        $item->delete();

        toastr()->success('Barang berhasil dihapus');
        return redirect()->route('penjualan.ordershow', $penjualan->id);
    }

    public function printStruk($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $pdf = \PDF::loadView('print_struk', ['penjualan' => $penjualan])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('print-struk-'.$penjualan->noPenjualan.'.pdf');
    }
}
