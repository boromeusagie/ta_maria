<?php

namespace App\Http\Controllers;

use App\Kas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    public function index()
    {
        return view('kas_index');
    }

    public function show(Request $request)
    {
        $request->validate(
            [
                'tanggalKasMasukStart' => 'nullable|date',
                'tanggalKasMasukEnd' => 'nullable|date',
                'tanggalKasKeluarStart' => 'nullable|date',
                'tanggalKasKeluarEnd' => 'nullable|date',
            ]
        );

        $filter = $request->all();

        
        $date = Carbon::today()->format('Y-m-d');
        $tanggalKasMasukStart = $filter['tanggalKasMasukStart'] ?? $date;
        $tanggalKasMasukEnd = $filter['tanggalKasMasukEnd'] ?? $date;
        $tanggalKasKeluarStart = $filter['tanggalKasKeluarStart'] ?? $date;
        $tanggalKasKeluarEnd = $filter['tanggalKasKeluarEnd'] ?? $date;

        if ($tanggalKasMasukStart > $tanggalKasMasukEnd || $tanggalKasKeluarStart > $tanggalKasKeluarEnd) {
            toastr()->error('Tanggal dari harus lebih kecil dari sampai');
            return redirect()->route('kas.index');
        }

        $tagMasuk = '';
        $tagKeluar = '';

        if (isset($filter['tanggalKasMasukStart']) || isset($filter['tanggalKasMasukEnd'])) {
            $tagMasuk = 'masuk';
        }
        if (isset($filter['tanggalKasKeluarStart']) || isset($filter['tanggalKasKeluarEnd'])) {
            $tagKeluar = 'keluar';
        }

        
        $kasMasuk = Kas::where('tag', $tagMasuk)
            ->whereBetween('tanggal', [$tanggalKasMasukStart, $tanggalKasMasukEnd])
            ->get();
            
        $kasKeluar = Kas::where('tag', $tagKeluar)
                ->whereBetween('tanggal', [$tanggalKasKeluarStart, $tanggalKasKeluarEnd])
                ->get();


        $kas = new \Illuminate\Database\Eloquent\Collection;
        $kas = $kas->merge($kasKeluar);
        $kas = $kas->merge($kasMasuk);


        if (!isset($filter['tanggalKasMasukStart'])
            && !isset($filter['tanggalKasMasukEnd'])
            && !isset($filter['tanggalKasKeluarStart'])
            && !isset($filter['tanggalKasKeluarEnd'])) {
            $kas = Kas::all();
        }

        \Log::debug(['kas' => $kasKeluar]);

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
