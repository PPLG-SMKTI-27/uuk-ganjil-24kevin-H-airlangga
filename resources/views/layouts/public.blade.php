<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SMK TI Airlangga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #1e40af;
        }

        /* Navbar scroll effect */
        .navbar-scrolled {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav id="navbar" class="gradient-primary sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white hover:opacity-90 transition-opacity">
                    <i class="fas fa-school text-3xl"></i>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl leading-tight">SMK TI Airlangga</span>
                        <span class="text-xs text-blue-100">Buku Tamu Digital</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium">
                        Beranda
                    </a>
                    <a href="{{ route('public.form') }}" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium">
                        Pengajuan Kunjungan
                    </a>
                    <a href="#tentang" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium">
                        Tentang
                    </a>
                    <a href="#kontak" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium">
                        Kontak
                    </a>
                    <a href="{{ route('login') }}" class="ml-4 bg-white text-primary-600 px-6 py-2.5 rounded-full font-semibold hover:bg-blue-50 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Admin
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all">
                        Beranda
                    </a>
                    <a href="{{ route('public.form') }}" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all">
                        Pengajuan Kunjungan
                    </a>
                    <a href="#tentang" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all">
                        Tentang
                    </a>
                    <a href="#kontak" class="text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all">
                        Kontak
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-primary-600 px-6 py-2.5 rounded-full font-semibold text-center hover:bg-blue-50 transition-all">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-school text-2xl text-primary-400"></i>
                        <h5 class="text-xl font-bold">SMK TI Airlangga</h5>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Sekolah Menengah Kejuruan Teknologi Informasi yang berkomitmen menghasilkan lulusan berkualitas dan siap kerja.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h5 class="text-xl font-bold mb-4">Link Cepat</h5>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white hover:pl-2 transition-all flex items-center">
                                <i class="fas fa-chevron-right mr-2 text-xs"></i>Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.form') }}" class="text-gray-400 hover:text-white hover:pl-2 transition-all flex items-center">
                                <i class="fas fa-chevron-right mr-2 text-xs"></i>Pengajuan Kunjungan
                            </a>
                        </li>
                        <li>
                            <a href="#tentang" class="text-gray-400 hover:text-white hover:pl-2 transition-all flex items-center">
                                <i class="fas fa-chevron-right mr-2 text-xs"></i>Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="#kontak" class="text-gray-400 hover:text-white hover:pl-2 transition-all flex items-center">
                                <i class="fas fa-chevron-right mr-2 text-xs"></i>Kontak
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div id="kontak">
                    <h5 class="text-xl font-bold mb-4">Kontak Kami</h5>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-400"></i>
                            <span>Jl. Pendidikan No. 123, Surabaya</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-primary-400"></i>
                            <span>(031) 1234-5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-400"></i>
                            <span>info@smktiairlangga.sch.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary-400"></i>
                            <span>Senin - Jumat: 07:00 - 16:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} SMK TI Airlangga. All Rights Reserved. |
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a> |
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Parallax Script -->
    <script src="{{ asset('js/parallax.js') }}"></script>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = mobileMenuButton.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (navbar) {
                if (window.scrollY > 20) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    if (mobileMenu) {
                        mobileMenu.classList.add('hidden');
                        const icon = mobileMenuButton.querySelector('i');
                        icon.classList.add('fa-bars');
                        icon.classList.remove('fa-times');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
