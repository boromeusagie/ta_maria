<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(
            "INSERT INTO `supplier` (`kodeSupplier`, `namaSupplier`, `almtSupplier`, `tlpSupplier`) VALUES 
            ('S0001', 'Toko Trijaya','Jl. Pajagalan No.11, Karanganyar, Kec. Astanaanyar, Kota Bandung, Jawa Barat 40241','(022) 4240070'),
            ('S0002', 'Toko Asta','Pusat Perdagangan Caringin, Jl. Soekarno-Hatta, Babakan Ciparay, Kec. Babakan Ciparay, Bandung, Jawa','085721965322'),
            ('S0003', 'Toko An-Nur','Jl. Otto Iskandar Dinata No.519, Ciateul, Kec. Regol, Kota Bandung, Jawa Barat 40231','(022) 5200901')"
        );
    }
}
