@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('subtitle', 'Riwayat aktivitas pengguna sistem')

@section('content')
<div class="space-y-6">
    <!-- Header with Export Button -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Log Aktivitas</h2>
            <p class="text-gray-600 mt-1">Total: <span class="font-semibold">{{ $logs->total() }} Log</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('log-aktivitas.export', request()->query()) }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-700 transition-all">
                <i class="fas fa-download mr-2"></i>Export CSV
            </a>
            <button onclick="openCleanupModal()" class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-700 transition-all">
                <i class="fas fa-trash-alt mr-2"></i>Cleanup
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form method="GET" action="{{ route('log-aktivitas.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filter by User -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-1"></i> Pengguna
                    </label>
                    <select name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_pengguna }}" {{ request('user_id') == $user->id_pengguna ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ $user->peran ? $user->peran->nama_peran : 'User' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i> Dari Tanggal
                    </label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Filter by Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i> Sampai Tanggal
                    </label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <!-- Filter by Table -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-table mr-1"></i> Tabel
                    </label>
                    <select name="tabel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Semua Tabel</option>
                        @foreach($tables as $table)
                            <option value="{{ $table }}" {{ request('tabel') == $table ? 'selected' : '' }}>
                                {{ ucfirst($table) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Search Keyword -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Cari Aktivitas
                </label>
                <div class="flex gap-3">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari deskripsi aktivitas..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('log-aktivitas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Log Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Pengguna</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tabel</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Makassar')->format('d M Y') }}
                                    </p>
                                    <p class="text-gray-500">
                                        {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Makassar')->format('H:i') }} WITA
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $log->pengguna ? strtoupper(substr($log->pengguna->nama, 0, 1)) : '?' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $log->pengguna ? $log->pengguna->nama : 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $log->pengguna && $log->pengguna->peran ? $log->pengguna->peran->nama_peran : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $log->aktivitas }}</p>
                                        @if($log->id_record)
                                            <p class="text-xs text-gray-500">ID: {{ $log->id_record }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->tabel_terkait)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                        @if($log->tabel_terkait == 'tamu') bg-green-100 text-green-700
                                        @elseif($log->tabel_terkait == 'guru') bg-blue-100 text-blue-700
                                        @elseif($log->tabel_terkait == 'pengguna') bg-purple-100 text-purple-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        <i class="fas fa-table mr-1"></i>
                                        {{ ucfirst($log->tabel_terkait) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="text-gray-900 font-mono">{{ $log->ip_address ?? '-' }}</p>
                                    @if($log->user_agent)
                                        <p class="text-xs text-gray-500 truncate max-w-xs" title="{{ $log->user_agent }}">
                                            {{ Str::limit($log->user_agent, 30) }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-4"></i>
                                    <p class="text-lg text-gray-500 font-medium">Tidak ada log aktivitas</p>
                                    <p class="text-sm text-gray-400 mt-1">Log akan muncul saat ada aktivitas pengguna</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Cleanup Modal -->
<div id="cleanupModal" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-4 rounded-t-2xl flex items-center justify-between text-white">
            <h3 class="text-xl font-bold flex items-center space-x-2">
                <i class="fas fa-trash-alt"></i>
                <span>Cleanup Log Lama</span>
            </h3>
            <button onclick="closeCleanupModal()" class="hover:bg-white/10 rounded-lg p-2 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('log-aktivitas.cleanup') }}">
            @csrf
            <div class="p-6 space-y-4">
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Fitur ini akan menghapus log aktivitas yang lebih lama dari jumlah hari yang ditentukan.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hapus log lebih dari (hari):
                    </label>
                    <input type="number" name="days" value="30" min="1" max="365" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Default: 30 hari</p>
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>Hapus Log
                    </button>
                    <button type="button" onclick="closeCleanupModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCleanupModal() {
        document.getElementById('cleanupModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCleanupModal() {
        document.getElementById('cleanupModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modal when clicking outside
    document.getElementById('cleanupModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCleanupModal();
        }
    });
</script>
@endpush
@endsection
