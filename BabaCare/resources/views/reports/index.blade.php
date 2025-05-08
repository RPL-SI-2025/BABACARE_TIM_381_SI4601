@extends('layouts.app')

@section('title', 'Laporan Data Pasien')
@section('header', 'Laporan Data Pasien')

@section('content')
<div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-lg shadow-md p-6 flex items-center">
        <i class="fas fa-users text-3xl mr-4"></i>
        <div>
            <div class="text-lg font-semibold">Total Pasien</div>
            <div class="text-2xl font-bold">{{ $totalPatients ?? 0 }}</div>
        </div>
    </div>
    <div class="bg-gradient-to-r from-pink-400 to-red-500 text-white rounded-lg shadow-md p-6 flex items-center">
        <i class="fas fa-user-plus text-3xl mr-4"></i>
        <div>
            <div class="text-lg font-semibold">Pasien Baru Bulan Ini</div>
            <div class="text-2xl font-bold">{{ $newPatientsThisMonth ?? 0 }}</div>
        </div>
    </div>
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-lg shadow-md p-6 flex items-center">
        <i class="fas fa-virus text-3xl mr-4"></i>
        <div>
            <div class="text-lg font-semibold">Penyakit Terbanyak</div>
            <div class="text-2xl font-bold">{{ $topDiseaseName ?? '-' }}</div>
        </div>
    </div>
</div>
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
    <form method="GET" class="flex items-center gap-2">
        <label for="filterYear" class="mr-2 font-medium text-gray-700">Tahun:</label>
        <select id="filterYear" name="year" class="rounded border-gray-300 focus:ring focus:ring-blue-200">
            @for ($y = date('Y'); $y >= 2020; $y--)
                <option value="{{ $y }}" @if(request('year', date('Y')) == $y) selected @endif>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="ml-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Terapkan</button>
    </form>
    <div class="flex gap-2 mt-2 md:mt-0">
        <a href="{{ route('reports.export', ['year' => request('year', date('Y'))]) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition"><i class="fas fa-file-excel mr-1"></i>Export Excel</a>
        <a href="{{ route('reports.exportPdf', ['year' => request('year', date('Y'))]) }}" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"><i class="fas fa-file-pdf mr-1"></i>Export PDF</a>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Diagram Tren Penyakit -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Penyakit</h3>
        <canvas id="penyakitChart"></canvas>
    </div>

    <!-- Diagram Jenis Perawatan -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Jenis Perawatan</h3>
        <canvas id="perawatanChart"></canvas>
    </div>

    <!-- Diagram Gender -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Gender Pasien</h3>
        <canvas id="genderChart"></canvas>
    </div>

    <!-- Tren Bulanan -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Penyakit Bulanan ({{ date('Y') }})</h3>
        <canvas id="monthlyChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gradien untuk chart
    function createGradient(ctx, colorFrom, colorTo) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colorFrom);
        gradient.addColorStop(1, colorTo);
        return gradient;
    }

    // Data untuk Diagram Tren Penyakit
    const penyakitCtx = document.getElementById('penyakitChart').getContext('2d');
    const penyakitGradient = createGradient(penyakitCtx, '#38bdf8', '#6366f1'); // biru ke ungu
    new Chart(penyakitCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($penyakitStats->pluck('penyakit')) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! json_encode($penyakitStats->pluck('total')) !!},
                backgroundColor: penyakitGradient,
                borderColor: '#2563eb',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Data untuk Diagram Jenis Perawatan
    const perawatanCtx = document.getElementById('perawatanChart').getContext('2d');
    const perawatanGradient1 = createGradient(perawatanCtx, '#f472b6', '#f87171'); // pink ke merah
    const perawatanGradient2 = createGradient(perawatanCtx, '#38bdf8', '#6366f1'); // biru ke ungu
    new Chart(perawatanCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($perawatanStats->pluck('jenis_perawatan')) !!},
            datasets: [{
                data: {!! json_encode($perawatanStats->pluck('total')) !!},
                backgroundColor: [perawatanGradient1, perawatanGradient2],
                borderColor: ['#f43f5e', '#2563eb'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Data untuk Diagram Gender
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const genderGradient1 = createGradient(genderCtx, '#38bdf8', '#6366f1'); // biru ke ungu
    const genderGradient2 = createGradient(genderCtx, '#f472b6', '#f87171'); // pink ke merah
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($genderStats->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($genderStats->pluck('total')) !!},
                backgroundColor: [genderGradient1, genderGradient2],
                borderColor: ['#2563eb', '#f43f5e'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Data untuk Tren Bulanan
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const monthlyData = {!! json_encode($monthlyStats) !!};
    const datasets = {};
    monthlyData.forEach(item => {
        if (!datasets[item.penyakit]) {
            datasets[item.penyakit] = Array(12).fill(0);
        }
        datasets[item.penyakit][item.month - 1] = item.total;
    });
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    // Gradien dinamis untuk setiap penyakit
    const lineColors = [
        createGradient(monthlyCtx, '#38bdf8', '#6366f1'),
        createGradient(monthlyCtx, '#f472b6', '#f87171'),
        createGradient(monthlyCtx, '#facc15', '#f59e42'),
    ];
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthNames,
            datasets: Object.keys(datasets).map((penyakit, index) => ({
                label: penyakit,
                data: datasets[penyakit],
                borderColor: lineColors[index % lineColors.length],
                backgroundColor: lineColors[index % lineColors.length],
                fill: false,
                tension: 0.1
            }))
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush 