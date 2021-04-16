<?php

namespace App\Http\Controllers;

use PDF;
use App\Barang;
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
    }
}
