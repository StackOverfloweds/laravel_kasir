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
    Schema::create('purchase_notes', function (Blueprint $table) {
        $table->id();
        $table->date('purchase_date'); // Tanggal belanja
        $table->string('supplier'); // Supplier barang
        $table->decimal('total_amount', 15, 2); // Total biaya belanja
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_notes');
    }
};