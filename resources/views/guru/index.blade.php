@extends('layouts.app')

@section('title', 'Data Guru')
@section('subtitle', 'Kelola data guru dan staff sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header with Button -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Data Guru</h2>
            <p class="text-gray-600 mt-1">Total: <span class="font-semibold">{{ $guru->count() }} Guru</span></p>
        </div>
        <a href="{{ route('guru.create') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Tambah Guru
        </a>
    </div>

    <!-- Card dengan Search dan Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Search Bar -->
        <div class="p-6 border-b border-gray-200">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama guru atau NIP..."
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIP</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Guru</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="tableBody">
                    @forelse($guru as $item)
                        <tr class="hover:bg-gray-50 transition-colors group searchable-row">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-sm font-medium">
                                    {{ $item->nip }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($item->nama_guru, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->nama_guru }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('guru.edit', $item->id_guru) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors group/edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="checkAndDelete({{ $item->id_guru }}, '{{ $item->nama_guru }}')" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                                    <p class="text-lg text-gray-500 font-medium">Tidak ada data guru</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan guru baru</p>
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
                <p class="text-sm text-gray-400 mt-1">Coba cari dengan kata kunci lain</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reassign Guru -->
<div id="reassignModal" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4 rounded-t-2xl flex items-center justify-between text-white">
            <h3 class="text-xl font-bold flex items-center space-x-2">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Guru Memiliki Data Kunjungan</span>
            </h3>
            <button onclick="closeReassignModal()" class="hover:bg-white/10 rounded-lg p-2 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Guru <strong id="guruNameDisplay"></strong> memiliki <strong id="tamuCountDisplay"></strong> data kunjungan tamu.
                </p>
                <p class="text-sm text-yellow-700 mt-2">
                    Pilih guru pengganti atau hapus tanpa pengganti (data tamu akan diupdate).
                </p>
            </div>

            <form id="reassignForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie mr-1"></i> Guru Pengganti (Opsional)
                    </label>
                    <select name="new_guru_id" id="newGuruSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">-- Tidak ada pengganti (set NULL) --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }} ({{ $g->nip }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Jika tidak dipilih, data tamu akan diupdate tanpa guru tujuan</p>
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-trash-alt"></i>
                        <span>Hapus Guru</span>
                    </button>
                    <button type="button" onclick="closeReassignModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Simple Delete Confirmation -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4 rounded-t-2xl flex items-center justify-between text-white">
            <h3 class="text-xl font-bold flex items-center space-x-2">
                <i class="fas fa-trash-alt"></i>
                <span>Konfirmasi Hapus</span>
            </h3>
            <button onclick="closeDeleteModal()" class="hover:bg-white/10 rounded-lg p-2 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-2xl"></i>
                </div>
                <p class="text-lg text-gray-900 font-medium">Apakah Anda yakin ingin menghapus guru ini?</p>
                <p class="text-gray-600 mt-2">
                    <strong id="deleteGuruName"></strong>
                </p>
                <p class="text-sm text-red-600 mt-3">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                        Ya, Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const searchableRows = document.querySelectorAll('.searchable-row');
    const noResults = document.getElementById('noResults');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;

        searchableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            tableBody.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            tableBody.classList.remove('hidden');
        }
    });

    // Delete functionality with foreign key check
    let currentGuruId = null;
    let currentGuruName = '';

    function checkAndDelete(guruId, guruName) {
        currentGuruId = guruId;
        currentGuruName = guruName;

        // Check if guru can be deleted
        fetch(`/guru/${guruId}/check-delete`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.can_delete) {
                        // No related tamu, show simple delete confirmation
                        showDeleteModal(guruId, guruName);
                    } else {
                        // Has related tamu, show reassign modal
                        showReassignModal(guruId, guruName, data.tamu_count);
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memeriksa data guru');
            });
    }

    function showDeleteModal(guruId, guruName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameDisplay = document.getElementById('deleteGuruName');

        form.action = `/guru/${guruId}`;
        nameDisplay.textContent = guruName;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function showReassignModal(guruId, guruName, tamuCount) {
        const modal = document.getElementById('reassignModal');
        const form = document.getElementById('reassignForm');
        const nameDisplay = document.getElementById('guruNameDisplay');
        const countDisplay = document.getElementById('tamuCountDisplay');
        const selectElement = document.getElementById('newGuruSelect');

        // Set form action
        form.action = `/guru/${guruId}/reassign-delete`;
        nameDisplay.textContent = guruName;
        countDisplay.textContent = tamuCount;

        // Remove current guru from select options
        Array.from(selectElement.options).forEach(option => {
            if (option.value == guruId) {
                option.style.display = 'none';
            } else {
                option.style.display = 'block';
            }
        });

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReassignModal() {
        const modal = document.getElementById('reassignModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modals when clicking outside
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    document.getElementById('reassignModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeReassignModal();
        }
    });
</script>
@endpush
@endsection
