@extends('layouts.public')

@section('title', 'Pengajuan Berhasil')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12 md:py-20 flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                <div class="p-8 md:p-12 text-center">
                    <!-- Animated Success Icon -->
                    <div class="mb-8 relative">
                        <div class="mx-auto w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-2xl animate-bounce">
                            <i class="fas fa-check text-6xl text-white"></i>
                        </div>
                        <!-- Decorative circles -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-green-200 rounded-full opacity-20 animate-ping"></div>
                    </div>

                    <!-- Success Message -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Pengajuan Berhasil! 🎉
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                        Terima kasih telah mengajukan kunjungan ke SMK TI Airlangga. Pengajuan Anda telah kami terima dan sedang dalam proses verifikasi.
                    </p>

                    <!-- Success Alert -->
                    <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-6 mb-6 text-left">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Langkah Selanjutnya:</h3>
                                <ul class="space-y-2 text-gray-700">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Pengajuan Anda akan diproses oleh admin sekolah</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Konfirmasi akan dikirim melalui nomor telepon yang Anda daftarkan</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                        <span>Silakan menunggu 1-2 hari kerja untuk proses verifikasi</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Important Note -->
                    <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-6 mb-8 text-left">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Penting!</h3>
                                <p class="text-gray-700 mb-4">
                                    Pastikan nomor telepon Anda aktif agar dapat dihubungi oleh pihak sekolah.
                                    Jika dalam 2 hari kerja belum ada konfirmasi, silakan hubungi:
                                </p>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="flex items-center space-x-3 bg-white rounded-xl p-4">
                                        <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Telepon</p>
                                            <p class="font-semibold text-gray-900">(031) 1234-5678</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 bg-white rounded-xl p-4">
                                        <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="font-semibold text-gray-900 text-sm">info@smktiairlangga.sch.id</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('home') }}" class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                            <i class="fas fa-home mr-3"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('public.form') }}" class="flex-1 inline-flex items-center justify-center bg-white text-primary-600 border-2 border-primary-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-primary-50 transition-all transform hover:-translate-y-1">
                            <i class="fas fa-plus mr-3"></i>Ajukan Kunjungan Lagi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center hover:shadow-2xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <h5 class="font-bold text-gray-900 mb-2">Respon Cepat</h5>
                    <p class="text-sm text-gray-600">Kami akan merespon pengajuan Anda maksimal 2x24 jam</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center hover:shadow-2xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell text-2xl text-white"></i>
                    </div>
                    <h5 class="font-bold text-gray-900 mb-2">Notifikasi Langsung</h5>
                    <p class="text-sm text-gray-600">Dapatkan update status via WhatsApp atau SMS</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center hover:shadow-2xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-white"></i>
                    </div>
                    <h5 class="font-bold text-gray-900 mb-2">Bantuan 24/7</h5>
                    <p class="text-sm text-gray-600">Tim support kami siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    // Confetti effect (optional)
    console.log('✅ Pengajuan berhasil dikirim!');

    // Auto redirect prompt after 30 seconds
    setTimeout(function() {
        const redirect = confirm('Apakah Anda ingin kembali ke halaman utama?');
        if (redirect) {
            window.location.href = "{{ route('home') }}";
        }
    }, 30000);
</script>
@endpush
@endsection
