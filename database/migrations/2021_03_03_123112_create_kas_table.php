<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('tanggal')->nullable();
            $table->string('noKas')->unique();
            $table->string('detailTransaksi')->nullable();
            $table->string('tag')->nullable();
            $table->integer('kasMasuk')->nullable();
            $table->integer('kasKeluar')->nullable();
            $table->integer('totalSaldo')->nullable();
            $table->float('persentaseKeuntungan')->nullable();
            $table->integer('totalLabaRugi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kas');
    }
}
