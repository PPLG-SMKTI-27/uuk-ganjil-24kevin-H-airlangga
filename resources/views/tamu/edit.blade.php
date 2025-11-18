@extends('layouts.app')

@section('title', 'Edit Tamu')
@section('subtitle', 'Perbarui data pengunjung yang sudah ada')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center space-x-2 text-sm">
        <a href="{{ route('tamu.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
            Data Tamu
        </a>
        <i class="fas fa-chevron-right text-gray-400"></i>
        <span class="text-gray-600">Edit Tamu</span>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-8 py-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Edit Data Tamu</h2>
            <p class="text-blue-100">Perbarui informasi pengunjung {{ $tamu->nama }}</p>
        </div>

        <!-- Form Body -->
        <div class="p-8">
            <form action="{{ route('tamu.update', $tamu->id_tamu) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section 1: Data Pribadi -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                        Data Pribadi
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama', $tamu->nama) }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all @error('nama') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap"
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
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="tel"
                                       id="telepon"
                                       name="telepon"
                                       value="{{ old('telepon', $tamu->telepon) }}"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all @error('telepon') border-red-500 @enderror"
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
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none appearance-none transition-all @error('status') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="Orang Tua/Wali" {{ old('status', $tamu->status) == 'Orang Tua/Wali' ? 'selected' : '' }}>Orang Tua/Wali</option>
                                    <option value="Siswa" {{ old('status', $tamu->status) == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="Alumni" {{ old('status', $tamu->status) == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                                    <option value="Mitra/Vendor" {{ old('status', $tamu->status) == 'Mitra/Vendor' ? 'selected' : '' }}>Mitra/Vendor</option>
                                    <option value="Instansi Pemerintah" {{ old('status', $tamu->status) == 'Instansi Pemerintah' ? 'selected' : '' }}>Instansi Pemerintah</option>
                                    <option value="Media" {{ old('status', $tamu->status) == 'Media' ? 'selected' : '' }}>Media</option>
                                    <option value="Lainnya" {{ old('status', $tamu->status) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat"
                                      name="alamat"
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all resize-none @error('alamat') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap"
                                      required>{{ old('alamat', $tamu->alamat) }}</textarea>
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

                <!-- Section 2: Detail Kunjungan -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">2</span>
                        Detail Kunjungan
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Jenis Kunjungan -->
                        <div>
                            <label for="id_jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="id_jenis"
                                        name="id_jenis"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none appearance-none transition-all @error('id_jenis') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Jenis Kunjungan</option>
                                    @foreach($jenisKunjungan as $jenis)
                                        <option value="{{ $jenis->id_jenis }}" {{ old('id_jenis', $tamu->id_jenis) == $jenis->id_jenis ? 'selected' : '' }}>
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
                        <div>
                            <label for="guru_tujuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Guru/Staff Tujuan
                            </label>
                            <div class="relative">
                                <select id="guru_tujuan"
                                        name="guru_tujuan"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none appearance-none transition-all @error('guru_tujuan') border-red-500 @enderror">
                                    <option value="">Pilih Guru (Opsional)</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id_guru }}" {{ old('guru_tujuan', $tamu->guru_tujuan) == $g->id_guru ? 'selected' : '' }}>
                                            {{ $g->nama_guru }} ({{ $g->nip }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            @error('guru_tujuan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div class="md:col-span-2">
                            <label for="tujuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tujuan Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="tujuan"
                                      name="tujuan"
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all resize-none @error('tujuan') border-red-500 @enderror"
                                      placeholder="Jelaskan tujuan kunjungan secara detail"
                                      required>{{ old('tujuan', $tamu->tujuan) }}</textarea>
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
                                <i class="fas fa-calendar absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="date"
                                       id="tanggal_kunjungan"
                                       name="tanggal_kunjungan"
                                       value="{{ old('tanggal_kunjungan', $tamu->tanggal_kunjungan->format('Y-m-d')) }}"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all @error('tanggal_kunjungan') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('tanggal_kunjungan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Keterangan Tambahan
                            </label>
                            <textarea id="keterangan"
                                      name="keterangan"
                                      rows="2"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all resize-none @error('keterangan') border-red-500 @enderror"
                                      placeholder="Informasi tambahan (opsional)">{{ old('keterangan',
 $tamu->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-gray-100"></div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('tamu.index') }}" class="flex-1 inline-flex items-center justify-center bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-arrow-left mr-2"></i>Batal
                    </a>
                    <button type="submit" class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>Perbarui Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-t-2 border-blue-200 px-8 py-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 text-xl mt-1 mr-4"></i>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">Informasi Penting</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Pastikan semua data yang diperbarui sudah benar sebelum menyimpan</li>
                        <li>• Perubahan data akan langsung tersimpan ke sistem</li>
                        <li>• Jika ada kesalahan, dapat diubah kembali kapan saja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
