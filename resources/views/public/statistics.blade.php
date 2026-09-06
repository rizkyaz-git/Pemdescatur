@extends('layouts.public')

@section('title', 'Statistik & Infografis Desa Catur – Sambi, Boyolali')

@section('meta_description', 'Statistik dan data infografis Desa Catur: data demografi, APBDes, kesehatan, pendidikan, infrastruktur, dan pembagian wilayah pedukuhan.')

@section('push_styles')
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

<style>
    [id] { scroll-margin-top: 100px; }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        display: inline-block;
        vertical-align: middle;
    }

    /* ─── Entrance Animations ─── */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.8s cubic-bezier(0.2, 0, 0, 1), transform 0.8s cubic-bezier(0.2, 0, 0, 1);
    }
    
    .animate-on-scroll.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Stagger Delays */
    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
    .delay-300 { transition-delay: 300ms; }
    .delay-400 { transition-delay: 400ms; }
    .delay-500 { transition-delay: 500ms; }

    /* Card Hover Effects */
    .hover-card-effect {
        transition: transform 0.3s cubic-bezier(0.2, 0, 0, 1), box-shadow 0.3s cubic-bezier(0.2, 0, 0, 1);
    }
    
    .hover-card-effect:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(15, 61, 46, 0.08);
    }

    /* Chart Interactive States */
    .chart-container {
        transition: transform 0.8s cubic-bezier(0.2, 0, 0, 1), filter 0.8s cubic-bezier(0.2, 0, 0, 1);
    }
    .chart-container.chart-active {
        transform: scale(1.03);
        filter: drop-shadow(0 10px 25px rgba(15, 61, 46, 0.12));
        z-index: 10;
    }

    /* Progress bar animation */
    .progress-bar { transition: width 1.2s cubic-bezier(0.16, 1, 0.3, 1); }

    /* Sticky Sidebar Nav Scrollbar Hide */
    #stat-sidebar-nav { scrollbar-width: none; }
    #stat-sidebar-nav::-webkit-scrollbar { display: none; }
</style>
@endpush

@section('content')

{{-- =========================================================== --}}
{{--  HERO HEADER (MINIMALIST)                                   --}}
{{-- =========================================================== --}}
<section class="bg-[#F7F8F2] pt-6 pb-2 sm:pt-8 sm:pb-3">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-slate-200/80 pb-3.5">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[#20332A] tracking-tight">
                    Statistik Desa Catur
                </h1>
            </div>
            <div class="text-xs text-[#6C7B72] shrink-0 font-medium">
                <span>Diperbarui pada <span class="font-bold text-[#20332A]">{{ $profile && $profile->updated_at ? \Illuminate\Support\Carbon::parse($profile->updated_at)->translatedFormat('d F Y') : \Illuminate\Support\Carbon::now()->translatedFormat('d F Y') }}</span> oleh Admin</span>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================== --}}
{{--  STICKY ANCHOR NAV + MAIN CONTENT LAYOUT                     --}}
{{-- =========================================================== --}}
<div class="bg-[#F7F8F2] py-8 sm:py-10">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8 lg:gap-10 relative">

            {{-- ── SIDEBAR ANCHOR NAV (desktop only) ── --}}
            <aside class="hidden xl:block w-56 shrink-0">
                <nav id="stat-sidebar-nav" class="sticky top-24 space-y-1.5 p-2 bg-white rounded-2xl border border-slate-200/80 shadow-2xs"
                     x-data="{ active: 'demografi' }">
                    @php
                    $navItems = [
                        ['id' => 'demografi',     'label' => 'Demografi Penduduk',   'icon' => 'group'],
                        ['id' => 'kesehatan',     'label' => 'Kesehatan & Pend.',    'icon' => 'favorite'],
                        ['id' => 'ekonomi',       'label' => 'Ekonomi & Keuangan',   'icon' => 'payments'],
                        ['id' => 'infrastruktur', 'label' => 'Infrastruktur',        'icon' => 'domain'],
                        ['id' => 'pemerintahan',  'label' => 'Pemerintahan',         'icon' => 'account_balance'],
                    ];
                    @endphp
                    @foreach($navItems as $item)
                    <a href="#{{ $item['id'] }}"
                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200"
                       :class="active === '{{ $item['id'] }}' ? 'bg-[#0A3D29] text-white shadow-xs' : 'text-[#4B5851] hover:bg-[#EAF1E8] hover:text-[#0A3D29]'"
                       @click="active = '{{ $item['id'] }}'"
                       @scroll-active.window="if ($event.detail === '{{ $item['id'] }}') active = '{{ $item['id'] }}'">
                        <span class="material-symbols-outlined text-base">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                    @endforeach
                </nav>
            </aside>

            {{-- ── MAIN CONTENT ── --}}
            <div class="flex-1 min-w-0 space-y-6 sm:space-y-8">

                {{-- ======================================================= --}}
                {{-- RINGKASAN INDIKATOR UTAMA (UNIFIED CARD)                --}}
                {{-- ======================================================= --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">analytics</span>
                            Ringkasan Indikator Utama Desa Catur
                        </h2>
                        <span class="text-[11px] text-[#6C7B72] font-semibold">Data Pokok Terpadu</span>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        {{-- 1. Kesehatan --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-3.5 border border-slate-200/60 hover:bg-[#EAF1E8]/50 transition-colors">
                            <div class="flex items-center gap-2 text-[#0A3D29] font-bold text-xs mb-2">
                                <span class="material-symbols-outlined text-base">medical_services</span>
                                <span>Kesehatan</span>
                            </div>
                            <div class="space-y-1 text-xs text-[#20332A]">
                                <div class="flex justify-between"><span>Puskesmas & Polindes</span><strong class="text-[#0A3D29]">2 Unit</strong></div>
                                <div class="flex justify-between"><span>Posyandu</span><strong class="text-[#0A3D29]">5 Pos</strong></div>
                                <div class="flex justify-between"><span>Bidan Desa</span><strong class="text-[#0A3D29]">1 Orang</strong></div>
                            </div>
                        </div>

                        {{-- 2. Pendidikan --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-3.5 border border-slate-200/60 hover:bg-[#EAF1E8]/50 transition-colors">
                            <div class="flex items-center gap-2 text-[#0A3D29] font-bold text-xs mb-2">
                                <span class="material-symbols-outlined text-base">school</span>
                                <span>Pendidikan</span>
                            </div>
                            <div class="space-y-1 text-xs text-[#20332A]">
                                <div class="flex justify-between"><span>Sekolah (PAUD-SMK)</span><strong class="text-[#0A3D29]">7 Unit</strong></div>
                                <div class="flex justify-between"><span>Total Siswa</span><strong class="text-[#0A3D29]">1.020 Siswa</strong></div>
                                <div class="flex justify-between"><span>Tenaga Pengajar</span><strong class="text-[#0A3D29]">62 Guru</strong></div>
                            </div>
                        </div>

                        {{-- 3. Ekonomi --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-3.5 border border-slate-200/60 hover:bg-[#EAF1E8]/50 transition-colors">
                            <div class="flex items-center gap-2 text-[#0A3D29] font-bold text-xs mb-2">
                                <span class="material-symbols-outlined text-base">storefront</span>
                                <span>Sarana Ekonomi</span>
                            </div>
                            <div class="space-y-1 text-xs text-[#20332A]">
                                <div class="flex justify-between"><span>Toko & Warung</span><strong class="text-[#0A3D29]">38 Unit</strong></div>
                                <div class="flex justify-between"><span>Koperasi Desa</span><strong class="text-[#0A3D29]">2 Unit</strong></div>
                                <div class="flex justify-between"><span>Pasar & Lumbung</span><strong class="text-[#0A3D29]">2 Unit</strong></div>
                            </div>
                        </div>

                        {{-- 4. Infrastruktur --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-3.5 border border-slate-200/60 hover:bg-[#EAF1E8]/50 transition-colors">
                            <div class="flex items-center gap-2 text-[#0A3D29] font-bold text-xs mb-2">
                                <span class="material-symbols-outlined text-base">domain</span>
                                <span>Infrastruktur</span>
                            </div>
                            <div class="space-y-1 text-xs text-[#20332A]">
                                <div class="flex justify-between"><span>Panjang Jalan Total</span><strong class="text-[#0A3D29]">15.2 km</strong></div>
                                <div class="flex justify-between"><span>Jalan Aspal Baik</span><strong class="text-[#0A3D29]">6.6 km</strong></div>
                                <div class="flex justify-between"><span>Jembatan Desa</span><strong class="text-[#0A3D29]">8 Unit</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ======================================================= --}}
                {{-- 1. DEMOGRAFI PENDUDUK (UNIFIED CARD)                    --}}
                {{-- ======================================================= --}}
                <section id="demografi" class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4 animate-on-scroll is-visible">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">group</span>
                            Demografi Penduduk
                        </h3>
                        <span class="text-xs text-[#6C7B72] font-medium hidden sm:inline">Mata pencaharian, usia & populasi ternak</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Mata Pencaharian Penduduk</h4>
                            <div class="h-48 w-full relative chart-container">
                                <canvas id="jobChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Penduduk per Kelompok Usia</h4>
                            <div class="h-48 w-full relative chart-container">
                                <canvas id="ageChart"></canvas>
                            </div>
                        </div>

                        <div class="md:col-span-2 bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Populasi Ternak Desa</h4>
                            <div class="h-40 w-full relative chart-container">
                                <canvas id="livestockChart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ======================================================= --}}
                {{-- 2. KESEHATAN & PENDIDIKAN (UNIFIED CARD)                --}}
                {{-- ======================================================= --}}
                <section id="kesehatan" class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4 animate-on-scroll is-visible">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">favorite</span>
                            Kesehatan & Keluarga Berencana
                        </h3>
                        <span class="text-xs text-[#6C7B72] font-medium hidden sm:inline">Metode kontrasepsi & akseptor KB</span>
                    </div>

                    <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                        <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Akseptor KB per Metode</h4>
                        <div class="h-48 w-full relative flex items-center justify-center chart-container">
                            <canvas id="kbChart"></canvas>
                        </div>
                    </div>
                </section>

                {{-- ======================================================= --}}
                {{-- 3. EKONOMI & KEUANGAN DESA (UNIFIED CARD)               --}}
                {{-- ======================================================= --}}
                <section id="ekonomi" class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4 animate-on-scroll is-visible">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">payments</span>
                            Ekonomi & Keuangan Desa
                        </h3>
                        <span class="text-xs text-[#6C7B72] font-medium hidden sm:inline">Realisasi APBDes Pendapatan vs Belanja</span>
                    </div>

                    <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                        <h4 class="font-serif text-xs font-bold text-[#20332A] mb-2">Tren APBDes Desa Catur (dalam Juta Rupiah)</h4>
                        <div class="h-52 w-full relative chart-container">
                            <canvas id="apbdesChart"></canvas>
                        </div>
                    </div>
                </section>

                {{-- ======================================================= --}}
                {{-- 4. INFRASTRUKTUR (UNIFIED CARD)                         --}}
                {{-- ======================================================= --}}
                <section id="infrastruktur" class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4 animate-on-scroll is-visible">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">domain</span>
                            Infrastruktur & Transportasi
                        </h3>
                        <span class="text-xs text-[#6C7B72] font-medium hidden sm:inline">Kondisi jalan desa & sarana transportasi</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 pt-1">
                        {{-- Kondisi Jalan Stacked Bar (Sisi Kiri) --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Kondisi Panjang Jalan Desa (km)</h4>
                            <div class="h-56 w-full relative chart-container">
                                <canvas id="roadConditionChart"></canvas>
                            </div>
                        </div>

                        {{-- Transportasi & Ringkasan Jalan (Sisi Kanan) --}}
                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60 space-y-4 flex flex-col justify-between">
                            <div>
                                <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Sarana Transportasi & Jembatan</h4>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <div class="bg-white p-3 rounded-xl border border-slate-200/60 transition-colors hover:border-[#0A3D29]/30">
                                        <span class="block text-[11px] text-[#6C7B72] font-semibold">Mobil Pribadi</span>
                                        <span class="block text-sm font-extrabold text-[#0A3D29] mt-0.5">124 Unit</span>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-200/60 transition-colors hover:border-[#0A3D29]/30">
                                        <span class="block text-[11px] text-[#6C7B72] font-semibold">Sepeda Motor</span>
                                        <span class="block text-sm font-extrabold text-[#0A3D29] mt-0.5">482 Unit</span>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-200/60 transition-colors hover:border-[#0A3D29]/30">
                                        <span class="block text-[11px] text-[#6C7B72] font-semibold">Sepeda</span>
                                        <span class="block text-sm font-extrabold text-[#0A3D29] mt-0.5">156 Unit</span>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-200/60 transition-colors hover:border-[#0A3D29]/30">
                                        <span class="block text-[11px] text-[#6C7B72] font-semibold">Jembatan Desa</span>
                                        <span class="block text-sm font-extrabold text-[#0A3D29] mt-0.5">8 Unit (Baik)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-[#0A3D29] text-white p-3.5 rounded-xl border border-white/10 shadow-2xs">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-200">Aspal: <strong class="text-white">6.6 km</strong></span>
                                    <span class="text-slate-200">Diperkeras: <strong class="text-white">4.4 km</strong></span>
                                    <span class="text-slate-200">Tanah: <strong class="text-white">4.2 km</strong></span>
                                </div>
                                <div class="pt-2 mt-2 border-t border-white/15 flex justify-between items-center text-xs">
                                    <span class="font-semibold text-slate-200">Total Panjang Jalan:</span>
                                    <span class="font-bold text-[#80C9A0] text-sm">15.2 km</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ======================================================= --}}
                {{-- 5. PEMERINTAHAN & PELAYANAN PUBLIK (UNIFIED CARD)       --}}
                {{-- ======================================================= --}}
                <section id="pemerintahan" class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs space-y-4 animate-on-scroll is-visible">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="font-serif text-base sm:text-lg font-bold text-[#20332A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0A3D29]">account_balance</span>
                            Pemerintahan & Pelayanan Publik
                        </h3>
                        <span class="text-xs text-[#6C7B72] font-medium hidden sm:inline">Administrasi & tempat ibadah</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 pt-1">
                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Pelayanan Publik per Tahun</h4>
                            <div class="h-48 w-full relative chart-container">
                                <canvas id="publicServiceChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-[#F8F9FA] rounded-xl p-4 border border-slate-200/60">
                            <h4 class="font-serif text-xs font-bold text-[#20332A] mb-3">Persebaran Tempat Ibadah</h4>
                            <div class="h-48 w-full relative flex items-center justify-center chart-container">
                                <canvas id="religionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

            </div>{{-- end main content --}}





            </div>{{-- end main content --}}
        </div>{{-- end flex wrapper --}}
    </div>{{-- end container --}}
</div>{{-- end bg wrapper --}}

@endsection

@push('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // ─── Scroll Intersection Observer for animations ───
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.08
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach((el) => {
        observer.observe(el);
    });

    // ─── Chart Active Observer ───
    const chartObserverOptions = {
        root: null,
        rootMargin: '-15% 0px -15% 0px',
        threshold: 0
    };

    const chartObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('chart-active');
            } else {
                entry.target.classList.remove('chart-active');
            }
        });
    }, chartObserverOptions);

    document.querySelectorAll('.chart-container').forEach((el) => {
        chartObserver.observe(el);
    });

    // ─── ScrollSpy Observer for Sidebar Nav ───
    const sections = document.querySelectorAll('section[id]');
    const scrollSpy = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                window.dispatchEvent(new CustomEvent('scroll-active', { detail: entry.target.id }));
            }
        });
    }, { threshold: 0.3 });
    sections.forEach(s => scrollSpy.observe(s));

    // ─── Chart.js Signature Font Default ('Inter') ───
    Chart.defaults.font.family = "'Inter', -apple-system, sans-serif";
    Chart.defaults.color = "#6C7B72";
    
    const commonHoverOptions = {
        mode: 'index',
        intersect: false,
    };
    const commonAnimationOptions = {
        duration: 1000,
        easing: 'easeOutQuart'
    };

    // 1. Mata Pencaharian Bar Chart
    const jobCanvas = document.getElementById('jobChart');
    if (jobCanvas) {
        @php
        $mataCatObj = isset($categories['demografi']) ? $categories['demografi']->firstWhere('key', 'mata_pencaharian') : null;
        $jobLabels = $mataCatObj && $mataCatObj->stats->count() ? $mataCatObj->stats->pluck('label') : ['Petani', 'Buruh Tani', 'Buruh Swasta', 'Pegawai Negeri', 'Pedagang', 'Peternak', 'Pengrajin', 'Lainnya'];
        $jobData   = $mataCatObj && $mataCatObj->stats->count() ? $mataCatObj->stats->pluck('value') : [600, 320, 180, 50, 40, 20, 10, 80];
        @endphp
        new Chart(jobCanvas, {
            type: 'bar',
            data: {
                labels: @json($jobLabels),
                datasets: [{
                    label: 'Jumlah Orang',
                    data: @json($jobData),
                    backgroundColor: ['#0A3D29', '#2E7D52', '#d4a373', '#7d562d', '#66BB6A', '#A5D6A7', '#4361EE', '#2f55fb'],
                    borderWidth: 0,
                    borderRadius: 4,
                    hoverBackgroundColor: '#00261a'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: '#e1e3e2' } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Populasi Ternak Bar Chart
    const livestockCanvas = document.getElementById('livestockChart');
    if (livestockCanvas) {
        @php
        $ternakCatObj = isset($categories['demografi']) ? $categories['demografi']->firstWhere('key', 'ternak') : null;
        $livestockLabels = $ternakCatObj && $ternakCatObj->stats->count() ? $ternakCatObj->stats->pluck('label') : ['Ayam Potong', 'Kambing', 'Sapi', 'Bebek/Itik', 'Ikan (Kolam)'];
        $livestockData   = $ternakCatObj && $ternakCatObj->stats->count() ? $ternakCatObj->stats->pluck('value') : [12000, 400, 150, 300, 8000];
        @endphp
        new Chart(livestockCanvas, {
            type: 'bar',
            data: {
                labels: @json($livestockLabels),
                datasets: [{
                    label: 'Jumlah Ekor',
                    data: @json($livestockData),
                    backgroundColor: ['#0A3D29', '#66BB6A', '#2E7D52', '#d4a373', '#A5D6A7'],
                    borderWidth: 0,
                    borderRadius: 4,
                    hoverBackgroundColor: '#00261a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: '#e1e3e2' } }
                }
            }
        });
    }

    // 3. Penduduk per Usia Chart
    const ageCanvas = document.getElementById('ageChart');
    if (ageCanvas) {
        @php
        $usiaCatObj = isset($categories['demografi']) ? $categories['demografi']->firstWhere('key', 'kelompok_usia') : null;
        $ageLabels = $usiaCatObj && $usiaCatObj->stats->count() ? $usiaCatObj->stats->pluck('label') : ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60+'];
        $ageData   = $usiaCatObj && $usiaCatObj->stats->count() ? $usiaCatObj->stats->pluck('value') : [150, 160, 180, 185, 190, 200, 195, 180, 150, 120, 100, 90, 180];
        @endphp
        new Chart(ageCanvas, {
            type: 'bar',
            data: {
                labels: @json($ageLabels),
                datasets: [{
                    label: 'Jumlah Orang',
                    data: @json($ageData),
                    backgroundColor: '#0A3D29',
                    borderRadius: 4,
                    hoverBackgroundColor: '#00261a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: '#e1e3e2' } }
                }
            }
        });
    }

    // 4. Akseptor KB Doughnut Chart
    const kbCanvas = document.getElementById('kbChart');
    if (kbCanvas) {
        @php
        $kbCatObj = isset($categories['kesehatan']) ? $categories['kesehatan']->firstWhere('key', 'kb_akseptor') : null;
        $kbLabels = $kbCatObj && $kbCatObj->stats->count() ? $kbCatObj->stats->pluck('label') : ['Suntik', 'Pil', 'IUD', 'Implant', 'Lainnya'];
        $kbData   = $kbCatObj && $kbCatObj->stats->count() ? $kbCatObj->stats->pluck('value') : [45, 30, 15, 5, 5];
        @endphp
        new Chart(kbCanvas, {
            type: 'doughnut',
            data: {
                labels: @json($kbLabels),
                datasets: [{
                    data: @json($kbData),
                    backgroundColor: ['#E85D04', '#F4A261', '#D62246', '#0A3D29', '#4361EE'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                animation: commonAnimationOptions,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // 5. APBDes Line Chart
    const apbdesCanvas = document.getElementById('apbdesChart');
    if (apbdesCanvas) {
        @php
        $apYears = count($apbdesYears) > 0 ? $apbdesYears : ['2013', '2014', '2015', '2016', '2017', '2018'];
        $apPend  = count($apbdesPendapatan) > 0 ? $apbdesPendapatan : [700, 800, 1000, 1200, 1400, 1600];
        $apBel   = count($apbdesBelanja) > 0 ? $apbdesBelanja : [680, 790, 1050, 1180, 1380, 1620];
        @endphp
        new Chart(apbdesCanvas, {
            type: 'line',
            data: {
                labels: @json($apYears),
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: @json($apPend),
                        borderColor: '#0A3D29',
                        backgroundColor: 'rgba(10, 61, 41, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: '#0A3D29',
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#00261a',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Belanja',
                        data: @json($apBel),
                        borderColor: '#d4a373',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#d4a373',
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#b68453',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: {
                    legend: { position: 'top', align: 'start' }
                },
                scales: {
                    y: { 
                        grid: { color: '#e1e3e2' },
                        ticks: {
                            callback: function(value) { return 'Rp ' + value + ' jt'; }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 6. Kondisi Jalan Stacked Bar Chart
    const roadCanvas = document.getElementById('roadConditionChart');
    if (roadCanvas) {
        @php
        $jalanCatObj = isset($categories['infrastruktur']) ? $categories['infrastruktur']->firstWhere('key', 'kondisi_jalan') : null;
        if ($jalanCatObj && $jalanCatObj->stats->count()) {
            $roadTypes = $jalanCatObj->stats->pluck('label')->unique()->values();
            $roadGroups = ['Baik', 'Sedang', 'Rusak'];
            $roadDatasets = [];
            $groupColors = ['Baik' => '#0A3D29', 'Sedang' => '#d4a373', 'Rusak' => '#E85D04'];
            $groupHoverColors = ['Baik' => '#00261a', 'Sedang' => '#b68453', 'Rusak' => '#b04010'];
            foreach($roadGroups as $g) {
                $dataArr = [];
                foreach($roadTypes as $t) {
                    $found = $jalanCatObj->stats->first(fn($s) => $s->label === $t && $s->sub_group === $g);
                    $dataArr[] = $found ? (float)$found->value : 0;
                }
                $roadDatasets[] = [
                    'label' => $g,
                    'data' => $dataArr,
                    'backgroundColor' => $groupColors[$g],
                    'hoverBackgroundColor' => $groupHoverColors[$g]
                ];
            }
        } else {
            $roadTypes = ['Aspal', 'Diperkeras', 'Tanah'];
            $roadDatasets = [
                ['label' => 'Baik', 'data' => [5, 2, 0.5], 'backgroundColor' => '#0A3D29', 'hoverBackgroundColor' => '#00261a'],
                ['label' => 'Sedang', 'data' => [1.2, 1.5, 2.5], 'backgroundColor' => '#d4a373', 'hoverBackgroundColor' => '#b68453'],
                ['label' => 'Rusak', 'data' => [0.4, 0.9, 1.2], 'backgroundColor' => '#E85D04', 'hoverBackgroundColor' => '#b04010'],
            ];
        }
        @endphp
        new Chart(roadCanvas, {
            type: 'bar',
            data: {
                labels: @json($roadTypes),
                datasets: @json($roadDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: { legend: { position: 'top' } },
                scales: {
                    x: { stacked: true, grid: { display: false } },
                    y: { 
                        stacked: true, 
                        grid: { color: '#e1e3e2' },
                        ticks: { callback: function(value) { return value + ' km'; } }
                    }
                }
            }
        });
    }

    // 7. Pelayanan Publik Line Chart
    const pubCanvas = document.getElementById('publicServiceChart');
    if (pubCanvas) {
        @php
        $pelCatObj = isset($categories['pemerintahan']) ? $categories['pemerintahan']->firstWhere('key', 'pelayanan_publik') : null;
        if ($pelCatObj && $pelCatObj->stats->count()) {
            $pubLabels = $pelCatObj->stats->pluck('label')->unique()->values();
            $pubYears  = $pelCatObj->stats->pluck('year')->unique()->sort()->values();
            $pubColors = ['KTP' => '#0A3D29', 'KK' => '#4361EE', 'Akta' => '#d4a373'];
            $pubDatasets = [];
            foreach($pubLabels as $lbl) {
                $dataArr = [];
                foreach($pubYears as $yr) {
                    $found = $pelCatObj->stats->first(fn($s) => $s->label === $lbl && $s->year == $yr);
                    $dataArr[] = $found ? (float)$found->value : 0;
                }
                $c = $pubColors[$lbl] ?? '#2E7D52';
                $pubDatasets[] = [
                    'label' => $lbl,
                    'data' => $dataArr,
                    'borderColor' => $c,
                    'tension' => 0.3,
                    'pointHoverRadius' => 6
                ];
            }
        } else {
            $pubYears = ['2013', '2014', '2015', '2016', '2017', '2018'];
            $pubDatasets = [
                ['label' => 'KTP', 'data' => [120, 130, 140, 135, 150, 160], 'borderColor' => '#0A3D29', 'tension' => 0.3, 'pointHoverRadius' => 6],
                ['label' => 'KK', 'data' => [80, 90, 85, 95, 110, 120], 'borderColor' => '#4361EE', 'tension' => 0.3, 'pointHoverRadius' => 6],
                ['label' => 'Akta', 'data' => [40, 50, 60, 55, 65, 75], 'borderColor' => '#d4a373', 'tension' => 0.3, 'pointHoverRadius' => 6],
            ];
        }
        @endphp
        new Chart(pubCanvas, {
            type: 'line',
            data: {
                labels: @json($pubYears),
                datasets: @json($pubDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                interaction: commonHoverOptions,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { grid: { color: '#e1e3e2' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 8. Tempat Ibadah Pie Chart
    const relCanvas = document.getElementById('religionChart');
    if (relCanvas) {
        @php
        $ibadahCatObj = isset($categories['sosial']) ? $categories['sosial']->firstWhere('key', 'tempat_ibadah') : null;
        $relLabels = $ibadahCatObj && $ibadahCatObj->stats->count() ? $ibadahCatObj->stats->pluck('label') : ['Masjid', 'Musholla', 'Gereja'];
        $relData   = $ibadahCatObj && $ibadahCatObj->stats->count() ? $ibadahCatObj->stats->pluck('value') : [15, 25, 1];
        @endphp
        new Chart(relCanvas, {
            type: 'pie',
            data: {
                labels: @json($relLabels),
                datasets: [{
                    data: @json($relData),
                    backgroundColor: ['#0A3D29', '#d4a373', '#4361EE'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: commonAnimationOptions,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
</script>
@endpush
