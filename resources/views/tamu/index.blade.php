@extends('layouts.app')

@section('title', 'Data Tamu')
@section('subtitle', 'Kelola data pengunjung dan kunjungan sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header with Buttons -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Data Tamu</h2>
                <p class="text-gray-600 mt-1">Total: <span class="font-semibold">{{ $tamu->count() }} Tamu</span></p>
            </div>
            <button id="bulkDeleteBtn" class="hidden inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-700 transition-all" onclick="confirmBulkDelete()">
                <i class="fas fa-trash mr-2"></i>Hapus <span id="selectedCount" class="ml-1">(0)</span>
            </button>
        </div>
        <a href="{{ route('tamu.create') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Tambah Tamu
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search by Name -->
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama tamu..."
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all">
            </div>

            <!-- Filter by Status -->
            <div class="relative">
                <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select id="statusFilter" class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none appearance-none transition-all">
                    <option value="">Semua Status</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <!-- Filter by Jenis -->
            <div class="relative">
                <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select id="jenisFilter" class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none appearance-none transition-all">
                    <option value="">Semua Jenis</option>
                    @foreach(\App\Models\JenisKunjungan::all() as $jenis)
                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-center">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" onchange="toggleSelectAll(this)">
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Telepon</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jenis</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Guru Tujuan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Kunjungan</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="tableBody">
                    @forelse($tamu as $item)
                        <tr class="hover:bg-gray-50 transition-colors searchable-row" data-status="{{ $item->status_kunjungan }}" data-jenis="{{ $item->id_jenis }}">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" class="row-checkbox w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" value="{{ $item->id_tamu }}" onchange="updateBulkDeleteBtn()">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="https://wa.me/{{ str_replace('+', '', $item->telepon) }}" target="_blank" class="text-primary-600 hover:text-primary-700 font-medium flex items-center space-x-1">
                                    <i class="fas fa-phone text-xs"></i>
                                    <span>{{ $item->telepon }}</span>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($item->status == 'Orang Tua/Wali') bg-blue-100 text-blue-700
                                    @elseif($item->status == 'Siswa') bg-green-100 text-green-700
                                    @elseif($item->status == 'Alumni') bg-purple-100 text-purple-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->jenisKunjungan->nama_jenis ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->guru->nama_guru ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->tanggal_kunjungan->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-600">
                                        <i class="fas fa-arrow-right text-green-500"></i> {{ $item->waktu_masuk }}
                                    </p>
                                    @if($item->waktu_keluar)
                                        <p class="text-xs text-gray-600">
                                            <i class="fas fa-arrow-left text-red-500"></i> {{ $item->waktu_keluar }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="openStatusModal({{ $item->id_tamu }}, '{{ $item->status_kunjungan }}')" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors" title="Update Status">
                                        <i class="fas fa-refresh"></i>
                                    </button>
                                    <a href="{{ route('tamu.edit', $item->id_tamu) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tamu.destroy', $item->id_tamu) }}" method="POST" class="inline-block" onsubmit="return confirmDelete('{{ $item->nama }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                                    <p class="text-lg text-gray-500 font-medium">Tidak ada data tamu</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan tamu baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Empty State untuk Search -->
        <div id="noResults" class="hidden px-6 py-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                <p class="text-lg text-gray-500 font-medium">Tidak ada hasil yang cocok</p>
                <p class="text-sm text-gray-400 mt-1">Coba cari dengan kata kunci atau filter lain</p>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
            <h3 class="text-xl font-bold">Update Status Kunjungan</h3>
        </div>
        <form id="statusForm" action="" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <label for="statusSelect" class="block text-sm font-semibold text-gray-700 mb-3">
                    Pilih Status
                </label>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-primary-500 cursor-pointer transition-all">
                        <input type="radio" name="status_kunjungan" value="proses" class="w-4 h-4 text-blue-600">
                        <span class="ml-3 flex items-center space-x-2">
                            <i class="fas fa-hourglass text-blue-500"></i>
                            <span class="font-medium text-gray-700">Proses</span>
                        </span>
                    </label>
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-primary-500 cursor-pointer transition-all">
                        <input type="radio" name="status_kunjungan" value="selesai" class="w-4 h-4 text-green-600">
                        <span class="ml-3 flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="font-medium text-gray-700">Selesai</span>
                        </span>
                    </label>
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-primary-500 cursor-pointer transition-all">
                        <input type="radio" name="status_kunjungan" value="dibatalkan" class="w-4 h-4 text-red-600">
                        <span class="ml-3 flex items-center space-x-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            <span class="font-medium text-gray-700">Dibatalkan</span>
                        </span>
                    </label>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const jenisFilter = document.getElementById('jenisFilter');
    const tableBody = document.getElementById('tableBody');
    const searchableRows = document.querySelectorAll('.searchable-row');
    const noResults = document.getElementById('noResults');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const jenisValue = jenisFilter.value;
        let visibleCount = 0;

        searchableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status;
            const rowJenis = row.dataset.jenis;

            const matchSearch = text.includes(searchTerm);
            const matchStatus = !statusValue || rowStatus === statusValue;
            const matchJenis = !jenisValue || rowJenis === jenisValue;

            if (matchSearch && matchStatus && matchJenis) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            tableBody.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            tableBody.classList.remove('hidden');
        }
    }

    searchInput.addEventListener('keyup', filterTable);
    statusFilter.addEventListener('change', filterTable);
    jenisFilter.addEventListener('change', filterTable);

    // Status Modal
    function openStatusModal(tamuId, currentStatus) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        form.action = `/tamu/${tamuId}/update-status`;
        form.querySelector(`input[value="${currentStatus}"]`).checked = true;
        modal.classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    // Bulk Delete Functions
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = checkbox.checked;
        });
        updateBulkDeleteBtn();
    }

    function updateBulkDeleteBtn() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkboxes.length;
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCount = document.getElementById('selectedCount');

        if (count > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.classList.add('inline-flex');
            selectedCount.textContent = `(${count})`;
        } else {
            bulkDeleteBtn.classList.add('hidden');
            bulkDeleteBtn.classList.remove('inline-flex');
        }

        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const selectAllCheckbox = document.getElementById('selectAll');
        selectAllCheckbox.checked = allCheckboxes.length > 0 && count === allCheckboxes.length;
    }

    function confirmDelete(nama) {
        return confirm(`Apakah Anda yakin ingin menghapus data tamu "${nama}"?\n\nData yang dihapus tidak dapat dikembalikan!`);
    }

    function confirmBulkDelete() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkboxes.length;

        if (count === 0) {
            alert('Pilih minimal 1 data untuk dihapus');
            return;
        }

        if (!confirm(`Apakah Anda yakin ingin menghapus ${count} data tamu yang dipilih?\n\nData yang dihapus tidak dapat dikembalikan!`)) {
            return;
        }

        // Collect IDs
        const ids = Array.from(checkboxes).map(cb => cb.value);

        // Send AJAX request
        fetch('{{ route("tamu.bulkDelete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus data');
        });
    }

    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
</script>
@endpush
@endsection
