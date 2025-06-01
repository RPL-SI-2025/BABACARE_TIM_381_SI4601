@extends('layouts.Admin')

@section('title', 'Feedback Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Feedback Dashboard</h1>
        <p class="text-gray-600">Analisis dan visualisasi data feedback dari pengguna</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Total Feedback</h2>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalFeedback }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-smile text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Feedback Puas</h2>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ $satisfactionStats->where('satisfaction', 'puas')->first()->total ?? 0 }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500">
                    <i class="fas fa-frown text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Feedback Tidak Puas</h2>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ $satisfactionStats->where('satisfaction', 'tidak_puas')->first()->total ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Table -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Pie Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Kepuasan</h3>
            <canvas id="satisfactionPieChart" height="300"></canvas>
        </div>

        <!-- Feedback Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Feedback</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-blue-50 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Nama Pasien</th>
                            <th class="px-6 py-3 bg-blue-50 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 bg-blue-50 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Kepuasan</th>
                            <th class="px-6 py-3 bg-blue-50 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Saran/Kritik</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-200">
                        @foreach($feedbackList as $feedback)
                        <tr class="hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900">{{ $feedback->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $feedback->satisfaction === 'puas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $feedback->satisfaction === 'puas' ? 'Puas' : 'Tidak Puas' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-blue-600">{{ $feedback->comment }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $feedbackList->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart
    const satisfactionCtx = document.getElementById('satisfactionPieChart').getContext('2d');
    new Chart(satisfactionCtx, {
        type: 'pie',
        data: {
            labels: ['Puas', 'Tidak Puas'],
            datasets: [{
                data: [
                    {{ $satisfactionStats->where('satisfaction', 'puas')->first()->total ?? 0 }},
                    {{ $satisfactionStats->where('satisfaction', 'tidak_puas')->first()->total ?? 0 }}
                ],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection 