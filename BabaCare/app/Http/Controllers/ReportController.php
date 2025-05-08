<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // Data untuk diagram tren penyakit
        $penyakitStats = Patient::select('penyakit', DB::raw('count(*) as total'))
            ->whereYear('waktu_periksa', $year)
            ->groupBy('penyakit')
            ->get();

        // Data untuk tren penyakit per bulan
        $monthlyStats = Patient::select(
            DB::raw('MONTH(waktu_periksa) as month'),
            DB::raw('YEAR(waktu_periksa) as year'),
            'penyakit',
            DB::raw('count(*) as total')
        )
            ->whereYear('waktu_periksa', $year)
            ->groupBy('year', 'month', 'penyakit')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Data untuk statistik jenis perawatan
        $perawatanStats = Patient::select('jenis_perawatan', DB::raw('count(*) as total'))
            ->whereYear('waktu_periksa', $year)
            ->groupBy('jenis_perawatan')
            ->get();

        // Data untuk statistik gender
        $genderStats = Patient::select('gender', DB::raw('count(*) as total'))
            ->whereYear('waktu_periksa', $year)
            ->groupBy('gender')
            ->get();

        // Summary Card
        $totalPatients = Patient::whereYear('waktu_periksa', $year)->count();
        $newPatientsThisMonth = Patient::whereYear('waktu_periksa', $year)
            ->whereMonth('waktu_periksa', date('m'))
            ->count();
        $topDisease = $penyakitStats
            ->filter(fn($item) => $item->penyakit && $item->penyakit !== '-')
            ->sortByDesc('total')
            ->first();
        $topDiseaseName = $topDisease ? $topDisease->penyakit : '-';

        return view('reports.index', compact(
            'penyakitStats',
            'monthlyStats',
            'perawatanStats',
            'genderStats',
            'totalPatients',
            'newPatientsThisMonth',
            'topDiseaseName',
            'year'
        ));
    }

    public function export(Request $request)
    {
        $fileName = 'laporan_pasien_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new PatientsExport, $fileName);
    }

    public function exportPdf(Request $request)
    {
        $patients = \App\Models\Patient::select('nama_pasien', 'nik', 'gender', 'penyakit', 'jenis_perawatan', 'waktu_periksa')->get();
        $pdf = PDF::loadView('reports.patient_pdf', compact('patients'));
        $fileName = 'laporan_pasien_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
} 