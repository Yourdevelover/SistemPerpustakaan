<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('bukus', function (Blueprint $table) {
        $table->id();
        $table->string('isbn')->unique();
        $table->string('judul');
        $table->string('penulis');
        $table->string('penerbit');
        $table->integer('tahun_terbit');
        $table->integer('jumlah_total');
        $table->integer('jumlah_tersedia');
        $table->string('lokasi_rak')->nullable();
        $table->string('cover_path')->nullable();
        $table->foreignId('kategori_id')->constrained('kategori_bukus');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
