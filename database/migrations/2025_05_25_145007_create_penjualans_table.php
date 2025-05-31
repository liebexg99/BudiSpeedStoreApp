<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('penjualans')) {
            Schema::create('penjualans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pembeli_id')->constrained('pembelis')->onDelete('cascade');
                $table->foreignId('kasir_id')->constrained('users')->onDelete('cascade');
                $table->date('tanggal_pesan');
                $table->decimal('total', 15, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};