{{-- Compact Premium Weather Widget (BMKG Resmi - Desa Catur) --}}
@php
    $isAvailable = isset($weather) && !empty($weather['available']);
    $isDay = $weather['theme']['is_day'] ?? ((int) \Carbon\Carbon::now('Asia/Jakarta')->format('H') >= 6 && (int) \Carbon\Carbon::now('Asia/Jakarta')->format('H') < 18);
    $themeGradient = $weather['theme']['gradient'] ?? ($isDay ? 'from-[#2563EB] via-[#1E40AF] to-[#172554]' : 'from-[#0F172A] via-[#0B1120] to-[#020617]');
    $themeGlow = $weather['theme']['glow'] ?? ($isDay ? 'bg-sky-400/25' : 'bg-indigo-400/20');
    // Ambil 5 slot terdekat agar pas secara proporsional tanpa memicu scrollbar
    $forecastList = array_slice($weather['forecast'] ?? [], 0, 5);
    $metrics = $weather['metrics'] ?? [];
@endphp

<aside aria-label="Informasi Cuaca Desa Catur BMKG"
    class="relative overflow-hidden rounded-lg p-4 sm:p-5 text-white shadow-sm flex flex-col justify-between h-full bg-gradient-to-br {{ $themeGradient }} transition-all duration-500">

    <!-- Ambient Soft Atmospheric Glow (Menyesuaikan Siang / Malam) -->
    <div class="absolute -top-12 -right-12 w-32 h-32 {{ $themeGlow }} rounded-full blur-3xl pointer-events-none"></div>
    <div
        class="absolute -bottom-10 -left-10 w-28 h-28 {{ $isDay ? 'bg-sky-400/15' : 'bg-blue-600/15' }} rounded-full blur-2xl pointer-events-none">
    </div>

    <div class="relative z-10 space-y-4">
        <!-- 1. Header: Nama Lokasi & Ikon Kompas Segitiga di Kanan Atas (Tanpa Pembungkus) -->
        <div class="flex items-center justify-between">
            <div class="min-w-0">
                <span class="text-[10px] font-bold uppercase tracking-wider text-sky-200/90 block">
                    {{ $weather['location'] ?? 'Desa Catur' }}
                </span>
                <p class="text-[11px] text-white/80 font-normal">
                    {{ $weather['sub_location'] ?? 'Sambi, Boyolali' }}
                </p>
            </div>

            <!-- Ikon Navigasi Segitiga Kompas di Kanan Atas (Tanpa Pembungkus) -->
            <div class="text-white/80 hover:text-white transition-colors shrink-0"
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
                        <span class="font-serif text-4xl sm:text-5xl font-extrabold tracking-tight text-white leading-none">
                            {{ $weather['temperature'] }}°
                        </span>
                        <span class="text-sm font-medium text-sky-200/80 ml-1">C</span>
                    </div>
                    <p class="text-sm font-semibold text-white/95 tracking-wide pt-1">
                        {{ $weather['condition'] }}
                    </p>
                    @if(!empty($weather['feels_like']))
                        <p class="text-[11px] text-sky-100/70">
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
                        class="flex items-center justify-between text-[10px] uppercase tracking-wider text-sky-200/70 font-semibold px-0.5">
                        <span>Prakiraan Hari Ini</span>
                        <span class="text-[9px] text-white/50 lowercase">wib</span>
                    </div>

                    <!-- Clean 5-Slots Layout (Zero Visible Scrollbar) -->
                    <div class="flex items-center justify-between gap-1 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
                        style="scrollbar-width: none; -ms-overflow-style: none;">
                        @foreach($forecastList as $slot)
                            <div
                                class="flex flex-col items-center justify-center py-2 px-1.5 rounded-lg text-center flex-1 transition-all {{ $slot['is_current'] ? 'bg-white/20 backdrop-blur-xs font-bold' : 'hover:bg-white/10' }}">
                                <span class="text-[10px] {{ $slot['is_current'] ? 'text-sky-100 font-bold' : 'text-white/70' }}">
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
                                <span class="text-xs font-semibold text-white">
                                    {{ $slot['temperature'] }}°
                                </span>
                                @if($slot['is_current'])
                                    <!-- Keterangan 'Sekarang' (Sesuai Arahan User) -->
                                    <span class="text-[8px] uppercase tracking-wider text-emerald-300 font-extrabold mt-0.5">
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
                class="bg-white/[0.08] backdrop-blur-xs rounded-lg py-2 px-1 flex items-center justify-around divide-x divide-white/10 text-center">
                <!-- Kelembapan -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider text-sky-200/80 block font-medium">Lembap</span>
                    <span class="text-xs font-bold text-white mt-0.5 block">
                        {{ $metrics['humidity'] !== null ? $metrics['humidity'] . '%' : '-' }}
                    </span>
                </div>

                <!-- Angin -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider text-sky-200/80 block font-medium">Angin</span>
                    <span class="text-xs font-bold text-white mt-0.5 block">
                        {{ $metrics['wind_speed'] !== null ? $metrics['wind_speed'] . ' km/j' : '-' }}
                    </span>
                </div>

                <!-- Presipitasi / Hujan -->
                <div class="flex-1 px-1">
                    <span class="text-[9px] uppercase tracking-wider text-sky-200/80 block font-medium">Hujan</span>
                    <span class="text-xs font-bold text-white mt-0.5 block">
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
                <span class="text-4xl text-white/50" aria-hidden="true">🌤️</span>
                <p class="text-xs text-white/80 max-w-[210px] leading-relaxed">
                    {{ $weather['message'] ?? 'Informasi cuaca sementara tidak tersedia.' }}
                </p>
            </div>
        @endif
    </div>

    <!-- 5. Footer: Atribusi Data (Sesuai Arahan User: 'Data disediakan oleh: BMKG') -->
    <div class="relative z-10 pt-3 flex items-center justify-between text-[10px] text-white/60">
        <span>
            Data disediakan oleh:
            <a href="{{ $weather['source_url'] ?? 'https://www.bmkg.go.id/cuaca/prakiraan-cuaca/33.09.10.2006' }}"
                target="_blank" rel="noopener noreferrer"
                class="font-medium text-white/90 hover:text-sky-200 underline decoration-white/30 underline-offset-2 transition-colors">
                BMKG
            </a>
        </span>
        <span class="text-[9px] text-white/50">
            {{ $weather['updated_at'] ?? 'Prakiraan BMKG' }}
        </span>
    </div>

</aside>