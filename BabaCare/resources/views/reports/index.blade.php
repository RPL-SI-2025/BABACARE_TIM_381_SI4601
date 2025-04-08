@extends('layouts.app')

@section('title', 'Laporan Data Pasien')
@section('header', 'Laporan Data Pasien')

@section('content')
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
    // Data untuk Diagram Tren Penyakit
    const penyakitCtx = document.getElementById('penyakitChart').getContext('2d');
    new Chart(penyakitCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($penyakitStats->pluck('penyakit')) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! json_encode($penyakitStats->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    new Chart(perawatanCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($perawatanStats->pluck('jenis_perawatan')) !!},
            datasets: [{
                data: {!! json_encode($perawatanStats->pluck('total')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Data untuk Diagram Gender
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($genderStats->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($genderStats->pluck('total')) !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
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
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthNames,
            datasets: Object.keys(datasets).map((penyakit, index) => ({
                label: penyakit,
                data: datasets[penyakit],
                borderColor: `hsl(${index * 360 / Object.keys(datasets).length}, 70%, 50%)`,
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