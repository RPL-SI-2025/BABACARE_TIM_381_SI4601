<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaStokToObatsTable extends Migration
{
    public function up()
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->nullable();
            $table->integer('stok')->nullable();
        });
    }

    public function down()
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn(['harga', 'stok']);
        });
    }
}