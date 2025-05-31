<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('pembelians')) {
            Schema::create('pembelians', function (Blueprint $table) {
                $table->id();
                $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
                $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
                $table->integer('jumlah');
                $table->date('tanggal');
                $table->enum('status', ['pending', 'completed'])->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
};