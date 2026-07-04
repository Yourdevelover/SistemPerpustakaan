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
    Schema::create('anggotas', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_anggota')->unique();
        $table->string('jenis_anggota');
        $table->string('kelas')->nullable();
        $table->string('alamat')->nullable();
        $table->string('telepon')->nullable();
        $table->date('tanggal_daftar');
        $table->string('status')->default('aktif');
        $table->foreignId('user_id')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
