{{-- Compact Premium Weather Widget (BMKG Resmi - Desa Catur) --}}
@php
    $isAvailable = isset($weather) && !empty($weather['available']);
    $theme = $weather['theme'] ?? [];
    $themeType = $theme['type'] ?? 'cerah';
    $themeEffect = $theme['effect'] ?? 'daylight';
    $isDark = $theme['is_dark'] ?? true;

    // Gradasi interaktif & terintegrasi dengan identitas tema website
    $themeGradient = match($themeType) {
        'panas' => 'from-[#F59E0B] via-[#EAB308] to-[#CA8A04]',
        'senja' => 'from-[#EA580C] via-[#F97316] to-[#9A3412]',
        'hujan' => 'from-[#1A2E35] via-[#2A434E] to-[#0A3D29]',
        'malam' => 'from-[#0A192F] via-[#0E2838] to-[#03151E]',
        default => 'from-[#0284C7] via-[#0369A1] to-[#0A3D29]',
    };

    $themeGlow = match($themeType) {
        'panas' => 'bg-amber-200/40',
        'senja' => 'bg-amber-300/35',
        'hujan' => 'bg-cyan-400/20',
        'malam' => 'bg-indigo-400/25',
        default => 'bg-sky-300/30',
    };

    // Penyesuaian warna teks secara dinamis berdasarkan kecerahan latar belakang
    $ui = $isDark ? [
        'text_primary' => 'text-white',
        'text_secondary' => 'text-sky-100/90',
        'text_muted' => 'text-white/80',
        'text_subtle' => 'text-white/60',
        'text_faint' => 'text-white/50',
        'badge_label' => 'text-sky-200/90',
        'unit' => 'text-sky-200/80',
        'feels_like' => 'text-sky-100/70',
        'section_title' => 'text-sky-200/70',
        'bar_label' => 'text-sky-200/80',
        'card_bg' => 'bg-white/[0.08]',
        'card_divide' => 'divide-white/10',
        'slot_active' => 'bg-white/20 text-sky-100',
        'slot_hover' => 'hover:bg-white/10 text-white/70',
        'link_hover' => 'hover:text-sky-200',
        'link_underline' => 'decoration-white/30',
        'icon_compass' => 'text-white/80 hover:text-white',
        'accent_badge' => 'text-emerald-300',
    ] : [
        'text_primary' => 'text-slate-950',
        'text_secondary' => 'text-slate-900',
        'text_muted' => 'text-slate-800/90',
        'text_subtle' => 'text-slate-800/80',
        'text_faint' => 'text-slate-800/70',
        'badge_label' => 'text-amber-950/90',
        'unit' => 'text-amber-950/80',
        'feels_like' => 'text-slate-900/85',
        'section_title' => 'text-slate-950/80',
        'bar_label' => 'text-slate-950/85',
        'card_bg' => 'bg-black/[0.07]',
        'card_divide' => 'divide-black/10',
        'slot_active' => 'bg-black/15 text-slate-950 font-bold shadow-xs',
        'slot_hover' => 'hover:bg-black/5 text-slate-900/80',
        'link_hover' => 'hover:text-amber-950',
        'link_underline' => 'decoration-black/30',
        'icon_compass' => 'text-slate-900/80 hover:text-slate-950',
        'accent_badge' => 'text-amber-950 font-extrabold',
    ];

    $forecastList = array_slice($weather['forecast'] ?? [], 0, 5);
    $metrics = $weather['metrics'] ?? [];
@endphp

