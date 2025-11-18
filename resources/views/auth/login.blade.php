<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -
 SMK TI Airlangga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        .gradient-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-delay-1 { animation-delay: 0s; }
        .float-delay-2 { animation-delay: 2s; }
        .float-delay-3 { animation-delay: 4s; }

        .shine {
            position: relative;
            overflow: hidden;
        }

        .shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .shine:hover::before {
            left: 100%;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .animate-shake {
            animation: shake 0.5s;
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

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Left Side - Decorative Section -->
        <div class="hidden lg:flex lg:w-1/2 gradient-bg relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <!-- Floating Circles -->
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 opacity-10 rounded-full blur-3xl floating float-delay-1"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-300 opacity-10 rounded-full blur-3xl floating float-delay-2"></div>
                <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-blue-300 opacity-10 rounded-full blur-3xl floating float-delay-3"></div>

                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;"></div>

                <!-- Floating Particles -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="particle absolute w-2 h-2 bg-cyan-300 rounded-full opacity-40 floating" style="top: 20%; left: 10%;"></div>
                    <div class="particle absolute w-3 h-3 bg-blue-300 rounded-full opacity-30 floating float-delay-1" style="top: 40%; left: 80%;"></div>
                    <div class="particle absolute w-2 h-2 bg-cyan-200 rounded-full opacity-40 floating float-delay-2" style="top: 60%; left: 30%;"></div>
                    <div class="particle absolute w-4 h-4 bg-blue-200 rounded-full opacity-20 floating float-delay-3" style="top: 80%; left: 70%;"></div>
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
                <!-- Logo/Icon -->
                <div class="mb-8 fade-in-up">
                    <div class="w-24 h-24 bg-white/10 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white/20 shadow-2xl floating">
                        <i class="fas fa-school text-5xl text-white"></i>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-8 fade-in-up" style="animation-delay: 0.2s;">
                    <h1 class="text-5xl font-extrabold mb-4">
                        SMK TI Airlangga
                    </h1>
                    <p class="text-2xl font-light text-white/90">
                        Buku Tamu Digital
                    </p>
                </div>

                <!-- Description -->
                <div class="max-w-md text-center mb-8 fade-in-up" style="animation-delay: 0.4s;">
                    <p class="text-lg text-white/80 leading-relaxed">
                        Sistem manajemen kunjungan yang modern dan efisien untuk sekolah
                    </p>
                </div>

                <!-- Features -->
                <div class="grid grid-cols-3 gap-6 w-full max-w-lg fade-in-up" style="animation-delay: 0.6s;">
                    <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300 hover:bg-white/10">
                        <div class="text-3xl font-bold mb-1">1000+</div>
                        <div class="text-sm text-blue-100">Siswa</div>
                    </div>
                    <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300 hover:bg-white/10">
                        <div class="text-3xl font-bold mb-1">50+</div>
                        <div class="text-sm text-blue-100">Guru</div>
                    </div>
                    <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300 hover:bg-white/10">
                        <div class="text-3xl font-bold mb-1">20+</div>
                        <div class="text-sm text-blue-100">Tahun</div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="mt-12 flex justify-center space-x-2">
                    <div class="w-2 h-2 bg-cyan-300 rounded-full"></div>
                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-cyan-300 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 bg-gray-50 relative">
            <!-- Mobile Background Gradient (Only on small screens) -->
            <div class="lg:hidden absolute inset-0 gradient-bg opacity-5"></div>

            <div class="w-full max-w-md relative z-10">
                <!-- Back to Home Button -->
                <div class="mb-6 fade-in-up">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors group">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-medium">Kembali ke Beranda</span>
                    </a>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 transform hover:shadow-3xl transition-all duration-300 fade-in-up" style="animation-delay: 0.2s;">
                    <!-- Header
 -->
                    <div class="text-center mb-8">
                        <!-- Mobile Logo -->
                        <div class="lg:hidden mb-6">
                            <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto shadow-xl">
                                <i class="fas fa-school text-white text-3xl"></i>
                            </div>
                        </div>

                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">
                            Selamat Datang!
                        </h2>
                        <p class="text-gray-500 text-sm sm:text-base">Masuk ke panel admin untuk mengelola sistem</p>
                    </div>

                    <!-- Alert Messages -->
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-shake">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl mt-0.5"></i>
                                <div>
                                    <p class="text-red-800 font-semibold text-sm sm:text-base">Login Gagal</p>
                                    <p class="text-red-600 text-xs sm:text-sm mt-1">Email atau password sal
ah. Silakan coba lagi.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                            <div class="flex items-start">

                                <i class="fas fa-check-circle text-green-500 mr-3 text-xl mt-0.5"></i>
                                <div>
                                    <p class="text-green-800 text-sm sm:text-base">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-blue-600 mr-2"></i>Email
                            </label>
                            <div class="relative">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-800 placeholder-gray-400 text-sm sm:text-base"
                                    placeholder="admin@smktiairlangga.sch.id"
                                    required
                                    autofocus
                                >
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-user-circle text-lg sm:text-xl"></i>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-blue-600 mr-2"></i>Password
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-800 placeholder-gray-400 text-sm sm:text-base pr-12"
                                    placeholder="••••••••••"
                                    required
                                >
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray
-400 hover:text-gray-600 transition-colors focus:outline-none"
                                >
                                    <i class="fas fa-eye text-lg sm:text-xl" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full gradient-bg hover:opacity-90 text-white font-bold py-3 sm:py-4 px-6 rounded-xl transition duration-300 transform hover:scale-[1.02] hover:shadow-xl shine text-sm sm:text-base"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk Sekarang
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6 sm:my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs sm:text-sm">
                            <span class="px-4 bg-white text-gray-500">atau</span>
                        </div>
                    </div>

                    <!-- Back to Website -->
                    <a href="{{ route('home') }}" class="w-full flex items-center justify-center px-6 py-3 border-2 border-gray-200 rounded-xl text-gray-700 font-medium hover:bg-gray-50 hover:border-blue-300 transition duration-200 text-sm sm:text-base group">
                        <i class="fas fa-home mr-2 text-blue-600 group-hover:scale-110 transition-transform"></i>
                        Kembali ke Website
                    </a>
                </div>

                <!-- Footer Info -->
                <div class="mt-6 sm:mt-8 text-center fade-in-up" style="animation-delay: 0.4s;">
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        © {{ date('Y') }} SMK TI Airlangga. All rights reserved.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110">
                            <i class="fab fa-youtube text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate-shake, .bg-green-50');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
