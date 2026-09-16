<div>
    <!-- ===================================================================== -->
    <!-- 3. SECTION DEDIKASI PER-POJOK (BERGAYA KARTU) -->
    <!-- ===================================================================== -->
    <style>
        /* ===================================================================== */
        /* RESPONSIVE CSS GRID: DAFTAR LIMA POJOK PEMBERDAYAAN                  */
        /* ===================================================================== */
        .programs-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Desktop (> 768px): Kolom sejajar, nomor otomatis/eksplisit, titik dua tegak lurus */
        @media (min-width: 769px) {
            .programs-list {
                display: grid;
                grid-template-columns: auto max-content auto 1fr;
                column-gap: 0.5rem;
                row-gap: 0.625rem;
                align-items: baseline;
            }

            .programs-list>.program-item {
                display: contents;
            }

            .programs-list .program-num {
                font-weight: 700;
                color: #0A3D29;
            }

            .programs-list .program-name {
                font-weight: 700;
                color: #20332A;
                white-space: nowrap;
            }

            .programs-list .program-colon {
                font-weight: 700;
                color: #0A3D29;
                text-align: center;
                user-select: none;
                padding-right: 0.25rem;
            }

            .programs-list .program-desc {
                text-align: justify;
                color: #475569;
                line-height: 1.625;
            }
        }

        /* Mobile (<= 768px): 1 Kolom (Nama baris 1, Deskripsi baris 2 justify, colon hidden) */
        @media (max-width: 768px) {
            .programs-list {
                display: flex;
                flex-direction: column;
                gap: 0.875rem;
            }

            .programs-list>.program-item {
                display: grid;
                grid-template-columns: auto 1fr;
                column-gap: 0.375rem;
                row-gap: 0.25rem;
                align-items: baseline;
            }

            .programs-list .program-num {
                font-weight: 700;
                color: #0A3D29;
                grid-column: 1;
                grid-row: 1;
            }

            .programs-list .program-name {
                font-weight: 700;
                color: #20332A;
                grid-column: 2;
                grid-row: 1;
            }

            .programs-list .program-colon {
                display: none !important;
            }

            .programs-list .program-desc {
                grid-column: 2;
                grid-row: 2;
                text-align: justify;
                color: #475569;
                line-height: 1.625;
            }
        }

        /* ─── Unified Responsive Section Vertical Rhythm ─── */
        .ppko-section-spacing {
            padding-top: clamp(2.5rem, 1.5rem + 2.5vw, 4.75rem);
            padding-bottom: clamp(2.5rem, 1.5rem + 2.5vw, 4.75rem);
        }

        /* ─── Entrance Animation: Pure Fade (GPU-Lite) ─── */
        .ppko-section-entrance {
            opacity: 0;
            transition: opacity 0.4s ease-out;
        }

        .ppko-section-entrance.is-revealed {
            opacity: 1;
        }

        /* Tampil serempak tanpa delay bertingkat yang berat */
        .harmoni-num-animate,
        .harmoni-text-animate,
        .harmoni-cards-animate,
        .harmoni-desc-animate {
            opacity: 1;
            transform: none;
            transition: none;
        }

        /* ─── Responsive Title & Number Pojok (Single Line UMKM Mobile) ─── */
        .pojok-title-umkm {
            font-size: clamp(0.92rem, 4.1vw, 1.45rem);
            white-space: nowrap;
        }

        .pojok-num-umkm {
            font-size: clamp(1rem, 4.3vw, 1.55rem);
        }

        .pojok-title-standard {
            font-size: clamp(1.4rem, 5.5vw, 5rem);
        }

        .pojok-num-standard {
            font-size: clamp(1.5rem, 5.8vw, 5rem);
        }

        @media (min-width: 640px) {

            .pojok-title-umkm,
            .pojok-title-standard {
                font-size: clamp(2.25rem, 5vw, 5rem);
            }

            .pojok-num-umkm,
            .pojok-num-standard {
                font-size: clamp(2.25rem, 5vw, 5rem);
            }
        }

        /* ─── Slider Frame: Pipih 16:9 pada Mobile, Tinggi Tetap pada Desktop ─── */
        .pojok-slider-frame {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            max-height: 250px;
        }

        @media (min-width: 640px) {
            .pojok-slider-frame {
                aspect-ratio: 16 / 9;
                max-height: 330px;
            }
        }

        @media (min-width: 1024px) {
            .pojok-slider-frame {
                aspect-ratio: auto;
                max-height: none;
                height: 360px;
            }
        }

        @media (min-width: 1280px) {
            .pojok-slider-frame {
                height: 380px;
            }
        }

        /* ─── Tombol Navigasi Slider: Minimalis, Terpusat Vertikal, & Tampil Saat Hover di Desktop ─── */
        .pojok-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 9999px;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            z-index: 20;
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .pojok-slider-btn:hover {
            background-color: rgba(0, 0, 0, 0.7);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-50%) scale(1.06);
        }

        .pojok-slider-btn:active {
            transform: translateY(-50%) scale(0.94);
        }

        .pojok-slider-prev {
            left: 12px;
        }

        .pojok-slider-next {
            right: 12px;
        }

        @media (min-width: 768px) {
            .pojok-slider-btn {
                display: flex;
            }

            .pojok-slider-frame:hover .pojok-slider-btn,
            .pojok-slider-btn:focus-visible {
                opacity: 1;
                pointer-events: auto;
            }
        }

        /* ─── Baris Deskripsi Slider: Spasi Aman Kebal Build ─── */
        .pojok-slider-desc-bar {
            margin-top: 18px;
            width: 100%;
        }

        @media (min-width: 640px) {
            .pojok-slider-desc-bar {
                margin-top: 22px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .ppko-section-entrance,
            .harmoni-num-animate,
            .harmoni-text-animate,
            .harmoni-cards-animate,
            .harmoni-desc-animate {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>

    <div id="katalog-pojok-container" class="w-full">
        @foreach($pojoks as $index => $pojok)
            @php
                $slugId = Str::slug(str_replace('Pojok ', '', $pojok->nama));

                $isEven = ($loop->iteration % 2 === 0);
                $isDark = $isEven; // Selang-seling warna latar: Ganjil (1, 3, 5) = Putih, Genap (2, 4) = Hijau Gelap #0A3D29
                $isUmkmGoDigital = str_contains(strtolower($pojok->nama), 'go digital') || str_contains(strtolower($pojok->nama), 'umkm');

                // Gambar slider & deskripsi: ambil dari DB atau gambar representatif jika kosong
                $defaultFallbackCards = [
                    1 => [
                        ['url' => asset('images/cover_ppko.png'), 'desc' => 'Sesi bimbingan belajar dan ruang kreasi anak-anak Desa Catur'],
                        ['url' => asset('images/culture_pura.png'), 'desc' => 'Kegiatan keagamaan dan penguatan harmoni sosial lintas warga'],
                        ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Ruang konseling dan pendampingan kesejahteraan psikososial keluarga'],
                    ],
                    2 => [
                        ['url' => asset('images/remen_maos_mockup.png'), 'desc' => 'Pojok literasi ramah anak dan pojok baca Remen Maos'],
                        ['url' => asset('images/hero_landscape.png'), 'desc' => 'Permainan edukatif dan aktivitas dongeng inspiratif nusantara'],
                        ['url' => asset('images/cover_ppko.png'), 'desc' => 'Edukasi kesehatan emosional dan pembentukan karakter generasi muda'],
                    ],
                    3 => [
                        ['url' => asset('images/coffee_processing.png'), 'desc' => 'Pendampingan pengolahan pasca panen dan pengemasan produk kopi lokal'],
                        ['url' => asset('images/coffee_plantation.png'), 'desc' => 'Pelatihan pemasaran digital dan optimasi katalog e-commerce warga'],
                        ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Workshop manajemen keuangan mandiri bagi pelaku usaha desa'],
                    ],
                    4 => [
                        ['url' => asset('images/culture_pura.png'), 'desc' => 'Pelestarian situs cagar budaya dan tradisi kearifan lokal Desa Catur'],
                        ['url' => asset('images/umbul_siraman.png'), 'desc' => 'Dokumentasi seni karawitan dan ruang ekspresi kebudayaan tradisional'],
                        ['url' => asset('images/masjid_wonokusumo.png'), 'desc' => 'Wisata edukasi sejarah dan pengenalan warisan leluhur desa'],
                    ],
                    5 => [
                        ['url' => asset('images/sawah_irigasi.png'), 'desc' => 'Inovasi sistem irigasi cerdas dan pemetaan lahan pertanian produktif'],
                        ['url' => asset('images/coffee_plantation.png'), 'desc' => 'Pemberdayaan kelompok tani dalam pembuatan pupuk organik ramah lingkungan'],
                        ['url' => asset('images/hero_landscape.png'), 'desc' => 'Budidaya tanaman pangan berkelanjutan menuju ketahanan pangan desa'],
                    ],
                ];
                $defSet = $defaultFallbackCards[$pojok->id] ?? $defaultFallbackCards[1];

                $cardImg1 = !empty($pojok->gambar) ? asset('storage/' . $pojok->gambar) : $defSet[0]['url'];
                $cardImg2 = !empty($pojok->gambar_2) ? asset('storage/' . $pojok->gambar_2) : $defSet[1]['url'];
                $cardImg3 = !empty($pojok->gambar_3) ? asset('storage/' . $pojok->gambar_3) : $defSet[2]['url'];

                $cardDesc1 = !empty($pojok->deskripsi_gambar) ? $pojok->deskripsi_gambar : $defSet[0]['desc'];
                $cardDesc2 = !empty($pojok->deskripsi_gambar_2) ? $pojok->deskripsi_gambar_2 : $defSet[1]['desc'];
                $cardDesc3 = !empty($pojok->deskripsi_gambar_3) ? $pojok->deskripsi_gambar_3 : $defSet[2]['desc'];
                $cardDescs = [$cardDesc1, $cardDesc2, $cardDesc3];

                // Memisahkan narasi utama dan rincian fokus/mitra (murni dari database tanpa penambahan fiktif)
                $htmlDesc = $pojok->deskripsi_singkat ?? '';
                $pattern = '/((?:<p[^>]*>)?\s*<strong>\s*Fokus\s+pembelajaran.*$)/is';
                if (preg_match($pattern, $htmlDesc, $matches, PREG_OFFSET_CAPTURE)) {
                    $narasiDesc = trim(substr($htmlDesc, 0, $matches[0][1]));
                    $detailKanan = trim(substr($htmlDesc, $matches[0][1]));
                } else {
                    $narasiDesc = $htmlDesc;
                    $detailKanan = '';
                }

                // Data Mitra Komunitas Tambahan untuk Pojok Ceria, Budaya, dan Tani
                $mitraKomunitas = null;
                $pNamaLower = strtolower($pojok->nama);
                if (str_contains($pNamaLower, 'ceria')) {
                    $mitraKomunitas = [
                        'title' => 'Mitra Komunitas TPA',
                        'type' => 'numbered',
                        'items' => [
                            'TPA masjid Gumukrejo',
                            'TPA masjid Dukuh Catur',
                        ]
                    ];
                } elseif (str_contains($pNamaLower, 'budaya')) {
                    $mitraKomunitas = [
                        'title' => 'Mitra Komunitas Karang Taruna',
                        'type' => 'numbered',
                        'items' => [
                            'Dukuh Kungon',
                            'Dukuh Catur',
                            'Dukuh Sabrangan',
                            'Dukuh Karakan',
                            'Dukuh Gunungpuyuh',
                            'Dukuh Gumuk Ngembes',
                            'Dukuh Tropayan',
                            'Dukuh Giring',
                            'Dukuh Karangjowo',
                            'Dukuh Bakalan',
                            'Dukuh Kragan',
                            'Dukuh Wonotoro',
                            'Dukuh Gumukrejo',
                        ]
                    ];
                } elseif (str_contains($pNamaLower, 'tani')) {
                    $mitraKomunitas = [
                        'title' => 'Mitra Komunitas Gabungan Kelompok Tani (GAPOKTAN)',
                        'type' => 'numbered',
                        'items' => [
                            'kelompok tani Budi Rahayu',
                            'kelompok tani Ngudi Rejeki',
                            'kelompok tani Sarono Tani',
                            'kelompok tani Marsudi Mulyo',
                        ]
                    ];
                }
            @endphp

            <section id="{{ $slugId }}"
                class="w-full relative scroll-mt-28 md:scroll-mt-36 ppko-section-spacing flex flex-col justify-center ppko-section-entrance overflow-hidden {{ $isDark ? 'bg-[#0A3D29] text-white' : 'bg-white text-slate-900' }}">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

                    <!-- MAIN GRID: SELANG-SELING KIRI KANAN (Ganjil: Teks Kiri, Foto Kanan | Genap: Foto Kiri, Teks Kanan) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 lg:gap-12 items-start">

                        <!-- TEXT & INTERACTION COLUMN (Order-2 di Mobile agar Teks Berada di Bawah Gambar) -->
                        <div x-data="{
                            expanded: false,
                            pinRafId: null,
                            isAnimating: false,
                            closeDropdown() {
                                if (!this.expanded || this.isAnimating) return;
                                this.isAnimating = true;
                                const box = this.$refs.contentBox;
                                const startH = box ? box.offsetHeight : 0;
                                if (box && startH > 0) {
                                    box.style.height = startH + 'px';
                                    box.style.overflow = 'hidden';
                                }
                                this.expanded = false;
                                this.$nextTick(() => {
                                    if (!box) {
                                        this.isAnimating = false;
                                        return;
                                    }
                                    const targetView = this.$refs.view1;
                                    let endH = targetView ? Math.max(targetView.offsetHeight, targetView.scrollHeight) : 0;
                                    const computedMinH = parseFloat(window.getComputedStyle(box).minHeight) || 0;
                                    if (computedMinH > endH) endH = computedMinH;

                                    const startTime = performance.now();
                                    const duration = 380;
                                    const animateClose = (now) => {
                                        const elapsed = now - startTime;
                                        const progress = Math.min(elapsed / duration, 1);
                                        const ease = 1 - Math.pow(1 - progress, 3);
                                        const currentH = startH + (endH - startH) * ease;
                                        box.style.height = currentH.toFixed(2) + 'px';
                                        if (progress < 1) {
                                            requestAnimationFrame(animateClose);
                                        } else {
                                            box.style.height = '';
                                            box.style.overflow = '';
                                            this.isAnimating = false;
                                        }
                                    };
                                    requestAnimationFrame(animateClose);
                                });
                            },
                            toggleExpanded(btnEl) {
                                if (this.isAnimating) return;
                                this.isAnimating = true;

                                const box = this.$refs.contentBox;
                                const btn = btnEl;
                                const targetTop = btn ? btn.getBoundingClientRect().top : null;

                                // 1. Dapatkan tinggi awal kontainer yang sedang tampil
                                const startH = box ? box.offsetHeight : 0;

                                // 2. Kunci tinggi saat ini agar tidak melompat ketika state Alpine berubah
                                if (box && startH > 0) {
                                    box.style.height = startH + 'px';
                                    box.style.overflow = 'hidden';
                                }

                                // 3. Nonaktifkan scroll-smooth bawaan sementara agar scrollBy sinkron instan per frame
                                const htmlEl = document.documentElement;
                                const hadScrollSmooth = htmlEl.classList.contains('scroll-smooth');
                                if (hadScrollSmooth) htmlEl.classList.remove('scroll-smooth');

                                // 4. Ubah state Alpine
                                this.expanded = !this.expanded;

                                // Bila dibuka, beritahu dropdown pojok lainnya agar otomatis tertutup
                                if (this.expanded) {
                                    window.dispatchEvent(new CustomEvent('close-other-pojoks', { detail: { id: {{ $pojok->id }} } }));
                                }

                                // 5. Tunggu $nextTick agar view target dirender di DOM (display:none diangkat oleh Alpine)
                                this.$nextTick(() => {
                                    if (!box) {
                                        this.isAnimating = false;
                                        return;
                                    }

                                    const targetView = this.expanded ? this.$refs.view2 : this.$refs.view1;
                                    let endH = targetView ? Math.max(targetView.offsetHeight, targetView.scrollHeight) : startH;

                                    // Hormati min-height desktop jika ada
                                    const computedMinH = parseFloat(window.getComputedStyle(box).minHeight) || 0;
                                    if (computedMinH > endH) {
                                        endH = computedMinH;
                                    }

                                    // Jalankan loop animasi RAF dengan interpolasi kontinu easeOutCubic
                                    const startTime = performance.now();
                                    const duration = 380;

                                    const animateLoop = (now) => {
                                        const elapsed = now - startTime;
                                        const progress = Math.min(elapsed / duration, 1);

                                        // Kurva cubic-bezier / easeOutCubic halus: 1 - (1 - progress)^3
                                        const ease = 1 - Math.pow(1 - progress, 3);
                                        const currentH = startH + (endH - startH) * ease;

                                        box.style.height = currentH.toFixed(2) + 'px';

                                        // Kompensasi scroll layar: kunci posisi tombol di viewport persis pada targetTop
                                        if (btn && targetTop !== null) {
                                            const currentTop = btn.getBoundingClientRect().top;
                                            const diff = currentTop - targetTop;
                                            if (Math.abs(diff) > 0.2) {
                                                window.scrollBy(0, diff);
                                            }
                                        }

                                        if (progress < 1) {
                                            this.pinRafId = requestAnimationFrame(animateLoop);
                                        } else {
                                            // Selesai: kembalikan ke tinggi alami/otomatis
                                            box.style.height = '';
                                            box.style.overflow = '';

                                            // Penyesuaian akhir tombol agar posisi targetTop terkunci sempurna
                                            if (btn && targetTop !== null) {
                                                const finalDiff = btn.getBoundingClientRect().top - targetTop;
                                                if (Math.abs(finalDiff) > 0.2) {
                                                    window.scrollBy(0, finalDiff);
                                                }
                                            }

                                            if (hadScrollSmooth) {
                                                htmlEl.classList.add('scroll-smooth');
                                            }

                                            this.pinRafId = null;
                                            this.isAnimating = false;
                                        }
                                    };

                                    this.pinRafId = requestAnimationFrame(animateLoop);
                                });
                            }
                        }"
                        @close-other-pojoks.window="if ($event.detail.id !== {{ $pojok->id }} && expanded) closeDropdown()"
                        class="lg:col-span-7 order-2 {{ $isEven ? 'lg:order-2' : 'lg:order-1' }} flex flex-col justify-start space-y-3 sm:space-y-6">

                        <!-- HEADER: DISPLAY NUMBER (01, 02, ...) + TITLE POJOK -->
                        <div class="pojok-header-wrap flex items-center sm:items-baseline gap-2.5 sm:gap-5 lg:gap-6 w-full min-w-0">
                            <span class="pojok-num-text harmoni-num-animate select-none font-sans font-black leading-tight sm:leading-none tracking-tight shrink-0 {{ $isUmkmGoDigital ? 'pojok-num-umkm' : 'pojok-num-standard' }} {{ $isDark ? 'text-white' : 'text-[#20332A]' }}">
                                {{ sprintf('%02d', $loop->iteration) }}
                            </span>
                            <h2 class="pojok-title-text harmoni-text-animate font-sans font-black leading-tight sm:leading-none tracking-tight {{ $isUmkmGoDigital ? 'pojok-title-umkm' : 'pojok-title-standard whitespace-normal sm:whitespace-nowrap' }} {{ $isDark ? 'text-white' : 'text-[#20332A]' }}">
                                {{ $pojok->nama }}
                            </h2>
                        </div>

                        <!-- AREA KONTEN UTAMA DENGAN TRANSISI TINGGI YANG KONTINU & MULUS -->
                        <div x-ref="contentBox" style="overflow-anchor: none;"
                            class="relative w-full grid grid-cols-1 grid-rows-1 items-start min-h-0 sm:min-h-[280px] md:min-h-[220px] lg:min-h-[200px]">

                            <!-- VIEW 1: TEKS DESKRIPSI POJOK (DEFAULT) -->
                            <div x-ref="view1" x-show="!expanded"
                                x-transition:enter="transition-opacity duration-300 ease-out"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-180 ease-in pointer-events-none"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="col-start-1 row-start-1 w-full flow-root grid grid-cols-1 {{ !empty($detailKanan) ? 'md:grid-cols-2' : '' }} gap-7 lg:gap-10 pt-2">
                                <!-- Kolom Kiri: Narasi Asli dari Database -->
                                <div class="harmoni-desc-animate">
                                    <div class="text-xs sm:text-[14px] lg:text-[14.5px] leading-relaxed text-justify font-normal space-y-2.5 [&>p]:leading-relaxed [&>ul]:list-disc [&>ul]:list-inside [&>ol]:list-decimal [&>ol]:list-inside [&>a]:underline {{ $isDark ? 'text-white/90 [&>a]:text-emerald-300 hover:[&>a]:text-white' : 'text-slate-800 [&>a]:text-[#0A3D29] hover:[&>a]:text-[#145C3B]' }}">
                                        {!! $narasiDesc !!}
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Fokus Pembelajaran & Mitra Asli dari Database -->
                                @if(!empty($detailKanan))
                                    <div class="harmoni-desc-animate harmoni-desc-delay">
                                        <div class="text-xs sm:text-[14px] lg:text-[14.5px] leading-relaxed font-normal space-y-2.5 [&>p]:leading-relaxed [&>p]:mb-2.5 [&>p:last-child]:mb-0 [&>ul]:list-disc [&>ul]:list-inside [&>ol]:list-decimal [&>ol]:list-inside {{ $isDark ? 'text-white/85 [&>p>strong]:text-white' : 'text-slate-700 [&>p>strong]:text-[#20332A]' }}">
                                            {!! $detailKanan !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- VIEW 2: KONTEN MODUL AJAR & RINCIAN LENGKAP (EXPANDED) -->
                            <div x-ref="view2" x-show="expanded" x-cloak
                                x-transition:enter="transition-opacity duration-300 ease-out delay-100"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-180 ease-in pointer-events-none"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="col-start-1 row-start-1 w-full flow-root pt-1 pb-2">

                                @if($pojok->kurikulums->isNotEmpty() || !empty($mitraKomunitas))
                                    <div class="flex flex-col gap-4 w-full pt-1">

                                        {{-- Informasi Mitra Komunitas (Tampil Pertama di Mobile & Desktop) --}}
                                        @if(!empty($mitraKomunitas))
                                            <div class="w-full order-1">
                                                <div class="h-px w-full {{ $isDark ? 'bg-white/15' : 'bg-[#DCE6DA]' }} mb-2.5"></div>
                                                <div class="pr-2">
                                                    <h5 class="font-bold text-sm sm:text-base leading-snug {{ $isDark ? 'text-white' : 'text-[#20332A]' }} mb-2">
                                                        {{ $mitraKomunitas['title'] }} :
                                                    </h5>

                                                    @if($mitraKomunitas['type'] === 'numbered')
                                                        <ol class="text-xs sm:text-[13.5px] leading-relaxed space-y-1.5 pl-5 list-decimal {{ $isDark ? 'text-white/85' : 'text-slate-700' }} {{ count($mitraKomunitas['items']) > 6 ? 'grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 pl-6' : '' }}">
                                                            @foreach($mitraKomunitas['items'] as $item)
                                                                <li>{{ $item }}</li>
                                                            @endforeach
                                                        </ol>
                                                    @else
                                                        <ul class="text-xs sm:text-[13.5px] leading-relaxed space-y-1.5 pl-5 list-disc {{ $isDark ? 'text-white/85' : 'text-slate-700' }}">
                                                            @foreach($mitraKomunitas['items'] as $item)
                                                                <li>{{ $item }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Modul Ajar / File Unduhan (Tampil Kedua di Mobile & Desktop) --}}
                                        @if($pojok->kurikulums->isNotEmpty())
                                            <div class="w-full flex flex-col gap-4 order-2">
                                                @foreach($pojok->kurikulums as $file)
                                                    <div class="w-full">
                                                        <div class="h-px w-full {{ $isDark ? 'bg-white/15' : 'bg-[#DCE6DA]' }} mb-2.5"></div>
                                                        <div class="flex items-start justify-between gap-4">
                                                            <div class="min-w-0 flex-1 pr-2">
                                                                <h5 class="font-bold text-sm sm:text-base leading-snug {{ $isDark ? 'text-white' : 'text-[#20332A]' }}">
                                                                    {{ $file->judul }}
                                                                </h5>
                                                                @if(!empty($file->deskripsi))
                                                                    <p class="italic text-xs sm:text-[13px] leading-relaxed pt-0.5 {{ $isDark ? 'text-white/75' : 'text-slate-600' }}">
                                                                        {{ $file->deskripsi }}
                                                                    </p>
                                                                @endif
                                                                <span class="block font-bold text-xs sm:text-sm tracking-tight pt-1.5 {{ $isDark ? 'text-emerald-300' : 'text-[#0A3D29]' }}">
                                                                    {{ $file->formatted_file_size }}
                                                                </span>
                                                            </div>

                                                            <div class="shrink-0 flex flex-col items-end gap-1.5 pt-0.5">
                                                                <a href="{{ route('public.ppko.kurikulum.download', $file) }}"
                                                                    class="w-22 sm:w-24 inline-flex items-center justify-center gap-1.5 py-1 px-2.5 rounded-md {{ $isDark ? 'bg-white hover:bg-emerald-50 text-[#0A3D29]' : 'bg-[#0A3D29] hover:bg-[#145C3B] text-white' }} active:scale-95 font-semibold text-xs transition shadow-2xs">
                                                                    <svg class="w-3.5 h-3.5 {{ $isDark ? 'text-[#0A3D29]' : 'text-emerald-300' }} shrink-0"
                                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                    </svg>
                                                                    <span>Unduh</span>
                                                                </a>

                                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                    target="_blank" rel="noopener noreferrer"
                                                                    class="w-22 sm:w-24 inline-flex items-center justify-center gap-1.5 py-1 px-2.5 rounded-md {{ $isDark ? 'bg-white/10 hover:bg-white/20 text-white border border-white/30 hover:border-white' : 'bg-white hover:bg-[#EAF1E8] text-[#0A3D29] border border-[#0A3D29]/30 hover:border-[#0A3D29]' }} active:scale-95 font-semibold text-xs transition shadow-2xs">
                                                                    <svg class="w-3.5 h-3.5 {{ $isDark ? 'text-white' : 'text-[#0A3D29]' }} shrink-0"
                                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    <span>Lihat</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                @else
                                    <div class="text-xs py-3.5 italic rounded-lg px-4 border border-dashed {{ $isDark ? 'text-white/70 bg-white/5 border-white/20' : 'text-slate-600 bg-[#F4F6F5] border-[#DCE6DA]' }}">
                                        Modul ajar akan segera diperbarui oleh admin.
                                    </div>
                                @endif

                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <div class="mt-3 pt-2 border-t {{ $isDark ? 'border-white/15' : 'border-[#DCE6DA]' }} flex justify-end">
                                            <a href="{{ route('admin.ppko.edit', $pojok) }}"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-md transition {{ $isDark ? 'bg-white/15 hover:bg-white/25 text-white border border-white/20' : 'bg-[#EAF1E8] hover:bg-[#d5e5d1] text-[#0A3D29]' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span>Kelola Modul</span>
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                        </div>

                        <!-- TRIGGER BAR DI BAGIAN BAWAH: GARIS HORIZONTAL DI ATAS, TEKS & ARROW DI BAWAH GARIS -->
                        <div class="pt-4 sm:pt-6 w-full flex flex-col items-center harmoni-desc-animate harmoni-desc-delay-2">
                            <div class="h-px w-full {{ $isDark ? 'bg-white/15' : 'bg-[#DCE6DA]' }} mb-3"></div>

                            <button type="button" @click="toggleExpanded($el)"
                                class="inline-flex items-center justify-center gap-2 cursor-pointer select-none group focus:outline-none pt-0.5 pb-1 px-4"
                                title="Klik untuk membuka/menutup selengkapnya">
                                <span class="font-sans font-bold italic text-xs sm:text-sm lg:text-[15px] tracking-tight transition-colors {{ $isDark ? 'text-white group-hover:text-emerald-300' : 'text-[#20332A] group-hover:text-[#0A3D29]' }}">
                                    Pelajari selengkapnya tentang {{ strtolower($pojok->nama) }}
                                </span>

                                <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px] transform transition-transform duration-300 ease-out stroke-[2.5] transition-colors {{ $isDark ? 'text-white/70 group-hover:text-emerald-300' : 'text-slate-500 group-hover:text-[#0A3D29]' }}"
                                    :class="expanded ? 'rotate-180 {{ $isDark ? 'text-emerald-300' : 'text-[#0A3D29]' }}' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- VISUAL COLUMN: RECTANGULAR EDGE-BLEED SLIDER (Mepet Ujung Halaman pada Desktop) -->
                    <div class="lg:col-span-5 order-1 {{ $isEven ? 'lg:order-1' : 'lg:order-2' }} flex flex-col justify-center pt-0 sm:pt-2 lg:pt-0 pb-0 w-full">

                        <div x-data="{
                            currentIndex: 1,
                            realIndex: 0,
                            enableTransition: true,
                            isTransitioning: false,
                            touchStartX: 0,
                            touchStartY: 0,
                            swiped: false,
                            timer: null,
                            init() {
                                this.startAuto();
                            },
                            startAuto() {
                                if (this.timer) clearInterval(this.timer);
                                this.timer = setInterval(() => {
                                    this.next();
                                }, 4500);
                            },
                            pause() {
                                if (this.timer) clearInterval(this.timer);
                            },
                            resume() {
                                this.startAuto();
                            },
                            next() {
                                if (this.isTransitioning) return;
                                this.isTransitioning = true;
                                this.enableTransition = true;
                                this.currentIndex++;
                                this.realIndex = (this.currentIndex - 1) % 3;
                                if (this.currentIndex === 4) {
                                    this.realIndex = 0;
                                    setTimeout(() => {
                                        this.enableTransition = false;
                                        this.currentIndex = 1;
                                        setTimeout(() => {
                                            this.enableTransition = true;
                                            this.isTransitioning = false;
                                        }, 50);
                                    }, 500);
                                } else {
                                    setTimeout(() => {
                                        this.isTransitioning = false;
                                    }, 500);
                                }
                            },
                            prev() {
                                if (this.isTransitioning) return;
                                this.isTransitioning = true;
                                this.enableTransition = true;
                                this.currentIndex--;
                                this.realIndex = (this.currentIndex - 1 + 3) % 3;
                                if (this.currentIndex === 0) {
                                    this.realIndex = 2;
                                    setTimeout(() => {
                                        this.enableTransition = false;
                                        this.currentIndex = 3;
                                        setTimeout(() => {
                                            this.enableTransition = true;
                                            this.isTransitioning = false;
                                        }, 50);
                                    }, 500);
                                } else {
                                    setTimeout(() => {
                                        this.isTransitioning = false;
                                    }, 500);
                                }
                            },
                            goTo(idx) {
                                if (this.isTransitioning) return;
                                this.isTransitioning = true;
                                this.enableTransition = true;
                                this.currentIndex = idx + 1;
                                this.realIndex = idx;
                                setTimeout(() => {
                                    this.isTransitioning = false;
                                }, 500);
                            },
                            handleTouchStart(e) {
                                this.pause();
                                this.swiped = false;
                                this.touchStartX = e.touches[0].clientX;
                                this.touchStartY = e.touches[0].clientY;
                            },
                            handleTouchEnd(e) {
                                const diffX = e.changedTouches[0].clientX - this.touchStartX;
                                const diffY = e.changedTouches[0].clientY - this.touchStartY;
                                if (Math.abs(diffX) > 30 && Math.abs(diffX) > Math.abs(diffY)) {
                                    this.swiped = true;
                                    if (diffX < 0) {
                                        this.next();
                                    } else {
                                        this.prev();
                                    }
                                }
                                this.resume();
                            }
                        }" @mouseenter="pause()" @mouseleave="resume()" class="harmoni-cards-animate w-full">

                            <!-- RECTANGULAR SLIDER FRAME (16:9 Pipih pada Mobile, Tetap pada Desktop) -->
                            <div class="pojok-slider-frame relative overflow-hidden bg-slate-900/10 select-none touch-pan-y group shadow-xs rounded-xl border {{ $isDark ? 'border-white/10' : 'border-[#DCE6DA]' }}"
                                @touchstart.passive="handleTouchStart($event)"
                                @touchend="handleTouchEnd($event)">

                                <!-- Horizontal Track Sliding with Infinite Seamless Loop -->
                                <div class="flex h-full w-full ease-out"
                                    :class="enableTransition ? 'transition-transform duration-500' : ''"
                                    :style="'transform: translateX(-' + (currentIndex * 100) + '%);'">

                                    <!-- Slide Clone 3 (Prepend for seamless backward wrap) -->
                                    <div class="w-full h-full shrink-0 relative">
                                        <img src="{{ $cardImg3 }}" alt="Foto 3 {{ $pojok->nama }}" loading="lazy" decoding="async" class="w-full h-full object-cover select-none pointer-events-none" draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none"></div>
                                    </div>

                                    <!-- Slide 1 -->
                                    <div class="w-full h-full shrink-0 relative">
                                        <img src="{{ $cardImg1 }}" alt="Foto 1 {{ $pojok->nama }}" loading="lazy" decoding="async" class="w-full h-full object-cover select-none pointer-events-none" draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none"></div>
                                    </div>

                                    <!-- Slide 2 -->
                                    <div class="w-full h-full shrink-0 relative">
                                        <img src="{{ $cardImg2 }}" alt="Foto 2 {{ $pojok->nama }}" loading="lazy" decoding="async" class="w-full h-full object-cover select-none pointer-events-none" draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none"></div>
                                    </div>

                                    <!-- Slide 3 -->
                                    <div class="w-full h-full shrink-0 relative">
                                        <img src="{{ $cardImg3 }}" alt="Foto 3 {{ $pojok->nama }}" loading="lazy" decoding="async" class="w-full h-full object-cover select-none pointer-events-none" draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none"></div>
                                    </div>

                                    <!-- Slide Clone 1 (Append for seamless forward wrap) -->
                                    <div class="w-full h-full shrink-0 relative">
                                        <img src="{{ $cardImg1 }}" alt="Foto 1 {{ $pojok->nama }}" loading="lazy" decoding="async" class="w-full h-full object-cover select-none pointer-events-none" draggable="false">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none"></div>
                                    </div>
                                </div>

                                <!-- Overlay Click-to-Slide Arrows on Desktop Only (Minimalis, Tampil Saat Hover di Desktop) -->
                                <button type="button" @click.stop="prev()"
                                    class="pojok-slider-btn pojok-slider-prev" title="Foto Sebelumnya"
                                    aria-label="Foto Sebelumnya">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                <button type="button" @click.stop="next()"
                                    class="pojok-slider-btn pojok-slider-next" title="Foto Berikutnya"
                                    aria-label="Foto Berikutnya">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- DESKRIPSI GAMBAR KECIL DENGAN ANIMASI FADE IN & FADE OUT HALUS & INDIKATOR SLIDING (TANPA PANAH BAWAH) -->
                            <div class="pojok-slider-desc-bar flex items-center justify-between gap-3.5 px-1.5">

                                <!-- Bagian Kiri: Teks Deskripsi Gambar -->
                                <div class="relative flex-1 min-h-[34px] sm:min-h-[38px] grid grid-cols-1 grid-rows-1 items-center overflow-hidden">
                                    @foreach($cardDescs as $idx => $desc)
                                        <div x-show="realIndex === {{ $idx }}"
                                            x-transition:enter="transition-opacity duration-300 ease-out delay-150"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-150 ease-in"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="col-start-1 row-start-1 flex items-center pr-2">

                                            <p class="text-xs sm:text-[13px] leading-snug font-medium italic {{ $isDark ? 'text-white/85' : 'text-slate-600' }} line-clamp-2">
                                                {{ $desc }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Bagian Kanan: Indikator Titik Slider (Dots) -->
                                <div class="flex items-center gap-1.5 shrink-0 select-none py-1">
                                    @foreach([0, 1, 2] as $idx)
                                        <button type="button" @click.stop="goTo({{ $idx }})"
                                            class="h-1.5 rounded-sm transition-all duration-300"
                                            :class="realIndex === {{ $idx }} ? '{{ $isDark ? 'w-5 bg-white' : 'w-5 bg-[#0A3D29]' }}' : '{{ $isDark ? 'w-1.5 bg-white/35 hover:bg-white/60' : 'w-1.5 bg-[#DCE6DA] hover:bg-[#7D9B78]' }}'"
                                            title="Foto {{ $idx + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tombol Kelola Foto & Deskripsi Khusus Admin -->
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="mt-3 flex justify-center">
                                        <a href="{{ route('admin.ppko.edit', $pojok) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-xs transition hover:scale-105 active:scale-95 {{ $isDark ? 'bg-white hover:bg-slate-100 text-[#0A3D29]' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                                            <svg class="w-3.5 h-3.5 {{ $isDark ? 'text-[#0A3D29]' : 'text-emerald-400' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            <span>Kelola 3 Foto & Deskripsi</span>
                                        </a>
                                    </div>
                                @endif
                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
</div>
</div>
