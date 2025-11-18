@extends('layouts.app')

@section('title', 'Tambah Guru')
@section('subtitle', 'Tambahkan data guru baru ke sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center space-x-2 text-sm">
        <a href="{{ route('guru.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
            Data Guru
        </a>
        <i class="fas fa-chevron-right text-gray-400"></i>
        <span class="text-gray-600">Tambah Guru</span>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-8 py-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Form Tambah Guru</h2>
            <p class="text-blue-100">Lengkapi formulir di bawah untuk menambahkan guru baru ke sistem</p>
        </div>

        <!-- Form Body -->
        <div class="p-8">
            <form action="{{ route('guru.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Form Section 1: Data Pribadi -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                        Data Pribadi
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- NIP -->
                        <div>
                            <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nip"
                                   name="nip"
                                   value="{{ old('nip') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all @error('nip') border-red-500 @enderror"
                                   placeholder="Contoh: 198005151999031001"
                                   required>
                            @error('nip')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>NIP harus unik dan tidak boleh sama dengan guru lain
                            </p>
                        </div>

                        <!-- Nama Guru -->
                        <div>
                            <label for="nama_guru" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nama_guru"
                                   name="nama_guru"
                                   value="{{ old('nama_guru') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all @error('nama_guru') border-red-500 @enderror"
                                   placeholder="Contoh: Bapak Ahmad Wijaya, S.Pd"
                                   required>
                            @error('nama_guru')
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
                    <a href="{{ route('guru.index') }}" class="flex-1 inline-flex items-center justify-center bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-arrow-left mr-2"></i>Batal
                    </a>
                    <button type="submit" class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>Simpan Guru
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
                        <li>• NIP harus unik untuk setiap guru</li>
                        <li>• Nama guru akan ditampilkan di pilihan guru tujuan kunjungan</li>
                        <li>• Data guru dapat diubah kapan saja dari halaman edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
