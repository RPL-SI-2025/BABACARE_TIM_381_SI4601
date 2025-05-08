<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('visit_history')->nullable();
            $table->text('disease_history')->nullable();
            $table->string('allergy')->nullable();
            $table->string('gender', 10)->nullable()->after('nik');
        });
    }

    public function down()
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'age',
                'birth_date',
                'phone',
                'address',
                'visit_history',
                'disease_history',
                'allergy',
                'gender'
            ]);
        });
    }
}; 