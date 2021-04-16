<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('tanggal')->nullable();
            $table->string('noFaktur')->unique();
            $table->string('kodeSupplier')->nullable();
            $table->foreign('kodeSupplier')
                ->references('kodeSupplier')
                ->on('supplier')
                ->onDelete('set null');
            $table->integer('totalBayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
