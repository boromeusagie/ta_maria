<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('tanggal')->nullable();
            $table->string('noPenjualan')->unique();
            $table->integer('totalBayar')->nullable();
            $table->float('disc')->nullable();
            $table->integer('totalPembayaran')->nullable();
            $table->integer('kembalian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
