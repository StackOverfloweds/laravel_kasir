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
    Schema::create('sales_reports', function (Blueprint $table) {
        $table->id();
        $table->date('report_date'); // Tanggal laporan penjualan
        $table->decimal('total_sales', 15, 2); // Total penjualan
        $table->decimal('total_revenue', 15, 2); // Total pendapatan
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_reports');
    }
};