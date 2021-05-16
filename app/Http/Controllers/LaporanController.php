<?php

namespace App\Http\Controllers;

use PDF;
use App\Barang;
use App\ItemPenjualan;
use App\Pembelian;
use App\ReturnPembelian;
use App\Penjualan;
use App\Kas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan');
    }

    public function cetakPdf(Request $request)
    {
        $models = [
            'barang' => Barang::class,
            'pembelian' => Pembelian::class,
            'return-pembelian' => ReturnPembelian::class,
            'penjualan' => Penjualan::class,
            'kas' => Kas::class
        ];

        $laporan = $request->namaLaporan;
        $date = Carbon::today()->format('Y-m-d');

        $dari = $request->dari ?? $date;
        $sampai = $request->sampai?? $date;

        if ($request->dari || $request->sampai) {
            $query = $models[$laporan]::whereBetween('tanggal', [$dari, $sampai])->get();
        } else {
            $query = $models[$laporan]::all();
        }

        if ($laporan === 'barang') {
            $pdf = \PDF::loadView('cetak_persediaan_barang', ['query' => $query])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-persediaan-barang-'.$date.'.pdf');
        } elseif ($laporan === 'kas') {
            $totalDebit = $query->sum('kasKeluar') ?? 0;
            $totalKredit = $query->sum('kasMasuk') ?? 0;

            if ($totalDebit > 0 && $totalKredit === 0) {
                $presentase = 100;
            } elseif ($totalKredit > 0 && $totalDebit === 0) {
                $presentase = -100;
            } elseif ($totalDebit === 0 && $totalKredit === 0) {
                $presentase = 0;
            } else {
                $presentase = ($totalKredit - $totalDebit) / $totalDebit * 100;
            }
            $pdf = \PDF::loadView('cetak_'.$laporan, [
                'query' => $query,
                'dari' => $dari,
                'sampai' => $sampai,
                'totalKredit' => $totalKredit,
                'totalDebit' => $totalDebit,
                'presentase' => $presentase,
                ])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-'.$laporan.'-'.$date.'.pdf');
        } else {
            $pdf = \PDF::loadView('cetak_'.$laporan, ['query' => $query, 'dari' => $dari, 'sampai' => $sampai])->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('laporan-'.$laporan.'-'.$date.'.pdf');
        }
    }
}
