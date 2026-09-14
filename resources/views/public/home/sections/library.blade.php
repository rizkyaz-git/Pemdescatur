<!-- ========================================================= -->
<!-- SECTION 3: PERPUSTAKAAN DIGITAL "REMEN MAOS DESA CATUR" -->
<!-- ========================================================= -->
<section id="perpustakaan-digital"
    class="w-full bg-[#0A3D29] text-white py-16 sm:py-20 lg:py-24 border-b border-[#072B1D] overflow-hidden flex items-center min-h-[580px] lg:min-h-[640px] scroll-reveal">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-center">

            {{-- Left Column: Text & Bullet Points & Action Button (order-2 on mobile, order-1 on desktop) --}}
            <div class="order-2 lg:order-1 lg:col-span-5 space-y-6 sm:space-y-7 text-left">

                {{-- Headline & Description --}}
                <div class="space-y-3.5">
                    <h2 class="space-y-1 sm:space-y-2">
                        <span
                            class="block font-['Public_Sans',sans-serif] text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                            Remen Maos
                        </span>
                        <span
                            class="block font-['Public_Sans',sans-serif] text-xl sm:text-2xl lg:text-3xl font-extrabold text-emerald-300 leading-tight tracking-tight">
                            Perpustakaan Digital Desa Catur
                        </span>
                    </h2>

                    <p class="text-sm sm:text-base text-white/85 font-normal leading-relaxed max-w-xl">
                        Akses perpustakaan digital hanya dari genggaman anda, Jelajahi koleksi buku menarik dimanapun
                        dan kapanpun.
                    </p>
                </div>

                {{-- 3 Bullet Points with Glowing Emerald Badges --}}
                <div class="space-y-3.5 pt-1 flex flex-col items-start text-left max-w-lg w-full">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Beragam Judul Buku
                            Digital menarik untuk dibaca</span>
                    </div>

                    <div class="flex items-start gap-3">
                        <div
                            class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Akses Gratis 24 Jam
                            Tanpa Batas dari semua perangkat anda</span>
                    </div>

                    <div class="flex items-start gap-3">
                        <div
                            class="w-5 h-5 rounded-full bg-white/15 border border-white/25 text-emerald-300 flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-white/90 leading-snug">Dikelola oleh
                            Perpustakaan Daerah Boyolali</span>
                    </div>
                </div>

                {{-- Action Button: Kunjungi Remen Maos Catur --}}
                <div class="pt-2 flex justify-start">
                    <a href="{{ $libraryUrl ?? 'https://perpustakaan.boyolali.go.id' }}" target="_blank"
                        rel="noopener noreferrer"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 bg-white hover:bg-emerald-50 text-[#0A3D29] font-extrabold text-sm sm:text-base px-8 py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 group shrink-0">
                        <span>Kunjungi Remen Maos Catur</span>
                        <svg class="w-4 h-4 text-[#0A3D29] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

            </div>

            {{-- Right Column: Transparent Seamless 3D Multi-Device Showcase Image (order-1 on mobile, order-2 on desktop) --}}
            <div class="order-1 lg:order-2 lg:col-span-7 flex items-center justify-center">
                <div class="w-full max-w-[720px] mx-auto relative py-4 sm:py-6" x-data="{ loaded: false }"
                    x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">

                    {{-- Ambient Soft Glow / Spotlight behind mockup to soften cutout edges --}}
                    <div class="absolute inset-0 m-auto w-[90%] h-[85%] rounded-full pointer-events-none -z-0 opacity-80"
                        style="background: radial-gradient(ellipse at center, rgba(52, 211, 153, 0.28) 0%, rgba(16, 185, 129, 0.12) 45%, transparent 72%); filter: blur(40px); transform: translate3d(0, 0, 0);">
                    </div>

                    <div x-show="!loaded"
                        class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none rounded-xl"></div>
                    <img x-ref="img"
                        src="{{ asset('images/remen_maos_mockup.png') }}?v={{ file_exists(public_path('images/remen_maos_mockup.png')) ? filemtime(public_path('images/remen_maos_mockup.png')) : time() }}"
                        alt="Perpustakaan Digital Remen Maos Desa Catur Multi-Device Mockup" width="1181" height="619"
                        loading="eager" decoding="async" @load="loaded = true;" x-on:error="loaded = true;"
                        class="w-full h-auto object-contain hover:scale-[1.015] transition-all duration-700 pointer-events-auto relative z-10"
                        style="filter: drop-shadow(0 25px 35px rgba(0, 0, 0, 0.50)) drop-shadow(0 0 20px rgba(52, 211, 153, 0.25)) drop-shadow(0 4px 12px rgba(0, 0, 0, 0.35));"
                        :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                </div>
            </div>

        </div>
    </div>
</section>
