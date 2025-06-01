<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rumah_sakit');
            $table->string('kode_rumah_sakit')->unique();
            $table->string('nama_staff')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->enum('tipe', [
                'Pemerintah', 
                'Swasta', 
                'Khusus', 
                'Akademik', 
                'Lainnya'
            ])->default('Swasta');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_rujukan')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hospitals');
    }
};