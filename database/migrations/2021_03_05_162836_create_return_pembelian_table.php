<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_pembelian', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('tanggal')->nullable();
            $table->string('noReturn')->unique();
            $table->string('noFaktur')->nullable();
            $table->foreign('noFaktur')
                ->references('noFaktur')
                ->on('pembelian')
                ->onDelete('cascade');
            $table->string('kodeSupplier')->nullable();
            $table->foreign('kodeSupplier')
                ->references('kodeSupplier')
                ->on('supplier')
                ->onDelete('cascade');
            $table->integer('totalReturn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_pembelian');
    }
}
