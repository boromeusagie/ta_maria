<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pembelian', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('noItemPembelian')->unique();
            $table->string('noFaktur')->nullable();
            $table->foreign('noFaktur')
                ->references('noFaktur')
                ->on('pembelian')
                ->onDelete('cascade');
            $table->string('kodeBarang', 6)->nullable();
            $table->foreign('kodeBarang')
                ->references('kodeBarang')
                ->on('barang')
                ->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->integer('totalHarga')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_pembelian');
    }
}
