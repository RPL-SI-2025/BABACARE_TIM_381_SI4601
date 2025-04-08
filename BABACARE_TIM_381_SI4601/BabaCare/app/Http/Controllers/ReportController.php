<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Data untuk diagram tren penyakit
        $penyakitStats = Patient::select('penyakit', DB::raw('count(*) as total'))
            ->groupBy('penyakit')
            ->get();

        // Data untuk tren penyakit per bulan
        $monthlyStats = Patient::select(
            DB::raw('MONTH(waktu_periksa) as month'),
            DB::raw('YEAR(waktu_periksa) as year'),
            'penyakit',
            DB::raw('count(*) as total')
        )
            ->whereYear('waktu_periksa', date('Y'))
            ->groupBy('year', 'month', 'penyakit')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Data untuk statistik jenis perawatan
        $perawatanStats = Patient::select('jenis_perawatan', DB::raw('count(*) as total'))
            ->groupBy('jenis_perawatan')
            ->get();

        // Data untuk statistik gender
        $genderStats = Patient::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();

        return view('reports.index', compact(
            'penyakitStats',
            'monthlyStats',
            'perawatanStats',
            'genderStats'
        ));
    }
} 