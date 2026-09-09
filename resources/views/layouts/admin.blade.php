<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Web Profile Desa Catur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet CSS & JS for Admin Location Picker (FR-21) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#0d1c2f] text-white flex flex-col transition-transform duration-200 ease-in-out lg:translate-x-0 shadow-xl">
        
        <!-- Sidebar Brand -->
        <div class="h-20 bg-[#0a1422] flex items-center px-6 gap-3 border-b border-white/10">
            @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                <img src="{{ asset('storage/' . $globalLogo) }}" alt="Desa Catur" class="w-9 h-9 object-contain shrink-0">
            @elseif(file_exists(public_path('images/logo_catur.png')))
                <img src="{{ asset('images/logo_catur.png') }}" alt="Desa Catur" class="w-9 h-9 object-contain shrink-0">
            @else
                <div class="w-9 h-9 bg-[#0d631b] rounded-lg flex items-center justify-center font-serif text-lg font-bold text-white shadow-xs">
                    DC
                </div>
            @endif
            <div>
                <h1 class="font-serif font-bold text-base text-white leading-tight">Admin Pemdes</h1>
                <p class="text-xs text-amber-400 font-medium">Desa Catur Sambi Boyolali</p>
            </div>
        </div>

        <!-- Sidebar Menu Items -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📊 Dashboard
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelola Konten</p>
            </div>

            <a href="{{ route('admin.village-profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.village-profile.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📜 Profil Desa
            </a>

            <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.news.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📰 Berita & Pengumuman
            </a>

            <a href="{{ route('admin.officials.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.officials.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                🏛️ Perangkat Desa
            </a>


            <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.galleries.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                🖼️ Galeri Foto
            </a>

            <a href="{{ route('admin.locations.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.locations.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📍 Peta & Lokasi
            </a>

            <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.partners.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                🤝 Logo Program & Mitra
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">PPK Ormawa</p>
            </div>

            <a href="{{ route('admin.ppko.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.ppko.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                ⚙️ Admin PPKO
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Kependudukan</p>
            </div>

            <a href="{{ route('admin.families.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.families.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                👨‍👩‍👧‍👦 Data Keluarga (KK)
            </a>

            <a href="{{ route('admin.residents.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.residents.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                👥 Data Penduduk (NIK)
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Layanan Publik</p>
            </div>

            <a href="{{ route('admin.letter-templates.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.letter-templates.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📑 Template Surat
            </a>

            <a href="{{ route('admin.letter-requests.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.letter-requests.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📨 Permohonan Surat
            </a>

            <a href="{{ route('admin.complaints.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.complaints.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                📢 Pengaduan Warga
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan System</p>
            </div>

            <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.menus.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                🗂️ Menu Navigasi
            </a>

            <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#0d631b] text-white shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                ⚙️ Pengaturan Website
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/10 bg-[#0a1422]">
            <a href="{{ route('home') }}" target="_blank" class="block w-full text-center bg-white/10 hover:bg-white/20 text-xs font-medium text-amber-200 py-2 rounded-md transition">
                🌐 Lihat Website Publik ↗
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Top Navigation Header -->
        <header class="bg-white shadow-xs h-20 flex items-center justify-between px-4 sm:px-8 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-600 lg:hidden rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="font-serif font-bold text-lg text-gray-800">@yield('title', 'Dashboard')</h2>
            </div>

            <!-- User Info & Logout Button -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin Desa' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@desacatur.id' }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold px-3 py-2 rounded-lg border border-red-200 transition">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <main class="flex-1 p-4 sm:p-8 overflow-y-auto">
            
            <!-- Flash Notification -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded-r-lg shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-emerald-600 text-xl">✅</span>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded-r-lg shadow-xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-red-600 text-xl">⚠️</span>
                        <p class="text-sm font-bold text-red-800">Terdapat kesalahan pengisian form:</p>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-700 space-y-1 pl-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