<aside aria-label="Informasi Cuaca Desa Catur BMKG"
    class="relative overflow-hidden rounded-lg p-4 sm:p-5 {{ $ui['text_primary'] }} shadow-sm flex flex-col justify-between h-full bg-gradient-to-br {{ $themeGradient }} transition-all duration-700 select-none">

    <!-- Ambient Atmospheric Glows -->
    <div class="absolute -top-12 -right-12 w-32 h-32 {{ $themeGlow }} rounded-full blur-3xl pointer-events-none transition-colors duration-700"></div>
    <div class="absolute -bottom-10 -left-10 w-28 h-28 {{ $isDark ? 'bg-[#0A3D29]/40' : 'bg-amber-600/20' }} rounded-full blur-2xl pointer-events-none transition-colors duration-700"></div>

    {{-- Layer Efek Visual Khusus Berdasarkan Kondisi Cuaca --}}
    @if($themeEffect === 'sun_sparkle')
        <!-- Efek Kilauan Matahari (Siang Panas) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-10 -right-10 w-44 h-44 rounded-full bg-gradient-to-br from-white/45 via-amber-200/30 to-transparent blur-xl animate-pulse"></div>
            <!-- Flare Rays -->
            <div class="absolute top-0 right-0 w-36 h-36 bg-[radial-gradient(circle,rgba(255,255,255,0.3)_0%,transparent_70%)] animate-spin" style="animation-duration: 25s;"></div>
            <!-- Sparkles -->
            <div class="absolute top-5 right-12 w-1.5 h-1.5 rounded-full bg-white shadow-[0_0_8px_2px_rgba(255,255,255,0.9)] animate-ping" style="animation-duration: 3s;"></div>
            <div class="absolute top-14 right-6 w-1 h-1 rounded-full bg-white shadow-[0_0_6px_2px_rgba(255,255,255,0.8)] animate-pulse" style="animation-duration: 2s;"></div>
            <div class="absolute top-20 right-20 w-1 h-1 rounded-full bg-amber-100 shadow-[0_0_6px_1px_rgba(255,255,255,0.8)] animate-ping" style="animation-duration: 4s;"></div>
        </div>
    @elseif($themeEffect === 'rain')
        <!-- Efek Visual Basah & Titik Gerimis (Hujan) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <!-- Wet sheen gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-cyan-400/[0.07] via-transparent to-slate-950/20 backdrop-blur-[0.5px]"></div>
            <!-- Stylized Rain Streaks -->
            <div class="absolute inset-0 opacity-25" style="background-image: repeating-linear-gradient(105deg, rgba(255,255,255,0.15) 0px, rgba(255,255,255,0.15) 1px, transparent 1px, transparent 18px); background-size: 100% 100%;"></div>
            <!-- Wet droplet ripples -->
            <div class="absolute top-3 left-1/4 w-8 h-8 rounded-full border border-cyan-200/20 animate-ping" style="animation-duration: 4s;"></div>
            <div class="absolute bottom-6 right-1/3 w-10 h-10 rounded-full border border-cyan-200/15 animate-ping" style="animation-duration: 5s; animation-delay: 1.5s;"></div>
        </div>
    @elseif($themeEffect === 'stars')
        <!-- Efek Bintang Malam Hari -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute top-3 right-8 w-1 h-1 rounded-full bg-white/90 shadow-[0_0_4px_1px_rgba(255,255,255,0.8)] animate-pulse" style="animation-duration: 2.2s;"></div>
            <div class="absolute top-7 right-24 w-0.5 h-0.5 rounded-full bg-sky-200/80 animate-pulse" style="animation-duration: 3.5s; animation-delay: 0.7s;"></div>
            <div class="absolute top-14 right-14 w-1 h-1 rounded-full bg-indigo-100/90 shadow-[0_0_5px_1px_rgba(255,255,255,0.7)] animate-pulse" style="animation-duration: 2.8s; animation-delay: 1.2s;"></div>
            <div class="absolute top-18 right-32 w-0.5 h-0.5 rounded-full bg-white/70 animate-pulse" style="animation-duration: 4s;"></div>
            <div class="absolute top-10 left-16 w-0.5 h-0.5 rounded-full bg-sky-100/75 animate-pulse" style="animation-duration: 3.2s; animation-delay: 1.8s;"></div>
            <div class="absolute top-24 left-28 w-1 h-1 rounded-full bg-white/80 shadow-[0_0_4px_1px_rgba(255,255,255,0.6)] animate-pulse" style="animation-duration: 2.5s; animation-delay: 0.4s;"></div>
        </div>
    @elseif($themeEffect === 'sunset')
        <!-- Efek Cahaya Senja (Sunset Horizon Glow) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -bottom-8 -right-8 w-48 h-32 rounded-full bg-gradient-to-t from-amber-300/35 via-rose-500/20 to-transparent blur-2xl"></div>
            <div class="absolute top-0 right-1/4 w-32 h-20 bg-gradient-to-b from-yellow-300/15 to-transparent blur-xl"></div>
        </div>
    @endif

    <div class="relative z-10 space-y-4">
        <!-- 1. Header: Nama Lokasi & Ikon Kompas Segitiga di Kanan Atas (Tanpa Pembungkus) -->
        <div class="flex items-center justify-between">
            <div class="min-w-0">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $ui['badge_label'] }} block">
                    {{ $weather['location'] ?? 'Desa Catur' }}
                </span>
                <p class="text-[11px] {{ $ui['text_muted'] }} font-normal">
                    {{ $weather['sub_location'] ?? 'Sambi, Boyolali' }}
                </p>
            </div>

            <!-- Ikon Navigasi Segitiga Kompas di Kanan Atas (Tanpa Pembungkus) -->
            <div class="{{ $ui['icon_compass'] }} transition-colors shrink-0"
                title="{{ $weather['full_location'] ?? 'Desa Catur, Sambi, Boyolali' }}"
                aria-label="Lokasi {{ $weather['location'] ?? 'Desa Catur' }}">
                <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="3 11 22 2 13 21 11 13 3 11" fill="currentColor" fill-opacity="0.25" />
                </svg>
            </div>
        </div>

        @if($isAvailable)
            <!-- 2. Current Weather: Fluid & Airy Layout -->
            <div class="flex items-center justify-between gap-2 pt-1 pb-1">
                <div class="space-y-0.5">
                    <div class="flex items-baseline">
                        <span class="font-serif text-4xl sm:text-5xl font-extrabold tracking-tight {{ $ui['text_primary'] }} leading-none">
                            {{ $weather['temperature'] }}°
                        </span>
                        <span class="text-sm font-medium {{ $ui['unit'] }} ml-1">C</span>
                    </div>
                    <p class="text-sm font-semibold {{ $ui['text_secondary'] }} tracking-wide pt-1">
                        {{ $weather['condition'] }}
                    </p>
                    @if(!empty($weather['feels_like']))
                        <p class="text-[11px] {{ $ui['feels_like'] }}">
                            Terasa {{ $weather['feels_like'] }}°C
                        </p>
                    @endif
                </div>

                <!-- Expressive Weather Icon -->
                <div class="w-16 h-16 sm:w-18 sm:h-18 shrink-0 flex items-center justify-center filter drop-shadow-md">
                    @if(!empty($weather['icon']))
                        <img src="{{ $weather['icon'] }}" alt="{{ $weather['condition'] }}" loading="lazy"
                            class="w-full h-full object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span class="text-4xl hidden" aria-hidden="true">⛅</span>
                    @else
                        <span class="text-4xl" aria-hidden="true">⛅</span>
                    @endif
                </div>
            </div>

            <!-- 3. Forecast Strip: Clean, Borderless & Scrollbar-Free -->
            @if(!empty($forecastList) && count($forecastList) > 0)
                <div class="space-y-2 pt-1">
                    <div
                        class="flex items-center justify-between text-[10px] uppercase tracking-wider {{ $ui['section_title'] }} font-semibold px-0.5">
                        <span>Prakiraan Hari Ini</span>
                        <span class="text-[9px] {{ $ui['text_faint'] }} lowercase">wib</span>
                    </div>

                    <!-- Clean 5-Slots Layout (Zero Visible Scrollbar) -->
                    <div class="flex items-center justify-between gap-1 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
                        style="scrollbar-width: none; -ms-overflow-style: none;">
                        @foreach($forecastList as $slot)
                            <div
                                class="flex flex-col items-center justify-center py-2 px-1.5 rounded-lg text-center flex-1 transition-all {{ $slot['is_current'] ? $ui['slot_active'] . ' backdrop-blur-xs font-bold' : $ui['slot_hover'] }}">
                                <span class="text-[10px] {{ $slot['is_current'] ? ($isDark ? 'text-sky-100 font-bold' : 'text-slate-950 font-bold') : ($isDark ? 'text-white/70' : 'text-slate-900/75') }}">
                                    {{ $slot['time'] }}
                                </span>
                                <div class="w-6 h-6 my-1 flex items-center justify-center">
                                    @if(!empty($slot['icon']))
                                        <img src="{{ $slot['icon'] }}" alt="{{ $slot['condition'] }}" loading="lazy"
                                            class="w-full h-full object-contain"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                        <span class="text-xs hidden" aria-hidden="true">⛅</span>
                                    @else
                                        <span class="text-xs" aria-hidden="true">⛅</span>
                                    @endif
                                </div>
                                <span class="text-xs font-semibold {{ $ui['text_primary'] }}">
                                    {{ $slot['temperature'] }}°
                                </span>
                                @if($slot['is_current'])
                                    <!-- Keterangan 'Sekarang' (Sesuai Arahan User) -->
                                    <span class="text-[8px] uppercase tracking-wider {{ $ui['accent_badge'] }} mt-0.5">
                                        Sekarang
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. Quick Metrics: Single Unified Translucent Bar -->
            <div
                class="{{ $ui['card_bg'] }} backdrop-blur-xs rounded-lg py-2 px-1 flex items-center justify-around divide-x {{ $ui['card_divide'] }} text-center transition-colors">
                <!-- Kelembapan -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider {{ $ui['bar_label'] }} block font-medium">Lembap</span>
                    <span class="text-xs font-bold {{ $ui['text_primary'] }} mt-0.5 block">
                        {{ $metrics['humidity'] !== null ? $metrics['humidity'] . '%' : '-' }}
                    </span>
                </div>

                <!-- Angin -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider {{ $ui['bar_label'] }} block font-medium">Angin</span>
                    <span class="text-xs font-bold {{ $ui['text_primary'] }} mt-0.5 block">
                        {{ $metrics['wind_speed'] !== null ? $metrics['wind_speed'] . ' km/j' : '-' }}
                    </span>
                </div>

                <!-- Presipitasi / Hujan -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider {{ $ui['bar_label'] }} block font-medium">Hujan</span>
                    <span class="text-xs font-bold {{ $ui['text_primary'] }} mt-0.5 block">
                        @if(isset($metrics['precipitation']) && $metrics['precipitation'] > 0)
                            {{ $metrics['precipitation'] }} mm
                        @else
                            0 mm
                        @endif
                    </span>
                </div>
            </div>

        @else
            <!-- Fallback State -->
            <div class="py-8 text-center flex flex-col items-center justify-center space-y-2">
                <span class="text-4xl {{ $ui['text_faint'] }}" aria-hidden="true">🌤️</span>
                <p class="text-xs {{ $ui['text_muted'] }} max-w-[210px] leading-relaxed">
                    {{ $weather['message'] ?? 'Informasi cuaca sementara tidak tersedia.' }}
                </p>
            </div>
        @endif
    </div>

    <!-- 5. Footer: Atribusi Data (Sesuai Arahan User: 'Data disediakan oleh: BMKG') -->
    <div class="relative z-10 pt-3 flex items-center justify-between text-[10px] {{ $ui['text_subtle'] }}">
        <span>
            Data disediakan oleh:
            <a href="{{ $weather['source_url'] ?? 'https://www.bmkg.go.id/cuaca/prakiraan-cuaca/33.09.10.2006' }}"
                target="_blank" rel="noopener noreferrer"
                class="font-medium {{ $ui['text_secondary'] }} {{ $ui['link_hover'] }} underline {{ $ui['link_underline'] }} underline-offset-2 transition-colors">
                BMKG
            </a>
        </span>
        <span class="text-[9px] {{ $ui['text_faint'] }}">
            {{ $weather['updated_at'] ?? 'Prakiraan BMKG' }}
        </span>
    </div>

</aside>