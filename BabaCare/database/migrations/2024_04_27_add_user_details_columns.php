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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('whatsapp_number')->after('email')->nullable();
            $table->integer('age')->after('whatsapp_number')->nullable();
            $table->date('date_of_birth')->after('age')->nullable();
            $table->text('address')->after('date_of_birth')->nullable();
            $table->text('allergies')->after('address')->nullable();
            $table->text('visit_history')->after('allergies')->nullable();
            $table->text('medical_history')->after('visit_history')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'whatsapp_number',
                'age',
                'date_of_birth',
                'address',
                'allergies',
                'visit_history',
                'medical_history'
            ]);
        });
    }
}; 