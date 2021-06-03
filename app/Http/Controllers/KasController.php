<?php

namespace App\Http\Controllers;

use App\Kas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('kas_index', ['user' => $user]);
    }

    public function show(Request $request)
    {
        $request->validate(
            [
                'tanggal' => 'nullable|date'
            ]
        );
        $user = Auth::user();

        $filter = $request->all();

        
        $date = Carbon::today()->format('Y-m-d');
        $tanggal = $filter['tanggal'] ?? $date;


        $kas = Kas::where('tanggal', $tanggal)->get();

        if (!isset($filter['tanggal'])) {
            $kas = Kas::all();
        }

        $totalDebit = $kas->sum('kasKeluar') ?? 0;
        $totalKredit = $kas->sum('kasMasuk') ?? 0;

        if ($totalDebit > 0 && $totalKredit === 0) {
            $presentase = 100;
        } elseif ($totalKredit > 0 && $totalDebit === 0) {
            $presentase = -100;
        } elseif ($totalDebit === 0 && $totalKredit === 0) {
            $presentase = 0;
        } else {
            $presentase = ($totalKredit - $totalDebit) / $totalDebit * 100;
        }

        return view('kas_show', [
            'user' => $user,
            'kas' => $kas,
            'totalKredit' => $totalKredit,
            'totalDebit' => $totalDebit,
            'presentase' => $presentase,
            'tanggalKasMasukStart' => $filter['tanggalKasMasukStart'] ?? null,
            'tanggalKasMasukEnd' => $filter['tanggalKasMasukEnd'] ?? null,
            'tanggalKasKeluarStart' => $filter['tanggalKasKeluarStart'] ?? null,
            'tanggalKasKeluarEnd' => $filter['tanggalKasKeluarEnd'] ?? null,
        ]);
    }

    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'Harap isi :attribute',
            'unique' => ':attribute sudah digunakan'
        ];

        $request->validate(
            [
                'tanggal' => 'required|date',
                'jenisTransaksi' => 'required|string',
                'detailTransaksi' => 'required|string',
                'totalSaldo' => 'required|integer'
            ], $customMessages
        );

        $lastKas = Kas::count() > 0 ? DB::table('kas')->latest()->first()->id : 0;
        if ($request->jenisTransaksi === 'kasMasuk') {
            $newKas = new Kas();
            $newKas->noKas = (int) $lastKas + 1;
            $newKas->tanggal = $request->tanggal;
            $newKas->detailTransaksi = $request->detailTransaksi;
            $newKas->tag = 'masuk';
            $newKas->kasMasuk = $request->totalSaldo;
            $newKas->save();
        } else {
            $newKas = new Kas();
            $newKas->noKas = (int) $lastKas + 1;
            $newKas->tanggal = $request->tanggal;
            $newKas->detailTransaksi = $request->detailTransaksi;
            $newKas->tag = 'keluar';
            $newKas->kasKeluar = $request->totalSaldo;
            $newKas->save();
        }

        toastr()->success('Transaksi berhasil ditambahkan');
        return redirect()->route('kas.index');
    }
}
