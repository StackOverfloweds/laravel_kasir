<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranBelanjaTable extends Migration
{
    public function up()
    {
        Schema::create('pengeluaran_belanja', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Bahan
            $table->integer('quantity'); // Jumlah Bahan
            $table->decimal('price', 10, 2); // Harga per Bahan
            $table->date('date'); // Tanggal Belanja
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengeluaran_belanja');
    }
}
