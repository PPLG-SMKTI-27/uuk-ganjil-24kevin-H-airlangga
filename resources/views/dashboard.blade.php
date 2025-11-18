@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Lihat ringkasan data kunjungan dan statistik')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tamu Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
            <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Total Tamu</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($statistik['total_tamu']) }}</p>
                        <p class="text-xs text-blue-600 mt-2">
                            <i class="fas fa-database mr-1"></i>Semua waktu
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kunjungan Hari Ini Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
            <div class="h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Hari Ini</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($statistik['tamu_hari_ini']) }}</p>
                        @if($perbandingan_hari != 0)
                            <p class="text-xs mt-2 {{
 $perbandingan_hari > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas fa-arrow-{{ $perbandingan_hari > 0 ? 'up' : 'down' }} mr-1"></i>
                                {{ abs($perbandingan_hari) }}% dari kemarin
                            </p>
                        @else
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-minus mr-1"></i>Sama dengan kemarin
                            </p>
                        @endif
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending/Proses Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
            <div class="h-1 bg-gradient-to-r from-amber-500 to-amber-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Sedang Proses</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($statistik['kunjungan_proses']) }}</p>
                        <p class="text-xs text-amber-600 mt-2">
                            <i class="fas fa-clock mr-1"></i>Memerlukan perhatian
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-3xl text-amber-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Guru Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
            <div class="h-1 bg-gradient-to-r from-purple-500 to-purple-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Total Guru</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($statistik['total_guru']) }}</p>
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Data terbaru
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-3xl text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Stats Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-2">Kunjungan Bulan Ini</p>
                <p class="text-4xl font-bold mb-2">{{ number_format($statistik['tamu_bulan_ini']) }} Pengunjung</p>
                @if($perbandingan_bulan != 0)
                    <p class="text-sm text-blue-100">
                        <i class="fas fa-arrow-{{ $perbandingan_bulan > 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ abs($perbandingan_bulan) }}% {{ $perbandingan_bulan > 0 ? 'lebih tinggi' : 'lebih rendah' }} dari bulan lalu
                    </p>
                @else
                    <p class="text-sm text-blue-100">
                        <i class="fas fa-minus mr-1"></i>Sama dengan bulan lalu
                    </p>
                @endif
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Visitor Trend Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Tren Pengunjung (7 Hari Terakhir)</h3>
                <p class="text-sm text-gray-600 mt-1">Grafik jumlah pengunjung per hari</p>
            </div>
            <div class="h-64">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Status Kunjungan</h3>
                <p class="text-sm text-gray-600 mt-1">Distribusi status tamu</p>
            </div>
            <div class="space-y-4">
                <!-- Selesai -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>Selesai
                        </span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ $statistik['kunjungan_selesai'] }} ({{ $persentase_status['selesai'] }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $persentase_status['selesai'] }}%"></div>
                    </div>
                </div>

                <!-- Proses -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>Proses
                        </span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ $statistik['kunjungan_proses'] }} ({{ $persentase_status['proses'] }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $persentase_status['proses'] }}%"></div>
                    </div>
                </div>

                <!-- Dibatalkan -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 flex items-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>Dibatalkan
                        </span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ $statistik['kunjungan_dibatalkan'] }} ({{ $persentase_status['dibatalkan'] }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full transition-all duration-500" style="width: {{ $persentase_status['dibatalkan'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-700">Total</span>
                    <span class="text-lg font-bold text-gray-900">{{ $statistik['total_tamu'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Jenis Kunjungan Populer -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Jenis Kunjungan Terpopuler</h3>
                <p class="text-sm text-gray-600 mt-1">Top 5 jenis kunjungan</p>
            </div>
            @if($jenis_populer->count() > 0)
                <div class="space-y-4">
                    @foreach($jenis_populer as $index => $item)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <span class="font-medium text-gray-900">
                                    {{ $item->jenisKunjungan->nama_jenis ?? 'Tidak Diketahui' }}
                                </span>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                {{ $item->total }} kunjungan
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada data jenis kunjungan</p>
                </div>
            @endif
        </div>

        <!-- Guru Paling Banyak Dikunjungi -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Guru/Staff Terpopuler</h3>
                <p class="text-sm text-gray-600 mt-1">Top 5 guru yang paling banyak dikunjungi</p>
            </div>
            @if($guru_populer->count() > 0)
                <div class="space-y-4">
                    @foreach($guru_populer as $index => $item)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $item->guru->nama_guru ?? 'Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $item->guru->nip ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                {{ $item->total }}x
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada data kunjungan guru</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Visitors -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Pengunjung Terbaru</h3>
            </div>
            @if($tamu_terbaru->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($tamu_terbaru->take(5) as $tamu)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <p class="font-semibold text-gray-900">{{ $tamu->nama }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($tamu->status == 'Orang Tua/Wali') bg-blue-100 text-blue-700
                                            @elseif($tamu->status == 'Siswa') bg-green-100 text-green-700
                                            @elseif($tamu->status == 'Alumni') bg-purple-100 text-purple-700
                                            @else bg-gray-100 text-gray-700
                                            @endif
                                        ">
                                            {{ $tamu->status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $tamu->tanggal_kunjungan->format('d M Y') }} • {{ $tamu->waktu_masuk }}
                                    </p>
                                    @if($tamu->guru)
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-user-tie mr-1"></i>{{ $tamu->guru->nama_guru }}
                                        </p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold ml-3
                                    @if($tamu->status_kunjungan == 'selesai') bg-green-100 text-green-700
                                    @elseif($tamu->status_kunjungan == 'proses') bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ ucfirst($tamu->status_kunjungan) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="{{ route('tamu.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                        Lihat Semua Pengunjung <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Belum ada data pengunjung</p>
                    <a href="{{ route('tamu.create') }}" class="inline-flex items-center mt-4 text-primary-600 hover:text-primary-700 font-medium">
                        <i class="fas fa-plus mr-2"></i>Tambah Pengunjung
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Aksi Cepat</h3>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('tamu.create') }}" class="flex items-center space-x-4 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Tambah Tamu</p>
                        <p class="text-sm text-gray-600">Catat pengunjung baru</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('guru.create') }}" class="flex items-center space-x-4 p-4 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors group">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-user text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Tambah Guru</p>
                        <p class="text-sm text-gray-600">Tambahkan data guru baru</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('tamu.index') }}" class="flex items-center space-x-4 p-4 rounded-xl bg-green-50 hover:bg-green-100 transition-colors group">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-list text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Kelola Tamu</p>
                        <p class="text-sm text-gray-600">Lihat dan edit data tamu</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('guru.index') }}" class="flex items-center space-x-4 p-4 rounded-xl bg-amber-50 hover:bg-amber-100 transition-colors group">
                    <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users-class text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Kelola Guru</p>
                        <p class="text-sm text-gray-600">Kelola data guru dan staff</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Data dari Backend
    const chartData = @json($chart_data);

    // Visitor Trend Chart
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.tanggal),
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: chartData.map(item => item.jumlah),
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderColor: 'rgb(37, 99, 235)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(37, 99, 235)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,

            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12
,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' pengunjung';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endpush
@endsection
