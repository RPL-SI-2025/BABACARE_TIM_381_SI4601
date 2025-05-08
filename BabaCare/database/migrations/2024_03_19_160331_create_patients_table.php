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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nik')->unique();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->text('address');
            $table->text('allergy')->nullable();
            $table->date('tanggal_reservasi');
            $table->date('tanggal_pelaksanaan');
            $table->text('keluhan');
            $table->string('jenis_perawatan');
            $table->dateTime('waktu_periksa');
            $table->string('penyakit');
            $table->foreignId('obat_id')->constrained('obats');
            $table->text('hasil_pemeriksaan');
            $table->foreignId('pengguna_id')->constrained('penggunas');
            $table->foreignId('appointment_id')->constrained('appointments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
