<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            
            // Patient Information
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            
            // Referral Specific Fields
            $table->string('kode_rujukan')->unique();
            $table->unsignedBigInteger('origin_hospital_id');
            $table->unsignedBigInteger('destination_hospital_id');
            
            // Medical Information
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('pengobatan_sementara')->nullable();
            $table->text('keadaan_saat_rujuk')->nullable(); 
            
            // Staff Information
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('penggunas');
            
            // Additional Metadata
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->text('address')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
    }
};