@extends('layouts.public')

@section('title', 'Pengajuan Kunjungan')

@section('content')
<!-- Page Header -->
<section class="gradient-primary py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center text-white">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <i class="fas fa-calendar-check text-4xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Pengajuan Kunjungan</h1>
            <p class="text-lg md:text-xl text-blue-100">
                Silakan lengkapi formulir di bawah ini untuk mengajukan kunjungan ke SMK TI Airlangga
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 md:py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primary-600 to-purple-600 p-6 md:p-8 text-white">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2">Form Pengajuan Kunjungan</h3>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-xl mt-1"></i>
                        <p class="text-blue-100">
                            Mohon isi semua data dengan benar. Data yang Anda berikan akan digunakan untuk keperluan administrasi.
                        </p>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-6 md:p-10">
                    <form action="{{ route('public.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Data Pribadi Section -->
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Data Pribadi
                            </h4>
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div class="md:col-span-2">
                                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           id="nama"
                                           name="nama"
                                           value="{{ old('nama') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all @error('nama') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap Anda"
                                           required>
                                    @error('nama')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Telepon -->
                                <div>
                                    <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                                        No. Telepon / WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input type="tel"
                                               id="telepon"
                                               name="telepon"
                                               value="{{ old('telepon') }}"
                                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all @error('telepon') border-red-500 @enderror"
                                               placeholder="081234567890"
                                               required>
                                    </div>
                                    @error('telepon')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="status"
                                                name="status"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all appearance-none @error('status') border-red-500 @enderror"
                                                required>
                                            <option value="">Pilih Status</option>
                                            <option value="Orang Tua/Wali" {{ old('status') == 'Orang Tua/Wali' ? 'selected' : '' }}>Orang Tua/Wali</option>
                                            <option value="Siswa" {{ old('status') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                                            <option value="Alumni" {{ old('status') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                                            <option value="Mitra/Vendor" {{ old('status') == 'Mitra/Vendor' ? 'selected' : '' }}>Mitra/Vendor</option>
                                            <option value="Instansi Pemerintah" {{ old('status') == 'Instansi Pemerintah' ? 'selected' : '' }}>Instansi Pemerintah</option>
                                            <option value="Media" {{ old('status') == 'Media' ? 'selected' : '' }}>Media</option>
                                            <option value="Lainnya" {{ old('status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('status')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="alamat"
                                              name="alamat"
                                              rows="3"
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all resize-none @error('alamat') border-red-500 @enderror"
                                              placeholder="Masukkan alamat lengkap Anda"
                                              required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t-2 border-gray-100"></div>

                        <!-- Detail Kunjungan Section -->
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Detail Kunjungan
                            </h4>
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Jenis Kunjungan -->
                                <div class="md:col-span-2">
                                    <label for="id_jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jenis Kunjungan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="id_jenis"
                                                name="id_jenis"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all appearance-none @error('id_jenis') border-red-500 @enderror"
                                                required>
                                            <option value="">Pilih Jenis Kunjungan</option>
                                            @foreach($jenisKunjungan as $jenis)
                                                <option value="{{ $jenis->id_jenis }}" {{ old('id_jenis') == $jenis->id_jenis ? 'selected' : '' }}>
                                                    {{ $jenis->nama_jenis }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('id_jenis')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Guru Tujuan -->
                                <div class="md:col-span-2">
                                    <label for="guru_tujuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Guru/Staff Tujuan
                                    </label>
                                    <div class="relative">
                                        <select id="guru_tujuan"
                                                name="guru_tujuan"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all appearance-none @error('guru_tujuan') border-red-500 @enderror">
                                            <option value="">Pilih Guru/Staff (Opsional)</option>
                                            @foreach($guru as $g)
                                                <option value="{{ $g->id_guru }}" {{ old('guru_tujuan') == $g->id_guru ? 'selected' : '' }}>
                                                    {{ $g->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-lightbulb mr-1"></i>Kosongkan jika tidak bertemu dengan guru tertentu
                                    </p>
                                    @error('guru_tujuan')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Tujuan Kunjungan -->
                                <div class="md:col-span-2">
                                    <label for="tujuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tujuan Kunjungan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="tujuan"
                                              name="tujuan"
                                              rows="4"
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all resize-none @error('tujuan') border-red-500 @enderror"
                                              placeholder="Jelaskan tujuan dan keperluan kunjungan Anda secara detail"
                                              required>{{ old('tujuan') }}</textarea>
                                    @error('tujuan')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Tanggal Kunjungan -->
                                <div>
                                    <label for="tanggal_kunjungan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Kunjungan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                        <input type="date"
                                               id="tanggal_kunjungan"
                                               name="tanggal_kunjungan"
                                               value="{{ old('tanggal_kunjungan') }}"
                                               min="{{ date('Y-m-d') }}"
                                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all @error('tanggal_kunjungan') border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('tanggal_kunjungan')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Waktu Masuk -->
                                <div>
                                    <label for="waktu_masuk" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jam Kunjungan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-clock text-gray-400"></i>
                                        </div>
                                        <input type="time"
                                               id="waktu_masuk"
                                               name="waktu_masuk"
                                               value="{{ old('waktu_masuk') }}"
                                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all @error('waktu_masuk') border-red-500 @enderror"
                                               required>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>Jam operasional: 07:00 - 16:00
                                    </p>
                                    @error('waktu_masuk')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Keterangan Tambahan -->
                                <div class="md:col-span-2">
                                    <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Keterangan Tambahan
                                    </label>
                                    <textarea id="keterangan"
                                              name="keterangan"
                                              rows="3"
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-all resize-none @error('keterangan') border-red-500 @enderror"
                                              placeholder="Informasi tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border-l-4 border-primary-500 p-5 rounded-xl">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-2xl text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-sm font-semibold text-gray-900 mb-1">Informasi Penting</h5>
                                    <p class="text-sm text-gray-700 leading-relaxed">
                                        Setelah mengirim formulir, Anda akan menerima konfirmasi melalui nomor telepon yang didaftarkan.
                                        Harap pastikan nomor yang Anda masukkan aktif dan dapat dihubungi.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <a href="{{ route('home') }}" class="flex-1 inline-flex items-center justify-center bg-gray-100 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-200 transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit" class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info Cards -->
            <div class="grid md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white rounded-xl p-6 shadow-lg text-center">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Data Aman</h5>
                    <p class="text-sm text-gray-600">Informasi Anda terlindungi dengan baik</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg text-center">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Proses Cepat</h5>
                    <p class="text-sm text-gray-600">Konfirmasi dalam 1-2 hari kerja</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg text-center">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Support 24/7</h5>
                    <p class="text-sm text-gray-600">Tim kami siap membantu Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Set minimum date to today
    document.getElementById('tanggal_kunjungan').min = new Date().toISOString().split('T')[0];

    // Validate working hours
    document.getElementById('waktu_masuk').addEventListener('change', function() {
        const time = this.value;
        const [hours, minutes] = time.split(':').map(Number);
        const timeInMinutes = hours * 60 + minutes;

        const openTime = 7 * 60; // 07:00
        const closeTime = 16 * 60; // 16:00

        if (timeInMinutes < openTime || timeInMinutes > closeTime) {
            alert('Mohon pilih jam antara 07:00 - 16:00 (jam operasional sekolah)');
            this.value = '08:00';
        }
    });

    // Auto-resize textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
</script>
@endpush
@endsection
