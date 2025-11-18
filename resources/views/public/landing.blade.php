@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="gradient-primary relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/2 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 py-20 md:py-32 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Hero Content -->
            <div class="text-white animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Selamat Datang di<br>
                    <span class="text-blue-200">SMK TI Airlangga</span>
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8 leading-relaxed">
                    Sistem Buku Tamu Digital untuk memudahkan pengajuan kunjungan dan pertemuan dengan guru atau staff sekolah.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('public.form') }}" class="inline-flex items-center justify-center bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-50 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                        <i class="fas fa-calendar-check mr-3"></i>Ajukan Kunjungan
                    </a>
                    <a href="#tentang" class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-info-circle mr-3"></i>Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="hidden md:block animate-fade-in-up">
                <img src="https://img.freepik.com/free-vector/flat-design-illustration-customer-support_23-2148887720.jpg"
                     alt="Hero Illustration"
                     class="w-full max-w-lg mx-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 w-full">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Kenapa Menggunakan Sistem Kami?
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary-600 to-purple-600 mx-auto mb-6"></div>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                Kemudahan dan kenyamanan dalam mengajukan kunjungan
            </p>
        </div>

        <!-- Feature Cards -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift group">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock text-3xl text-white"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">Hemat Waktu</h4>
                <p class="text-gray-600 leading-relaxed">
                    Ajukan kunjungan kapan saja tanpa harus datang langsung ke sekolah. Prosesnya cepat dan mudah.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift group">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">Aman & Terpercaya</h4>
                <p class="text-gray-600 leading-relaxed">
                    Data Anda tersimpan dengan aman. Sistem kami menjamin keamanan dan privasi informasi Anda.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-bell text-3xl text-white"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-4">Notifikasi Real-time</h4>
                <p class="text-gray-600 leading-relaxed">
                    Dapatkan update status kunjungan Anda secara langsung. Tidak perlu menunggu lama.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Cara Mengajukan Kunjungan
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary-600 to-purple-600 mx-auto mb-6"></div>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                Proses sederhana dalam 3 langkah
            </p>
        </div>

        <!-- Steps -->
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12 mb-12">
            <!-- Step 1 -->
            <div class="text-center relative">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center mx-auto shadow-xl">
                        <i class="fas fa-edit text-3xl text-white"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">1</span>
                </div>
                <h5 class="text-xl font-bold text-gray-900 mb-3">Isi Form</h5>
                <p class="text-gray-600 leading-relaxed">
                    Lengkapi formulir pengajuan kunjungan dengan data yang valid dan tujuan kunjungan Anda.
                </p>
                <!-- Arrow for desktop -->
                <div class="hidden md:block absolute top-10 left-full w-full">
                    <i class="fas fa-arrow-right text-4xl text-primary-300 transform -translate-x-1/2"></i>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="text-center relative">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto shadow-xl">
                        <i class="fas fa-paper-plane text-3xl text-white"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">2</span>
                </div>
                <h5 class="text-xl font-bold text-gray-900 mb-3">Kirim Pengajuan</h5>
                <p class="text-gray-600 leading-relaxed">
                    Kirimkan formulir dan tunggu konfirmasi dari pihak sekolah melalui kontak yang Anda berikan.
                </p>
                <!-- Arrow for desktop -->
                <div class="hidden md:block absolute top-10 left-full w-full">
                    <i class="fas fa-arrow-right text-4xl text-green-300 transform -translate-x-1/2"></i>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto shadow-xl">
                        <i class="fas fa-check-circle text-3xl text-white"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">3</span>
                </div>
                <h5 class="text-xl font-bold text-gray-900 mb-3">Kunjungan Disetujui</h5>
                <p class="text-gray-600 leading-relaxed">
                    Setelah disetujui, Anda dapat datang ke sekolah sesuai jadwal yang telah ditentukan.
                </p>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center">
            <a href="{{ route('public.form') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-purple-600 text-white px-10 py-4 rounded-full font-semibold text-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                <i class="fas fa-arrow-right mr-3"></i>Mulai Ajukan Sekarang
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="tentang" class="gradient-accent py-20 text-white relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -ml-48 -mb-48"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Image -->
            <div class="order-2 md:order-1">
                <img src="https://img.freepik.com/free-vector/school-building-educational-institution_107791-17426.jpg"
                     alt="About School"
                     class="w-full rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Content -->
            <div class="order-1 md:order-2">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                    Tentang SMK TI Airlangga
                </h2>
                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                    SMK TI Airlangga adalah sekolah kejuruan yang berfokus pada teknologi informasi dan komunikasi,
                    bertujuan mencetak lulusan yang kompeten dan siap bersaing di dunia kerja.
                </p>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition-all">
                        <i class="fas fa-check-circle text-4xl mb-3"></i>
                        <h5 class="text-3xl font-bold mb-1">1000+</h5>
                        <p class="text-blue-100">Siswa Aktif</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition-all">
                        <i class="fas fa-user-tie text-4xl mb-3"></i>
                        <h5 class="text-3xl font-bold mb-1">50+</h5>
                        <p class="text-blue-100">Tenaga Pendidik</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition-all">
                        <i class="fas fa-award text-4xl mb-3"></i>
                        <h5 class="text-3xl font-bold mb-1">20+</h5>
                        <p class="text-blue-100">Tahun Pengalaman</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition-all">
                        <i class="fas fa-laptop-code text-4xl mb-3"></i>
                        <h5 class="text-3xl font-bold mb-1">5</h5>
                        <p class="text-blue-100">Jurusan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-3xl p-12 md:p-16 text-center text-white shadow-2xl relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>

            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                    Siap Mengajukan Kunjungan?
                </h2>
                <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Ajukan kunjungan Anda sekarang dan rasakan kemudahan sistem buku tamu digital kami.
                </p>
                <a href="{{ route('public.form') }}" class="inline-flex items-center bg-white text-primary-600 px-10 py-4 rounded-full font-semibold text-lg hover:bg-blue-50 hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <i class="fas fa-calendar-plus mr-3"></i>Ajukan Kunjungan Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements
    document.querySelectorAll('.hover-lift, .grid > div').forEach(el => {
        observer.observe(el);
    });
</script>
@endpush
@endsection
