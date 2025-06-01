<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Obat Cair'],
            ['nama_kategori' => 'Kapsul'],
            ['nama_kategori' => 'Tablet'],
            ['nama_kategori' => 'Serbuk'],
            ['nama_kategori' => 'Salep'],
            ['nama_kategori' => 'Pasta'],
            ['nama_kategori' => 'Krim'],
            ['nama_kategori' => 'Larutan'],
            ['nama_kategori' => 'Suspensi'],
            ['nama_kategori' => 'Emulsi'],
            ['nama_kategori' => 'Obat Tetes'],
            
                      
            
        ]);
    }
}

