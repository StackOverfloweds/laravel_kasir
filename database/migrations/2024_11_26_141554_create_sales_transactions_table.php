<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sales_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // Pengguna yang melakukan transaksi
        $table->foreignId('menu_id')->constrained('menus'); // Menu yang dibeli
        $table->integer('quantity'); // Jumlah menu yang dibeli
        $table->decimal('total_amount', 15, 2); // Total transaksi
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};