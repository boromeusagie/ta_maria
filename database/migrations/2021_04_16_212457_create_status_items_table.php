<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('noItemPembelian')->nullable();
            $table->foreign('noItemPembelian')
                ->references('noItemPembelian')
                ->on('item_pembelian')
                ->onDelete('set null');
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
        Schema::dropIfExists('status_items');
    }
}
