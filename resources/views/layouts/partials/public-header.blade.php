<!-- Main Navigation Header -->
<header class="sticky top-0 z-[99999]" :class="(isScrolled || mobileMenuOpen || mobileSearchOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
            ? 'text-[#20332A] transition-colors duration-700 ease-in-out' 
            : 'text-white transition-colors duration-700 ease-in-out'">

    <!-- Header Background Layer (Constrained to 80px Top Bar) -->
    <div class="absolute inset-x-0 top-0 h-20 pointer-events-none">
        @if($isHomePage)
            <!-- 1. Top Gradient Layer (Fades out softly and slowly when scrolling down) -->
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/30 to-transparent transition-opacity duration-700 ease-in-out pointer-events-none"
                :class="(isScrolled || mobileMenuOpen || mobileSearchOpen) ? 'opacity-0' : 'opacity-100'">
            </div>

            <!-- 2. Scrolled Glassmorphism Layer (Fades in softly and smoothly when scrolled down) -->
            <div class="absolute inset-0 bg-white/80 backdrop-blur-xl backdrop-saturate-150 border-b border-slate-200/80 shadow-[0_4px_20px_-2px_rgba(0,0,0,0.07),0_1px_3px_rgba(0,0,0,0.05)] transition-opacity ease-in-out pointer-events-none"
                :class="(mobileMenuOpen || mobileSearchOpen) 
                                                                                                         ? 'opacity-100 duration-200' 
                                                                                                         : (isScrolled 
                                                                                                             ? 'opacity-100 duration-700' 
                                                                                                             : 'opacity-0 duration-700 delay-100')">
            </div>
        @else
            <!-- Non-homepage glassmorphism navbar background with scroll shadow -->
            <div class="absolute inset-0 bg-white/80 backdrop-blur-xl backdrop-saturate-150 border-b border-slate-200/80 pointer-events-none transition-shadow duration-700 ease-in-out"
                :class="isScrolled ? 'shadow-[0_4px_20px_-2px_rgba(0,0,0,0.07),0_1px_3px_rgba(0,0,0,0.05)]' : 'shadow-none'">
            </div>
        @endif
    </div>

    <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-2 lg:gap-4">

            <!-- 1. FAR LEFT: BRAND LOGO TEXT (Pemerintah Desa Catur + Subtitle) -->
            <a href="{{ route('home') }}" class="hidden lg:flex items-center gap-3 shrink-0 group text-left">
                @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                    <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                        class="h-10 sm:h-11 w-auto object-contain shrink-0">
                @elseif(file_exists(public_path('images/logo_catur.png')))
                    <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                        class="h-10 sm:h-11 w-auto object-contain shrink-0">
                @endif
                <div>
                    <span
                        class="block font-serif text-base lg:text-lg xl:text-xl font-bold tracking-tight transition-colors duration-700 ease-in-out leading-tight"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29] group-hover:text-[#145C3B]' : 'text-white group-hover:text-white/90'">
                        {{ $globalVillageName ?? 'Pemerintah Desa Catur' }}
                    </span>
                    <span
                        class="block text-[10px] font-medium tracking-wider uppercase transition-colors duration-700 ease-in-out"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-white/80'">
                        Sambi, Boyolali, Jawa Tengah
                    </span>
                </div>
            </a>

            <!-- 2. CENTER: DESKTOP NAVIGATION LINKS (Beranda, Profil, Informasi, Layanan, Pojok Literasi, Perpustakaan, Kontak) -->
            <nav
                class="hidden lg:flex items-center justify-center space-x-1 xl:space-x-1.5 font-medium text-xs font-semibold mx-auto">

                <!-- Beranda -->
                <a href="{{ route('home') }}"
                    class="h-9 sm:h-10 px-3.5 inline-flex items-center rounded-lg transition-all duration-700 ease-in-out"
                    :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                       ? '{{ request()->routeIs('home') ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                       : '{{ request()->routeIs('home') ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                    <span>Beranda</span>
                </a>

                <!-- Profil Dropdown Button -->
                <div class="relative inline-block" @click.away="profileDropdown = false">
                    <button
                        @click="profileDropdown = !profileDropdown; infoDropdown = false; layananDropdown = false; literasiDropdown = false"
                        type="button"
                        class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                ? '{{ (request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                : '{{ (request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                        <span>Profil</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200"
                            :class="[profileDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.profile') || request()->routeIs('public.officials')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Box Profil -->
                    <div x-show="profileDropdown" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute left-0 mt-2 w-60 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">

                        <a href="{{ route('public.profile') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Profil Desa</span>
                        </a>

                        <a href="{{ route('public.officials') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9" />
                            </svg>
                            <span>Struktur Pemerintahan</span>
                        </a>
                    </div>
                </div>

                <!-- Informasi Dropdown Button -->
                <div class="relative inline-block" @click.away="infoDropdown = false">
                    <button
                        @click="infoDropdown = !infoDropdown; profileDropdown = false; layananDropdown = false; literasiDropdown = false"
                        type="button"
                        class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                ? '{{ (request()->routeIs('public.news*') || request()->routeIs('public.gallery')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                : '{{ (request()->routeIs('public.news*') || request()->routeIs('public.gallery')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                        <span>Informasi</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200"
                            :class="[infoDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.news*') || request()->routeIs('public.gallery')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Box Informasi -->
                    <div x-show="infoDropdown" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute left-0 mt-2 w-60 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">

                        <a href="{{ route('public.news.index') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                            </svg>
                            <span>Berita & Pengumuman</span>
                        </a>

                        <a href="{{ route('public.gallery') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Galeri</span>
                        </a>
                    </div>
                </div>

                <!-- Layanan Publik Dropdown Button -->
                <div class="relative inline-block" @click.away="layananDropdown = false">
                    <button
                        @click="layananDropdown = !layananDropdown; profileDropdown = false; infoDropdown = false; literasiDropdown = false"
                        type="button"
                        class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1 rounded-lg transition-all duration-700 ease-in-out focus:outline-none"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                ? '{{ (request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                                : '{{ (request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                        <span>Layanan</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200"
                            :class="[layananDropdown ? 'rotate-180' : '', ({{ $isHomePage ? 'isScrolled' : 'true' }}) ? ((request()->routeIs('public.services.*') || request()->routeIs('warga.letter.*') || request()->routeIs('warga.complaint.*')) ? 'text-[#0A3D29]' : 'text-[#6C7B72]') : 'text-white']"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Box Layanan Publik -->
                    <div x-show="layananDropdown" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute left-0 mt-2 w-72 rounded-md p-0 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">

                        <!-- 2. Surat Online Mandiri -->
                        <a href="{{ route('warga.letter.index') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <span class="block font-bold">Cetak Surat Mandiri</span>
                            </div>
                        </a>

                        <!-- 3. Pengaduan & Aspirasi Warga -->
                        <a href="{{ route('warga.complaint.index') }}"
                            class="flex items-center gap-3 w-full px-4 py-3 transition-colors duration-150 text-xs font-semibold group"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-black/[0.05] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-black/35 hover:text-white'">
                            <svg class="w-4 h-4 shrink-0 transition-colors duration-150"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29]' : 'text-[#D9B85C]'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                            </svg>
                            <div>
                                <span class="block font-bold">Laporan & Pengaduan</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Catur Cerdas Direct Link -->
                <a href="{{ route('public.ppko') }}"
                    class="h-9 sm:h-10 px-3.5 inline-flex items-center rounded-lg transition-all duration-700 ease-in-out"
                    :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                       ? '{{ request()->routeIs('public.ppko') ? 'text-[#0A3D29] font-extrabold text-sm hover:bg-[#EAF1E8]' : 'text-[#20332A] font-semibold hover:bg-[#EAF1E8] hover:text-[#0A3D29]' }}' 
                       : '{{ request()->routeIs('public.ppko') ? 'text-white font-extrabold text-sm drop-shadow-md hover:bg-white/20' : 'text-white/90 font-semibold hover:bg-white/20 hover:text-white' }}'">
                    <span>Catur Cerdas</span>
                </a>

                <!-- Perpustakaan Button -->
                <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}"
                    target="_blank" rel="noopener noreferrer"
                    class="h-9 sm:h-10 px-3.5 inline-flex items-center gap-1.5 rounded-lg transition-all duration-700 ease-in-out font-semibold"
                    :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] hover:bg-[#EAF1E8] hover:text-[#0A3D29]' : 'text-white/90 hover:bg-white/20 hover:text-white'">
                    <span>Perpustakaan</span>
                    <svg class="w-3 h-3 transition-colors duration-700 ease-in-out"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#D9B85C]' : 'text-[#F5E8C7]'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

            </nav>

            <!-- 3. FAR RIGHT GROUP: SEARCH & ADMIN LOGIN BUTTON -->
            <div
                class="hidden lg:flex items-center space-x-1.5 xl:space-x-2 shrink-0 font-medium text-xs font-semibold">

                <!-- SEARCH FIELD (Pill Shape) -->
                <div class="relative shrink-0" @click.away="searchOpen = false">
                    <form action="{{ url('/pencarian') }}" method="GET" @submit="searchOpen = false">
                        <div class="relative flex items-center">
                            <input type="text" name="q" x-model="searchQuery"
                                @input.debounce.300ms="fetchSuggestions()"
                                @focus="if(searchQuery.length >= 2) searchOpen = true"
                                @keydown.escape="searchOpen = false" placeholder="Cari informasi..."
                                aria-label="Cari informasi di Desa Catur"
                                class="h-9 w-36 lg:w-44 xl:w-48 pl-8 pr-7 rounded-xl text-xs font-medium border transition-all duration-700 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#0A3D29] focus:bg-white focus:text-[#20332A]"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) 
                                       ? 'bg-[#EAF1E8]/70 backdrop-blur-md text-[#20332A] placeholder-[#6C7B72] border border-[#DCE6DA]/80' 
                                       : 'bg-white/20 backdrop-blur-md text-white placeholder-white/70 border border-white/25 focus:placeholder-[#6C7B72]'">

                            <!-- Search Icon (Left) -->
                            <svg class="w-3.5 h-3.5 absolute left-3 pointer-events-none transition-colors duration-700 ease-in-out"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-white/80'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            <!-- Clear Button (Right) -->
                            <button type="button" x-show="searchQuery.length > 0"
                                @click="searchQuery = ''; searchResults = []; searchOpen = false"
                                class="absolute right-2 transition-colors duration-700 ease-in-out p-0.5 rounded-full"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72] hover:text-[#20332A]' : 'text-white/80 hover:text-white'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Live Suggestion Dropdown Panel -->
                    <div x-show="searchOpen && searchQuery.length >= 2"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-80 lg:w-96 rounded-md py-1.5 z-50 overflow-hidden transition-all duration-300 shadow-xl"
                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]' : 'bg-[#061C12]/95 backdrop-blur-2xl border border-white/20 text-white'">

                        <!-- Loading Skeleton State -->
                        <div x-show="searchLoading" aria-busy="true" class="p-2 space-y-1 divide-y divide-slate-100/60">
                            <x-skeleton.search-item />
                            <x-skeleton.search-item />
                            <x-skeleton.search-item />
                        </div>

                        <!-- No Results State -->
                        <div x-show="!searchLoading && searchResults.length === 0" class="p-4 text-center text-xs"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300'">
                            <p>Tidak ada hasil untuk "<span class="font-semibold"
                                    :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A]' : 'text-white'"
                                    x-text="searchQuery"></span>"</p>
                        </div>

                        <!-- Results List -->
                        <div x-show="!searchLoading && searchResults.length > 0"
                            class="max-h-80 overflow-y-auto divide-y"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'divide-slate-100' : 'divide-white/10'">
                            <template x-for="item in searchResults" :key="item.title">
                                <a :href="item.url"
                                    class="block px-4 py-2.5 w-full transition-colors text-left group"
                                    :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'hover:bg-black/[0.05]' : 'hover:bg-black/35'">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span
                                            class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29]"
                                            x-text="item.badge"></span>
                                        <span class="text-[10px] text-slate-300 font-light">/</span>
                                        <span class="text-[10px] font-light text-slate-400"
                                            x-text="item.category"></span>
                                    </div>
                                    <span class="block text-xs font-semibold transition line-clamp-1"
                                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#20332A] group-hover:text-[#0A3D29]' : 'text-white group-hover:text-[#D9B85C]'"
                                        x-text="item.title"></span>
                                    <span class="block text-[11px] font-light line-clamp-1 mt-0.5"
                                        :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#6C7B72]' : 'text-slate-300'"
                                        x-text="item.snippet"></span>
                                </a>
                            </template>
                        </div>

                        <!-- View All Results Footer Link -->
                        <div x-show="!searchLoading" class="pt-1 border-t text-center"
                            :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'border-slate-100' : 'border-white/10'">
                            <a :href="'{{ route('public.search') }}?q=' + encodeURIComponent(searchQuery)"
                                class="block py-2 px-4 w-full text-xs font-bold transition"
                                :class="({{ $isHomePage ? 'isScrolled' : 'true' }}) ? 'text-[#0A3D29] hover:text-[#145C3B] hover:bg-black/[0.05]' : 'text-[#D9B85C] hover:text-white hover:bg-black/35'">
                                Lihat semua hasil pencarian →
                            </a>
                        </div>
                    </div>
                </div>


            </div>

            <!-- MOBILE HEADER BRAND & ACTION BUTTONS -->
            <div class="flex items-center justify-between w-full lg:hidden">
                <a href="{{ route('home') }}" class="flex items-center gap-2 min-w-0 flex-1 mr-2">
                    @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                        <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                            class="h-9 w-auto object-contain shrink-0">
                    @elseif(file_exists(public_path('images/logo_catur.png')))
                        <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                            class="h-9 w-auto object-contain shrink-0">
                    @else
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-[#0A3D29] to-[#145C3B] text-white rounded-lg flex items-center justify-center font-serif text-base font-bold shadow-xs shrink-0">
                            DC
                        </div>
                    @endif
                    <span class="font-serif text-base font-bold transition-colors duration-700 ease-in-out truncate"
                        :class="(isScrolled || mobileMenuOpen || mobileSearchOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                              ? 'text-[#0A3D29]' 
                              : 'text-white'">
                        {{ $globalVillageName ?? 'Pemerintah Desa Catur' }}
                    </span>
                </a>

                <!-- Action Buttons: Search Button (Left of Hamburger) + Hamburger Menu Button -->
                <div class="flex items-center gap-1.5 shrink-0">
                    <!-- 1. Mobile Search Trigger Button -->
                    <button
                        @click.stop="mobileSearchOpen = !mobileSearchOpen; if(mobileSearchOpen) { mobileMenuOpen = false; $nextTick(() => { $refs.mobileHeaderSearchInput && $refs.mobileHeaderSearchInput.focus(); }); }"
                        type="button"
                        class="w-10 h-10 p-2 rounded-xl focus:outline-none flex items-center justify-center shrink-0 cursor-pointer transition-colors duration-300 ease-in-out"
                        :class="(isScrolled || mobileMenuOpen || mobileSearchOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                                ? (mobileSearchOpen ? 'text-[#0A3D29] bg-[#EAF1E8]' : 'text-[#0A3D29] hover:bg-black/5 active:bg-[#EAF1E8]') 
                                : (mobileSearchOpen ? 'text-[#0A3D29] bg-white' : 'text-white hover:bg-white/10 active:bg-white/20')"
                        aria-label="Buka Pencarian" title="Pencarian">
                        <!-- Search Icon (When Closed) -->
                        <svg x-show="!mobileSearchOpen" class="w-6 h-6 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <!-- Close 'X' Icon (When Opened) -->
                        <svg x-show="mobileSearchOpen" x-cloak
                            class="w-6 h-6 transition-transform duration-200 text-[#0A3D29]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- 2. Hamburger Menu Button -->
                    <button
                        @click.stop="mobileMenuOpen = !mobileMenuOpen; if(mobileMenuOpen) mobileSearchOpen = false;"
                        type="button"
                        class="w-10 h-10 p-2 rounded-xl focus:outline-none flex items-center justify-center shrink-0 cursor-pointer transition-colors duration-300 ease-in-out"
                        :class="(isScrolled || mobileMenuOpen || mobileSearchOpen || !{{ $isHomePage ? 'true' : 'false' }}) 
                                ? (mobileMenuOpen ? 'text-[#0A3D29] bg-slate-100 active:bg-slate-200' : 'text-[#0A3D29] hover:bg-black/5 active:bg-[#EAF1E8]') 
                                : (mobileMenuOpen ? 'text-[#0A3D29] bg-white active:bg-white/80' : 'text-white hover:bg-white/10 active:bg-white/20')"
                        aria-label="Buka Menu Mobile">
                        <!-- Hamburger Icon (When Closed) -->
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close 'X' Icon (When Opened) -->
                        <svg x-show="mobileMenuOpen" x-cloak
                            class="w-6 h-6 transition-transform duration-200 text-[#0A3D29]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Backdrop Scrim for Mobile Search (Same style as Mobile Menu) -->
    <div x-show="mobileSearchOpen" x-cloak x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="mobileSearchOpen = false"
        class="fixed inset-0 top-20 bg-black/30 backdrop-blur-xs z-40 lg:hidden" aria-hidden="true">
    </div>

    <!-- Mobile Search Dropdown Menu (Glassmorphism Frosted Glass Style matching Hamburger Menu) -->
    <div x-show="mobileSearchOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3" @click.away="mobileSearchOpen = false" @click.stop
        class="absolute top-full inset-x-0 z-50 lg:hidden bg-white/85 backdrop-blur-2xl backdrop-saturate-150 border-b border-x border-slate-200/80 rounded-b-2xl text-[#20332A] shadow-2xl shadow-slate-900/10 max-h-[calc(100dvh-5rem)] overflow-y-auto overflow-x-hidden p-4 sm:p-5 space-y-3">

        <!-- Search Input Form with Clean Minimalist Styling -->
        <form action="{{ url('/pencarian') }}" method="GET" @submit="mobileSearchOpen = false" class="relative">
            <div class="relative flex items-center">
                <input type="text" name="q" x-ref="mobileHeaderSearchInput" x-model="searchQuery"
                    @input.debounce.300ms="fetchSuggestions()" @keydown.escape="mobileSearchOpen = false"
                    placeholder="Ketik kata kunci pencarian..." aria-label="Cari informasi di Desa Catur"
                    class="w-full h-11 pl-10 pr-20 rounded-xl text-xs sm:text-sm font-normal bg-white/70 hover:bg-white/90 focus:bg-white/95 backdrop-blur-xl text-slate-900 placeholder:text-slate-400 border border-slate-200/80 focus:border-[#0A3D29] focus:outline-none focus:ring-1 focus:ring-[#0A3D29] shadow-inner transition-all">

                <!-- Search Icon (Left) -->
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>

                <div class="absolute right-1 flex items-center gap-1">
                    <!-- Clear Button -->
                    <button type="button" x-show="searchQuery.length > 0"
                        @click="searchQuery = ''; searchResults = []; $refs.mobileHeaderSearchInput.focus()"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 transition-colors"
                        aria-label="Hapus kata kunci">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <!-- Submit Search Button -->
                    <button type="submit"
                        class="h-8 px-3 rounded-lg bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs font-medium transition-colors">
                        Cari
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Content -->
        <div>
            <!-- Loading Skeleton State -->
            <div x-show="searchLoading" aria-busy="true" class="py-2 space-y-1 divide-y divide-slate-200/50">
                <x-skeleton.search-item />
                <x-skeleton.search-item />
                <x-skeleton.search-item />
            </div>

            <!-- Empty State -->
            <div x-show="!searchLoading && searchQuery.length >= 2 && searchResults.length === 0"
                class="py-6 text-center text-xs space-y-1">
                <p class="font-medium text-slate-800">Tidak ada hasil ditemukan</p>
                <p class="font-light text-slate-400">Tidak ditemukan data yang cocok untuk “<span
                        class="font-normal text-slate-600" x-text="searchQuery"></span>”.</p>
            </div>

            <!-- Live Results List -->
            <div x-show="!searchLoading && searchResults.length > 0" class="space-y-3">
                <div class="flex items-center justify-between text-[11px] px-0.5">
                    <span class="font-light text-slate-400">Hasil pencarian</span>
                    <span class="font-medium text-slate-500" x-text="searchResults.length + ' item'"></span>
                </div>

                <div class="divide-y divide-slate-200/50 max-h-72 overflow-y-auto pr-1">
                    <template x-for="item in searchResults" :key="item.url + item.title">
                        <a :href="item.url" @click="mobileSearchOpen = false"
                            class="block py-2.5 px-2 rounded-xl hover:bg-white/70 active:bg-[#EAF1E8]/80 transition-colors text-left group">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-[#0A3D29]"
                                    x-text="item.badge"></span>
                                <span class="text-[10px] text-slate-300 font-light">/</span>
                                <span class="text-[10px] font-light text-slate-400" x-text="item.category"></span>
                            </div>
                            <span
                                class="block text-xs font-semibold text-slate-900 group-hover:text-[#0A3D29] line-clamp-1 transition-colors"
                                x-text="item.title"></span>
                            <span
                                class="block text-[11px] font-light text-slate-500 line-clamp-2 mt-0.5 leading-relaxed"
                                x-text="item.snippet"></span>
                        </a>
                    </template>
                </div>

                <!-- Full Results Link -->
                <div class="pt-1">
                    <a :href="'{{ url('/pencarian') }}?q=' + encodeURIComponent(searchQuery)"
                        @click="mobileSearchOpen = false"
                        class="block w-full py-2 px-3 text-xs font-medium text-center text-[#0A3D29] hover:text-white hover:bg-[#0A3D29] border border-[#0A3D29]/30 rounded-xl transition-colors">
                        Lihat semua hasil pencarian →
                    </a>
                </div>
            </div>

            <!-- Subtle Empty Prompt When < 2 characters -->
            <div x-show="searchQuery.length < 2" class="py-4 text-center">
                <p class="text-xs font-light text-slate-400">Cari informasi atau berita di website</p>
            </div>
        </div>

    </div>

    <!-- Backdrop Scrim for Mobile Drawer -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
        class="fixed inset-0 top-20 bg-black/30 backdrop-blur-xs z-40 lg:hidden" aria-hidden="true">
    </div>

    <!-- Mobile Drawer Navigation Overlay (Glassmorphism Frosted Glass Style) -->
    <div x-show="mobileMenuOpen" x-cloak x-data="{ activeSection: null }"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-3"
        @click.away="mobileMenuOpen = false" @click.stop
        class="absolute top-full inset-x-0 z-50 lg:hidden bg-white/85 backdrop-blur-2xl backdrop-saturate-150 border-b border-x border-slate-200/80 rounded-b-2xl text-[#20332A] shadow-2xl shadow-slate-900/10 max-h-[calc(100dvh-5rem)] overflow-y-auto overflow-x-hidden divide-y divide-slate-200/50">

        <!-- 1. Beranda (Direct Clean Link) -->
        <div class="nav-cascade-1">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors {{ request()->routeIs('home') ? 'bg-black/[0.06] text-[#0A3D29] font-bold' : 'text-slate-800 active:bg-black/[0.08]' }}">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 001 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </div>
            </a>
        </div>

        <!-- 2. Profil Desa (Collapsible Category) -->
        <div class="nav-cascade-2">
            <button type="button" @click="activeSection = (activeSection === 'profil' ? null : 'profil')"
                class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                :class="activeSection === 'profil' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9" />
                    </svg>
                    <span>Profil Desa</span>
                </div>
                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    :class="activeSection === 'profil' ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="activeSection === 'profil'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                <a href="{{ route('public.profile') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.profile') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Tentang Desa Catur</span>
                </a>
                <a href="{{ route('public.officials') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.officials') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Struktur Perangkat Desa</span>
                </a>
            </div>
        </div>

        <!-- 3. Informasi Publik (Collapsible Category) -->
        <div class="nav-cascade-3">
            <button type="button" @click="activeSection = (activeSection === 'informasi' ? null : 'informasi')"
                class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                :class="activeSection === 'informasi' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                    </svg>
                    <span>Informasi Publik</span>
                </div>
                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    :class="activeSection === 'informasi' ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="activeSection === 'informasi'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                <a href="{{ route('public.news.index') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.news*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Berita & Pengumuman</span>
                </a>
                <a href="{{ route('public.gallery') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('public.gallery') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Galeri</span>
                </a>
            </div>
        </div>

        <!-- 4. Layanan Warga (Collapsible Category) -->
        <div class="nav-cascade-4">
            <button type="button" @click="activeSection = (activeSection === 'layanan' ? null : 'layanan')"
                class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold transition-colors text-slate-800 active:bg-black/[0.08]"
                :class="activeSection === 'layanan' ? 'bg-black/[0.04] text-[#0A3D29]' : ''">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Layanan Warga</span>
                </div>
                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    :class="activeSection === 'layanan' ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="activeSection === 'layanan'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-slate-900/[0.03] divide-y divide-slate-200/40 border-t border-slate-200/50">
                <a href="{{ route('warga.letter.index') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('warga.letter*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Cetak Surat Mandiri</span>
                </a>
                <a href="{{ route('warga.complaint.index') }}" @click="mobileMenuOpen = false"
                    class="w-full flex items-center pl-12 pr-5 py-3 text-xs font-medium transition-colors {{ request()->routeIs('warga.complaint*') ? 'bg-black/[0.07] text-[#0A3D29] font-bold' : 'text-slate-700 active:bg-black/[0.08]' }}">
                    <span>Pengaduan & Aspirasi Warga</span>
                </a>
            </div>
        </div>

        <!-- 5. Catur Cerdas (Direct Standalone Link) -->
        <div class="nav-cascade-5">
            <a href="{{ route('public.ppko') }}" @click="mobileMenuOpen = false"
                class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors {{ request()->routeIs('public.ppko') ? 'bg-black/[0.06] text-[#0A3D29] font-bold' : 'text-slate-800 active:bg-black/[0.08]' }}">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span>Catur Cerdas</span>
                </div>
            </a>
        </div>

        <!-- 6. Perpustakaan Digital (Direct Standalone Link) -->
        <div class="nav-cascade-6">
            <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank"
                rel="noopener noreferrer" @click="mobileMenuOpen = false"
                class="w-full flex items-center justify-between px-5 py-3.5 font-semibold text-sm transition-colors text-slate-800 active:bg-black/[0.08]">
                <div class="flex items-center gap-3.5">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Perpustakaan Digital Remen Maos</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
            </a>
        </div>

    </div>
</header>
