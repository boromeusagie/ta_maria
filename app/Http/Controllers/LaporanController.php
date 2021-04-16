<?php

namespace App\Http\Controllers;

use PDF;
use App\Barang;
use App\Pembelian;
use App\ReturnPembelian;
use App\Penjualan;
use App\Kas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan');
    }

    public function cetakPdf(Request $request)
    {
        $laporan = $request->namaLaporan;
        $date = date('d-m-y', strtotime(now()));

        if ($laporan === 'barang') {
            $barangs = Barang::all();
            $pdf = \PDF::loadView('cetak_persediaan_barang', ['barangs' => $barangs])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-persediaan-barang-'.$date.'.pdf');
        }
        else if ($laporan === 'pembelian') {
            $pembelian = Pembelian::all();
            $pdf = \PDF::loadView('cetak_pembelian', ['pembelian' => $pembelian])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-pembelian-'.$date.'.pdf');
        }
        else if ($laporan === 'returnPembelian') {
            $returnPembelian = ReturnPembelian::all();
            $pdf = \PDF::loadView('cetak_returnPembelian', ['returnPembelian' => $returnPembelian])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-returnPembelian-'.$date.'.pdf');
        }
        else if ($laporan === 'penjualan') {
            $penjualan = Penjualan::all();
            $pdf = \PDF::loadView('cetak_penjualan', ['penjualan' => $penjualan])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-penjualan-'.$date.'.pdf');
        }
        else if ($laporan === 'kas') {
            $kas = Kas::all();
            $pdf = \PDF::loadView('cetak_Kas', ['kas' => $kas])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-kas-'.$date.'.pdf');
        }
    }
}
