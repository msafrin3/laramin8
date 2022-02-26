<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKempenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kempens', function (Blueprint $table) {
            $table->id();
            $table->integer('stateid')->default(0);
            $table->integer('parid')->default(0);
            $table->integer('dunid')->default(0);
            $table->integer('dmid')->default(0);
            $table->string('name');
            $table->integer('type_mtdt_id');
            $table->string('location')->nullable();
            $table->date('date');
            $table->string('time');
            $table->string('penganjur')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('sasaran_mtdt_id');
            $table->string('vips')->nullable();
            $table->integer('anggaran_peserta')->default(0);
            $table->integer('kategori_mtdt_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kempens');
    }
}
