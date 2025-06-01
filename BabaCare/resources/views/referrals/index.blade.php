@extends('layouts.app')

@section('title', 'Surat Dokter')
@section('header', 'Surat Dokter')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="flex space-x-4 items-center">
            <select id="category" class="form-select rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="rujukan" {{ request('category', 'rujukan') == 'rujukan' ? 'selected' : '' }}>Rujukan</option>
                <option value="resep" {{ request('category') == 'resep' ? 'selected' : '' }}>Resep Obat</option>
            </select>

            @if(request('category', 'rujukan') == 'rujukan')
                <a href="{{ route('referrals.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i> Tambah Rujukan
                </a>
            @else
                <a href="{{ route('prescriptions.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i> Tambah Resep
                </a>
            @endif
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative">
                @if(request('category', 'rujukan') == 'rujukan')
                    <input type="text" id="searchInput" placeholder="Cari ID Pasien, Kode Rujukan, atau Nama Pasien..." 
                           class="pl-10 pr-4 py-2 w-80 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @else
                    <input type="text" id="searchInput" placeholder="Cari ID Pasien, Kode Resep, atau Nama Pasien..." 
                           class="pl-10 pr-4 py-2 w-80 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @endif
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <button id="clearSearch" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" 
                        data-sort="patient_id">
                        ID Pasien
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" 
                        data-sort="{{ request('category', 'rujukan') == 'rujukan' ? 'referral_code' : 'prescription_code' }}">
                        @if(request('category', 'rujukan') == 'rujukan')
                            Kode Rujukan
                        @else
                            Kode Resep
                        @endif
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" 
                        data-sort="nama_pasien">
                        Nama Pasien
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" 
                        data-sort="tanggal_surat">
                        @if(request('category', 'rujukan') == 'rujukan')
                            Tanggal Surat
                        @else
                            Tanggal Resep
                        @endif
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="referralTableBody" class="bg-white divide-y divide-gray-200">
                @if(request('category', 'rujukan') == 'rujukan')
                    @forelse($referrals as $referral)
                    <tr class="referral-row" 
                        data-patient-id="{{ $referral->patient_id }}" 
                        data-kode-rujukan="{{ strtolower($referral->referral_code) }}" 
                        data-nama-pasien="{{ strtolower($referral->patient->nama_pasien ?? '') }}"
                        data-tanggal-surat="{{ $referral->created_at->format('Y-m-d') }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $referral->patient_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $referral->referral_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $referral->patient->nama_pasien ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $referral->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a dusk="download-button-{{ $referral->id }}" href="{{ route('referrals.download', $referral) }}" class="text-blue-600 hover:text-blue-900" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('referrals.edit', $referral) }}" class="text-green-600 hover:text-green-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('referrals.destroy', $referral) }}" method="POST" class="inline" id="delete-form-{{ $referral->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" dusk="delete-button-{{ $referral->id }}"
                                            onclick="confirmDelete(this, '{{ $referral->referral_code }}')" 
                                            class="text-red-600 hover:text-red-900" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data rujukan
                        </td>
                    </tr>
                    @endforelse
                @else
                    @forelse($prescriptions as $prescription)
                    <tr class="referral-row" 
                        data-patient-id="{{ $prescription->patient_id }}" 
                        data-kode-rujukan="{{ strtolower($prescription->prescription_code) }}" 
                        data-nama-pasien="{{ strtolower($prescription->patient->nama_pasien ?? '') }}"
                        data-tanggal-surat="{{ $prescription->created_at->format('Y-m-d') }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $prescription->patient_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $prescription->prescription_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $prescription->patient->nama_pasien ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $prescription->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('prescriptions.download', $prescription) }}" dusk="download-button-{{ $prescription->id }}" class="text-blue-600 hover:text-blue-900" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('prescriptions.edit', $prescription) }}" class="text-green-600 hover:text-green-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline" id="delete-form-{{ $prescription->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" dusk="delete-button-{{ $prescription->id }}"
                                            onclick="confirmDelete(this, '{{ $prescription->prescription_code }}')" 
                                            class="text-red-600 hover:text-red-900" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data resep obat
                        </td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>

    <div id="paginationContainer" class="mt-4">
        @if(request('category', 'rujukan') == 'rujukan')
            {{ $referrals->appends(request()->query())->links() }}
        @else
            {{ $prescriptions->appends(request()->query())->links() }}
        @endif
    </div>

    <!-- Search results info -->
    <div id="searchInfo" class="hidden mt-2 text-sm text-gray-600">
        <span id="searchResults"></span>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allRows = [];
    let currentSort = { field: null, direction: 'asc' };
    let currentCategory = '{{ request("category", "rujukan") }}';
    
    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Store all rows data for searching
        allRows = Array.from(document.querySelectorAll('.referral-row'));
        
        // Initialize search functionality
        initializeSearch();
        
        // Initialize sorting functionality
        initializeSorting();
    });

    function initializeSearch() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearSearch');
        const searchInfo = document.getElementById('searchInfo');
        const searchResults = document.getElementById('searchResults');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            
            if (searchTerm.length > 0) {
                clearButton.classList.remove('hidden');
                performClientSearch(searchTerm);
            } else {
                clearButton.classList.add('hidden');
                showAllRows();
                hideSearchInfo();
            }
        });
        
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            clearButton.classList.add('hidden');
            showAllRows();
            hideSearchInfo();
            searchInput.focus();
        });
        
        function performClientSearch(searchTerm) {
            let visibleCount = 0;
            
            allRows.forEach(row => {
                const patientId = row.getAttribute('data-patient-id').toLowerCase();
                const kodeRujukan = row.getAttribute('data-kode-rujukan');
                const namaPasien = row.getAttribute('data-nama-pasien');
                
                const isMatch = patientId.includes(searchTerm) || 
                               kodeRujukan.includes(searchTerm) || 
                               namaPasien.includes(searchTerm);
                
                if (isMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show/hide no data message
            const noDataRow = document.getElementById('noDataRow');
            if (visibleCount === 0) {
                if (!noDataRow) {
                    const tbody = document.getElementById('referralTableBody');
                    const newNoDataRow = document.createElement('tr');
                    newNoDataRow.id = 'noDataRowSearch';
                    const dataType = currentCategory === 'rujukan' ? 'rujukan' : 'resep obat';
                    newNoDataRow.innerHTML = `
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data ${dataType} yang ditemukan untuk pencarian "${searchTerm}"
                        </td>
                    `;
                    tbody.appendChild(newNoDataRow);
                }
            } else {
                const searchNoDataRow = document.getElementById('noDataRowSearch');
                if (searchNoDataRow) {
                    searchNoDataRow.remove();
                }
            }
            
            // Show search results info
            showSearchInfo(visibleCount, searchTerm);
        }
        
        function showAllRows() {
            allRows.forEach(row => {
                row.style.display = '';
            });
            
            // Remove search no data row if exists
            const searchNoDataRow = document.getElementById('noDataRowSearch');
            if (searchNoDataRow) {
                searchNoDataRow.remove();
            }
        }
        
        function showSearchInfo(count, searchTerm) {
            searchResults.textContent = `Ditemukan ${count} hasil untuk pencarian "${searchTerm}"`;
            searchInfo.classList.remove('hidden');
        }
        
        function hideSearchInfo() {
            searchInfo.classList.add('hidden');
        }
    }

    function initializeSorting() {
        const sortHeaders = document.querySelectorAll('th[data-sort]');
        
        sortHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const sortField = this.getAttribute('data-sort');
                
                // Toggle direction or set to asc if different field
                if (currentSort.field === sortField) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.field = sortField;
                    currentSort.direction = 'asc';
                }
                
                sortTable(sortField, currentSort.direction);
                updateSortIcons(sortField, currentSort.direction);
            });
        });
    }

    function sortTable(field, direction) {
        const tbody = document.getElementById('referralTableBody');
        const visibleRows = allRows.filter(row => row.style.display !== 'none');
        
        visibleRows.sort((a, b) => {
            let aValue, bValue;
            
            switch(field) {
                case 'patient_id':
                    aValue = parseInt(a.getAttribute('data-patient-id'));
                    bValue = parseInt(b.getAttribute('data-patient-id'));
                    break;
                case 'referral_code':
                case 'prescription_code':
                    aValue = a.getAttribute('data-kode-rujukan');
                    bValue = b.getAttribute('data-kode-rujukan');
                    break;
                case 'nama_pasien':
                    aValue = a.getAttribute('data-nama-pasien');
                    bValue = b.getAttribute('data-nama-pasien');
                    break;
                case 'tanggal_surat':
                    aValue = new Date(a.getAttribute('data-tanggal-surat'));
                    bValue = new Date(b.getAttribute('data-tanggal-surat'));
                    break;
                default:
                    return 0;
            }
            
            if (direction === 'asc') {
                return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
            } else {
                return aValue > bValue ? -1 : aValue < bValue ? 1 : 0;
            }
        });
        
        // Clear tbody and re-append sorted rows
        const allChildren = Array.from(tbody.children);
        allChildren.forEach(child => {
            if (!child.classList.contains('referral-row')) {
                // Keep non-data rows (like no-data messages)
                return;
            }
        });
        
        // Remove all referral rows
        document.querySelectorAll('.referral-row').forEach(row => row.remove());
        
        // Add sorted rows back
        visibleRows.forEach(row => tbody.appendChild(row));
        
        // Add back any non-referral rows
        const noDataRows = allChildren.filter(child => !child.classList.contains('referral-row'));
        noDataRows.forEach(row => tbody.appendChild(row));
    }

    function updateSortIcons(activeField, direction) {
        // Reset all icons
        document.querySelectorAll('th[data-sort] i').forEach(icon => {
            icon.className = 'fas fa-sort ml-1 text-gray-300';
        });
        
        // Update active field icon
        const activeHeader = document.querySelector(`th[data-sort="${activeField}"] i`);
        if (activeHeader) {
            activeHeader.className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'} ml-1`;
        }
    }

    // Category dropdown change handler
    document.getElementById('category').addEventListener('change', function() {
        window.location.href = "{{ route('referrals.index') }}?category=" + this.value;
    });

    // Fixed delete confirmation function
    function confirmDelete(button, code) {
        const itemType = currentCategory === 'rujukan' ? 'rujukan' : 'resep obat';
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: `Apakah Anda yakin ingin menghapus ${itemType} dengan kode ${code}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form that contains this button
                button.closest('form').submit();
            }
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
@endpush