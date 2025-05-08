<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Patient::select('nama_pasien', 'nik', 'gender', 'penyakit', 'waktu_periksa')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pasien',
            'NIK',
            'Gender',
            'Penyakit',
            'Waktu Periksa',
        ];
    }
} 