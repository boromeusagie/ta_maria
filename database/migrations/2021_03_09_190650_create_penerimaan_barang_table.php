<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('noItemPembelian')->nullable();
            $table->foreign('noItemPembelian')
                ->references('noItemPembelian')
                ->on('item_pembelian')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_barang');
    }
}
