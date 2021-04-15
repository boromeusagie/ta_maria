<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('kodeBarang', 6)->unique();
            $table->string('namaBarang')->nullable();
            $table->integer('qty')->default(0);
            $table->string('satuan')->nullable();
            $table->integer('hargaBeli')->nullable();
            $table->integer('hargaJual')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
