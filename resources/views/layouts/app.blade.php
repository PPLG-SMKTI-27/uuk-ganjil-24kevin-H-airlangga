<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Buku Tamu Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
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
            font-family: 'Inter', sans-serif;
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gradient-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        /* Sidebar persistent state */
        .sidebar-collapsed {
            transform: translateX(-100%);
        }

        @media (min-width: 1024px) {
            .sidebar-collapsed {
                transform: translateX(0);
            }
        }

        /* Modal styles */
        .modal-overlay {
            backdrop-filter: blur(4px);
            animation: fadeIn 0.2s ease-out;
        }

        .modal-content {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-inter">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 gradient-primary text-white transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fas fa-school text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold leading-tight">Buku Tamu</h1>
                            <p class="text-xs text-blue-200">SMK TI Airlangga</p>
                        </div>
                    </div>
                    <button id="sidebar-close" class="lg:hidden text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scrollbar">
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all {{ Request::is('dashboard') ? 'active bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt text-lg w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('tamu.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all {{ Request::is('tamu*') ? 'active bg-white/20' : '' }}">
                        <i class="fas fa-users text-lg w-5"></i>
                        <span class="font-medium">Data Tamu</span>
                    </a>

                    <a href="{{ route('guru.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all {{ Request::is('guru*') ? 'active bg-white/20' : '' }}">
                        <i class="fas fa-chalkboard-teacher text-lg w-5"></i>
                        <span class="font-medium">Data Guru</span>
                    </a>

                    <a href="{{ route('log-aktivitas.index') }}" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all {{ Request::is('log-aktivitas*') ? 'active bg-white/20' : '' }}">
                        <i class="fas fa-clipboard-list text-lg w-5"></i>
                        <span class="font-medium">Log Aktivitas</span>
                    </a>

                    <!-- Divider -->
                    <div class="py-2">
                        <div class="border-t border-white/10"></div>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all">
                        <i class="fas fa-globe text-lg w-5"></i>
                        <span class="font-medium">Lihat Website</span>
                        <i class="fas fa-external-link-alt text-xs ml-auto"></i>
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="p-4 border-t border-white/10">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-3">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate">{{ session('user_name') }}</p>
                                <p class="text-xs text-blue-200">Administrator</p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-all flex items-center justify-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-gray-900">@yield('title')</h2>
                            <p class="text-sm text-gray-500 hidden sm:block">@yield('subtitle', 'Selamat datang di sistem buku tamu digital')</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notification Icon -->
                        <button id="notificationBtn" class="relative text-gray-600 hover:text-gray-900 focus:outline-none p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span id="notificationBadge" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-badge">0</span>
                        </button>

                        <!-- User Avatar -->
                        <button id="profileBtn" class="hidden md:flex items-center space-x-3 bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-2 transition-colors">
                            <div class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <div class="text-sm text-left">
                                <p class="font-semibold text-gray-900">{{ session('user_name') }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="px-4 lg:px-8 py-6 lg:py-8">
                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg fade-in">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4">
                                    <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg fade-in">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4">
                                    <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg fade-in">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-red-800 mb-2">Terdapat beberapa kesalahan:</p>
                                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-4">
                                    <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-4 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} SMK TI Airlangga. All rights reserved.</p>
                    <p class="mt-2 sm:mt-0">
                        Made with <i class="fas fa-heart text-red-500"></i> by IT Team
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4 modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full modal-content max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 rounded-t-2xl text-white text-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-3xl"></i>
                </div>
                <h3 id="profileName" class="text-2xl font-bold mb-1">{{ session('user_name') }}</h3>
                <p id="profileRole" class="text-blue-100">Loading...</p>
            </div>

            <!-- View Mode -->
            <div id="profileViewMode" class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-envelope text-gray-400"></i>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Email</p>
                            <p id="profileEmail" class="text-sm font-medium text-gray-900">Loading...</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Role</p>
                            <p id="profileRoleDisplay" class="text-sm font-medium text-gray-900">Loading...</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-clock text-gray-400"></i>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500">Last Login</p>
                            <p id="profileLastLogin" class="text-sm font-medium text-gray-900">-</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <button id="editProfileBtn" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Profile</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Edit Mode -->
            <div id="profileEditMode" class="p-6 hidden">
                <div id="profileEditAlert" class="hidden mb-4 p-3 rounded-lg"></div>

                <form id="profileEditForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i> Nama Lengkap
                        </label>
                        <input type="text" id="editNama" name="nama" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i> Email
                        </label>
                        <input type="email" id="editEmail" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-lock mr-1"></i> Ganti Password (Opsional)
                        </p>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Password Lama</label>
                                <input type="password" id="editPasswordLama" name="password_lama"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Password Baru</label>
                                <input type="password" id="editPasswordBaru" name="password_baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" id="editPasswordBaruConfirmation" name="password_baru_confirmation"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3 pt-4">
                        <button type="submit" id="saveProfileBtn"
                            class="flex-1 bg-primary-600 hover:bg-primary-700 text-white px-4 py-3 rounded-xl font-medium transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan</span>
                        </button>
                        <button type="button" id="cancelEditBtn"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <div class="px-6 pb-6">
                <button id="closeProfileModal" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div id="notificationModal" class="hidden fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4 modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full modal-content">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 rounded-t-2xl flex items-center justify-between text-white">
                <h3 class="text-xl font-bold flex items-center space-x-2">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                </h3>
                <button id="closeNotificationModal" class="hover:bg-white/10 rounded-lg p-2 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="max-h-[500px] overflow-y-auto">
                <div id="notificationList" class="divide-y divide-gray-200">
                    <!-- Notifications will be loaded here -->
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-bell-slash text-4xl mb-3"></i>
                        <p>Memuat notifikasi...</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-gray-50 rounded-b-2xl">
                <a href="{{ route('tamu.index') }}" class="block text-center text-primary-600 hover:text-primary-700 font-medium text-sm">
                    Lihat Semua Tamu <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Close sidebar on window resize if desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // Profile Modal
        const profileBtn = document.getElementById('profileBtn');
        const profileModal = document.getElementById('profileModal');
        const closeProfileModal = document.getElementById('closeProfileModal');
        const profileViewMode = document.getElementById('profileViewMode');
        const profileEditMode = document.getElementById('profileEditMode');
        const editProfileBtn = document.getElementById('editProfileBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const profileEditForm = document.getElementById('profileEditForm');
        const profileEditAlert = document.getElementById('profileEditAlert');

        let currentUserData = null;

        profileBtn?.addEventListener('click', () => {
            profileModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            loadProfileData();
        });

        closeProfileModal?.addEventListener('click', () => {
            profileModal.classList.add('hidden');
            document.body.style.overflow = '';
            showViewMode();
        });

        profileModal?.addEventListener('click', (e) => {
            if (e.target === profileModal) {
                profileModal.classList.add('hidden');
                document.body.style.overflow = '';
                showViewMode();
            }
        });

        editProfileBtn?.addEventListener('click', () => {
            showEditMode();
        });

        cancelEditBtn?.addEventListener('click', () => {
            showViewMode();
        });

        function showViewMode() {
            profileViewMode.classList.remove('hidden');
            profileEditMode.classList.add('hidden');
            profileEditAlert.classList.add('hidden');
        }

        function showEditMode() {
            profileViewMode.classList.add('hidden');
            profileEditMode.classList.remove('hidden');

            // Populate form with current data
            if (currentUserData) {
                document.getElementById('editNama').value = currentUserData.nama || '';
                document.getElementById('editEmail').value = currentUserData.email || '';
            }

            // Clear password fields
            document.getElementById('editPasswordLama').value = '';
            document.getElementById('editPasswordBaru').value = '';
            document.getElementById('editPasswordBaruConfirmation').value = '';
        }

        function loadProfileData() {
            fetch('/api/profile')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        currentUserData = result.data;

                        // Update view mode
                        document.getElementById('profileName').textContent = result.data.nama;
                        document.getElementById('profileRole').textContent = result.data.peran;
                        document.getElementById('profileEmail').textContent = result.data.email;
                        document.getElementById('profileRoleDisplay').textContent = result.data.peran;
                        document.getElementById('profileLastLogin').textContent = result.data.last_login || '-';
                    }
                })
                .catch(error => {
                    console.error('Error loading profile:', error);
                    showProfileAlert('Gagal memuat data profile', 'error');
                });
        }

        profileEditForm?.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(profileEditForm);
            const data = Object.fromEntries(formData.entries());

            const saveBtn = document.getElementById('saveProfileBtn');
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

            fetch('/api/profile/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showProfileAlert(result.message, 'success');

                    // Reload profile data
                    setTimeout(() => {
                        loadProfileData();
                        showViewMode();
                    }, 1500);
                } else {
                    let errorMsg = result.message;
                    if (result.errors) {
                        errorMsg += '<ul class="mt-2 list-disc list-inside text-sm">';
                        Object.values(result.errors).forEach(err => {
                            errorMsg += `<li>${err[0]}</li>`;
                        });
                        errorMsg += '</ul>';
                    }
                    showProfileAlert(errorMsg, 'error');
                }
            })
            .catch(error => {
                console.error('Error updating profile:', error);
                showProfileAlert('Terjadi kesalahan saat menyimpan', 'error');
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> <span>Simpan</span>';
            });
        });

        function showProfileAlert(message, type) {
            const alertDiv = profileEditAlert;
            alertDiv.classList.remove('hidden', 'bg-green-50', 'text-green-800', 'bg-red-50', 'text-red-800');

            if (type === 'success') {
                alertDiv.classList.add('bg-green-50', 'text-green-800');
                alertDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
            } else {
                alertDiv.classList.add('bg-red-50', 'text-red-800');
                alertDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
            }

            // Auto hide after 5 seconds
            setTimeout(() => {
                alertDiv.classList.add('hidden');
            }, 5000);
        }

        // Notification Modal
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationModal = document.getElementById('notificationModal');
        const closeNotificationModal = document.getElementById('closeNotificationModal');
        const notificationBadge = document.getElementById('notificationBadge');

        notificationBtn?.addEventListener('click', () => {
            notificationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            loadNotifications();
        });

        closeNotificationModal?.addEventListener('click', () => {
            notificationModal.classList.add('hidden');
            document.body.style.overflow = '';
        });

        notificationModal?.addEventListener('click', (e) => {
            if (e.target === notificationModal) {
                notificationModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Load Notifications
        function loadNotifications() {
            const notificationList = document.getElementById('notificationList');

            // Fetch notifications from backend
            fetch('/api/notifications')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        notificationList.innerHTML = `
                            <div class="p-8 text-center text-gray-500">
                                <i class="fas fa-bell-slash text-4xl mb-3"></i>
                                <p>Tidak ada notifikasi baru</p>
                            </div>
                        `;
                    } else {
                        notificationList.innerHTML = data.map(notif => `
                            <div class="p-4 hover:bg-gray-50 transition-colors ${notif.read ? 'bg-white' : 'bg-blue-50'}">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                        <i class="fas fa-${notif.icon}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 text-sm">${notif.title}</p>
                                        <p class="text-sm text-gray-600 mt-1">${notif.message}</p>
                                        <p class="text-xs text-gray-400 mt-2">
                                            <i class="fas fa-clock mr-1"></i>${notif.time}
                                        </p>
                                    </div>
                                    ${!notif.read ? '<span class="w-2 h-2 bg-blue-500 rounded-full"></span>' : ''}
                                </div>
                            </div>
                        `).join('');
                    }

                    // Update badge
                    const unreadCount = data.filter(n => !n.read).length;
                    notificationBadge.textContent = unreadCount;
                    notificationBadge.classList.toggle('hidden', unreadCount === 0);
                })
                .catch(error => {
                    notificationList.innerHTML = `
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-exclamation-triangle text-4xl mb-3 text-red-400"></i>
                            <p>Gagal memuat notifikasi</p>
                        </div>
                    `;
                });
        }

        // Load notification count on page load
        function updateNotificationBadge() {
            fetch('/api/notifications/count')
                .then(response => response.json())
                .then(data => {
                    notificationBadge.textContent = data.count;
                    notificationBadge.classList.toggle('hidden', data.count === 0);
                })
                .catch(error => console.error('Error loading notification count:', error));
        }

        // Update badge every 30 seconds
        updateNotificationBadge();
        setInterval(updateNotificationBadge, 30000);

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.fade-in').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Add active state to current page
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active', 'bg-white/20');
            }
        });

        // Escape key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                profileModal?.classList.add('hidden');
                notificationModal?.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
