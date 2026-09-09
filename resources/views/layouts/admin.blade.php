<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Smart Village Civic OS Desa Catur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-[#F4F6F5] font-sans antialiased text-[#111C2D] min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop with Blur -->
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-[#072C21]/60 backdrop-blur-xs z-40 lg:hidden"></div>

    <!-- Sidebar Navigation (Smart Village Civic OS) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static inset-y-0 left-0 z-50 w-[270px] bg-[#072C21] text-white flex flex-col transition-transform duration-250 ease-in-out lg:translate-x-0 border-r border-[#0F4C3A]/50 shadow-2xl lg:shadow-none">

        <!-- Sidebar Brand Header -->
        <div class="h-[76px] bg-[#052219] flex items-center px-5 gap-3 border-b border-white/10 shrink-0">
            @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                <img src="{{ asset('storage/' . $globalLogo) }}" alt="Desa Catur"
                    class="w-9 h-9 object-contain shrink-0 drop-shadow-xs">
            @elseif(file_exists(public_path('images/logo_catur.png')))
                <img src="{{ asset('images/logo_catur.png') }}" alt="Desa Catur"
                    class="w-9 h-9 object-contain shrink-0 drop-shadow-xs">
            @else
                <div
                    class="w-9 h-9 bg-[#0F4C3A] rounded-xl border border-white/20 flex items-center justify-center font-jakarta text-sm font-bold text-white shadow-xs">
                    DC
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5">
                    <h1 class="font-jakarta font-bold text-sm text-white leading-tight truncate">Pemerintah Desa</h1>
                </div>
                <span
                    class="inline-block text-[9.5px] font-bold text-[#86EFAC] tracking-wider uppercase opacity-90 truncate">
                    Civic OS • Desa Catur
                </span>
            </div>
        </div>

        <!-- Sidebar Menu Items -->
        <nav class="flex-1 px-3.5 py-5 space-y-1 overflow-y-auto custom-scrollbar">

            <!-- 1. DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span class="truncate">Dashboard</span>
                </div>
                @if(request()->routeIs('admin.dashboard'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <!-- SECTION: KELOLA KONTEN -->
            <div class="pt-4 pb-1">
                <p class="px-3.5 text-[10px] font-bold text-[#82BBA4] uppercase tracking-wider">Kelola Konten</p>
            </div>

            <a href="{{ route('admin.village-profile.edit') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.village-profile.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.village-profile.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A12.022 12.022 0 0012 9c-2.474 0-4.802.75-6.75 2.033V21h13.5z" />
                    </svg>
                    <span class="truncate">Profil Desa</span>
                </div>
                @if(request()->routeIs('admin.village-profile.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <a href="{{ route('admin.news.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.news.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.news.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                    </svg>
                    <span class="truncate">Berita & Pengumuman</span>
                </div>
                @if(request()->routeIs('admin.news.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <a href="{{ route('admin.officials.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.officials.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.officials.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span class="truncate">Perangkat Desa</span>
                </div>
                @if(request()->routeIs('admin.officials.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <a href="{{ route('admin.galleries.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.galleries.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.galleries.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span class="truncate">Galeri Foto</span>
                </div>
                @if(request()->routeIs('admin.galleries.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <!-- SECTION: PPK ORMAWA -->
            <div class="pt-4 pb-1">
                <p class="px-3.5 text-[10px] font-bold text-[#82BBA4] uppercase tracking-wider">PPK Ormawa</p>
            </div>

            <a href="{{ route('admin.ppko.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.ppko.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.ppko.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                    <span class="truncate">Admin PPKO</span>
                </div>
                @if(request()->routeIs('admin.ppko.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <!-- SECTION: LAYANAN PUBLIK -->
            <div class="pt-4 pb-1">
                <p class="px-3.5 text-[10px] font-bold text-[#82BBA4] uppercase tracking-wider">Layanan Publik</p>
            </div>

            <a href="{{ route('admin.letter-templates.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.letter-templates.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.letter-templates.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="truncate">Template Surat</span>
                </div>
                @if(request()->routeIs('admin.letter-templates.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <a href="{{ route('admin.letter-requests.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.letter-requests.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.letter-requests.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <span class="truncate">Permohonan Surat</span>
                </div>
                @if(request()->routeIs('admin.letter-requests.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <a href="{{ route('admin.complaints.index') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.complaints.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.complaints.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                    </svg>
                    <span class="truncate">Pengaduan Warga</span>
                </div>
                @if(request()->routeIs('admin.complaints.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>

            <!-- SECTION: PENGATURAN -->
            <div class="pt-4 pb-1">
                <p class="px-3.5 text-[10px] font-bold text-[#82BBA4] uppercase tracking-wider">Pengaturan</p>
            </div>

            <a href="{{ route('admin.settings.edit') }}"
                class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 {{ request()->routeIs('admin.settings.*') ? 'bg-[#0F4C3A] text-white shadow-xs' : 'text-[#BFC9C3] hover:bg-white/[0.07] hover:text-white' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-4 h-4 shrink-0 transition-colors {{ request()->routeIs('admin.settings.*') ? 'text-[#86EFAC]' : 'text-[#82BBA4] group-hover:text-white' }}"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="truncate">Pengaturan Website</span>
                </div>
                @if(request()->routeIs('admin.settings.*'))
                    <span class="w-1.5 h-3.5 rounded-full bg-[#22C55E]"></span>
                @endif
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-3.5 border-t border-white/10 bg-[#052219]">
            <a href="{{ route('home') }}" target="_blank"
                class="flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl bg-white/[0.08] hover:bg-white/[0.14] text-xs font-semibold text-white transition duration-150 group">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#22C55E] animate-pulse"></span>
                    <span>Portal Publik</span>
                </span>
                <svg class="w-3.5 h-3.5 text-[#86EFAC] group-hover:translate-x-0.5 transition-transform" fill="none"
                    stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Navigation Header (Smart Village Civic OS Top Bar) -->
        <header
            class="bg-white shadow-[0_1px_3px_rgba(15,76,58,0.04),0_1px_2px_rgba(0,0,0,0.02)] h-[72px] flex items-center justify-between px-4 sm:px-8 border-b border-[#E2E8F0] sticky top-0 z-30">

            <!-- Left: Mobile Menu Toggle & Page Title -->
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 text-slate-600 lg:hidden rounded-xl hover:bg-slate-100 active:scale-95 transition"
                    aria-label="Buka Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="min-w-0">
                    <h2 class="font-jakarta font-bold text-base sm:text-lg text-[#111C2D] truncate">
                        @yield('title', 'Dashboard')
                    </h2>
                    <p class="hidden sm:block text-[11px] font-medium text-[#64748B]">
                        Sistem Informasi Tata Kelola Pemerintahan Desa Catur
                    </p>
                </div>
            </div>

            <!-- Right: Action Pills, User Profile & Logout -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">

                <!-- Quick Search / Shortcut Indicator (Desktop) -->
                <div
                    class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#F4F6F5] border border-[#E2E8F0] text-xs text-[#64748B]">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span class="text-[11px] font-medium">Cari</span>
                    <kbd
                        class="text-[10px] font-semibold bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-500 font-mono">⌘K</kbd>
                </div>

                <!-- User Profile Pill -->
                <div class="flex items-center gap-2.5 pl-2 sm:pl-3 sm:border-l border-[#E2E8F0]">
                    <div
                        class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#0F4C3A] text-[#86EFAC] font-jakarta font-bold flex items-center justify-center text-xs shadow-xs ring-2 ring-[#0F4C3A]/10">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-left hidden sm:block">
                        <p class="text-xs font-bold text-[#111C2D] leading-tight">
                            {{ Auth::user()->name ?? 'Admin Desa' }}
                        </p>
                        <span
                            class="inline-flex items-center gap-1 text-[10px] font-bold text-[#15803D] bg-[#DCFCE7] px-1.5 py-0.2 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#15803D]"></span>
                            Operator
                        </span>
                    </div>
                </div>

                <!-- Modern Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Keluar dari Panel Admin"
                        class="inline-flex items-center gap-1.5 bg-[#FEF2F2] hover:bg-[#FEE2E2] text-[#DC2626] text-xs font-semibold px-3 py-2 rounded-xl border border-[#FCA5A5]/60 active:scale-95 transition shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">

            <!-- Flash Notification: Success -->
            @if(session('success'))
                <div class="mb-6 bg-[#ECFDF5] border border-[#A7F3D0] p-4 rounded-2xl shadow-xs flex items-center justify-between transition-all"
                    x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm font-semibold text-[#065F46]">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false"
                        class="text-[#065F46]/60 hover:text-[#065F46] text-sm p-1 rounded-lg">✕</button>
                </div>
            @endif

            <!-- Flash Notification: Error -->
            @if($errors->any())
                <div class="mb-6 bg-[#FEF2F2] border border-[#FECACA] p-4 rounded-2xl shadow-xs transition-all"
                    x-data="{ show: true }" x-show="show">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-[#991B1B]">Terdapat kesalahan pengisian formulir:
                            </p>
                            <ul class="list-disc list-inside text-xs text-[#B91C1C] space-y-1 mt-1 pl-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false"
                            class="text-[#991B1B]/60 hover:text-[#991B1B] text-sm p-1 rounded-lg">✕</button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>