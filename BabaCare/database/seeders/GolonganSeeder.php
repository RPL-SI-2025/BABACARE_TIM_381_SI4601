<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    public function run()
    {
        DB::table('golongans')->insert([
            ['nama_golongan' => 'Keras'],
            ['nama_golongan' => 'Bebas'],
            ['nama_golongan' => 'Bebas Terbatas'],
            ['nama_golongan' => 'Golongan Narkotika'],
            ['nama_golongan' => 'Obat Fitofarmaka'],
            ['nama_golongan' => 'Obat Herbal Terstandar'],
            ['nama_golongan' => 'Obat Herbal (Jamu)'],
            
        ]);
    }
}

