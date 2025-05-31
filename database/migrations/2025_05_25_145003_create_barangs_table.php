<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('gambar')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->decimal('harga', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};