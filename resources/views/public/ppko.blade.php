@extends('layouts.public')

@section('title', 'PPKO Catur Cerdas UMS 2026 – Program Pemberdayaan Desa Catur')

@section('meta_description', 'Dokumentasi dan profil resmi Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) Catur Cerdas UMS di Desa Catur, Sambi, Boyolali.')

@section('content')

<!-- Alpine Lightbox Modal Component Scope -->
<div x-data="{
    lightboxOpen: false,
    activeImg: '',
    activeTitle: '',
    activePojok: '',
    activeCaption: '',
    activeDate: '',
    openLightbox(img, title, pojok, caption, date) {
        this.activeImg = img;
        this.activeTitle = title;
        this.activePojok = pojok;
        this.activeCaption = caption;
        this.activeDate = date;
        this.lightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
        this.lightboxOpen = false;
        document.body.style.overflow = 'auto';
    }
}" @keydown.escape.window="closeLightbox()">

    <!-- Main Container: Clean White Background with subtle sage accents (#DCE6DA) -->
    <div class="bg-white min-h-screen">
        <div class="pt-6 sm:pt-8 pb-10 sm:pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 sm:space-y-14">
            
            <!-- ========================================================================= -->
            <!-- 1. TOP SECTION: COVER PPKO ONLY (Gambar Saja, Tanpa Route / Breadcrumbs) -->
            <!-- ========================================================================= -->
            @php
                $coverCandidates = [
                    'images/assets/cover ppko.png',
                    'images/assets/cover_ppko.png',
                    'assets/images/cover ppko.png',
                    'assets/images/cover_ppko.png',
                    'images/ppko/cover ppko.png',
                    'images/ppko/cover_ppko.png',
                    'images/cover ppko.png',
                    'images/cover_ppko.png',
                ];
                $ppkoCoverUrl = null;
                foreach ($coverCandidates as $candidate) {
                    if (file_exists(public_path($candidate))) {
                        $ppkoCoverUrl = asset($candidate);
                        break;
                    }
                }
                if (!$ppkoCoverUrl) {
                    $ppkoCoverUrl = asset('images/cover_ppko.png');
                }
            @endphp
            <div class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-[#DCE6DA] bg-white group">
                <img src="{{ $ppkoCoverUrl }}" 
                     alt="Cover Banner PPKO Catur Cerdas UMS 2026 Desa Catur" 
                     class="w-full h-auto object-cover object-center group-hover:scale-[1.005] transition-transform duration-700 ease-out">
            </div>

            <!-- ===================================================================== -->
            <!-- 2. LATAR BELAKANG & POTENSI DESA (PRD Section 4.1 #2) -->
            <!-- ===================================================================== -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-4">

                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                        Transformasi Terpadu Berbasis Potensi Lokal Desa Catur
                    </h2>

                    <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        <p>
                            Desa Catur yang terletak di Kecamatan Sambi, Kabupaten Boyolali, memiliki bentang agraris yang subur serta kehangatan ikatan sosial kemasyarakatan yang kuat. Mayoritas masyarakat bertumpu pada sektor pertanian padi dan palawija serta geliat usaha mikro rumahan (UMKM).
                        </p>
                        <p>
                            Namun di tengah era keterbukaan informasi dan kemajuan teknologi, terdapat tantangan nyata pada akselerasi literasi digital warga, kemudahan administrasi layanan mandiri, ruang baca kreatif bagi anak-anak desa, dan pendampingan pemasaran online produk UMKM lokal.
                        </p>
                        <p>
                            Program <strong>Catur Cerdas</strong> hadir sebagai jembatan kemitraan strategis antara inisiatif mahasiswa IMM Al-Ghazali Fakultas Psikologi Universitas Muhammadiyah Surakarta bersama Pemerintah Desa Catur guna mengoptimalkan potensi tersebut ke dalam <strong>5 Pilar Pojok Pemberdayaan</strong>.
                        </p>
                    </div>

                    <!-- Checklist Values -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs sm:text-sm text-slate-700 font-medium">
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-md bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center shrink-0 font-bold">✓</span>
                            <span>Transparansi Pelayanan Publik Desa</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-md bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center shrink-0 font-bold">✓</span>
                            <span>Peningkatan Literasi & Edukasi Anak</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-md bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center shrink-0 font-bold">✓</span>
                            <span>Pendampingan Go Digital UMKM</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-md bg-[#EAF1E8] text-[#0A3D29] flex items-center justify-center shrink-0 font-bold">✓</span>
                            <span>Pelestarian Adat & Budaya Lokal</span>
                        </div>
                    </div>
                </div>

                <!-- Info Card Pillar Summary -->
                <div class="lg:col-span-5 bg-white rounded-xl p-6 sm:p-7 border border-[#DCE6DA] shadow-xs space-y-5">
                    <h3 class="font-serif text-lg sm:text-xl font-bold text-slate-900 border-b border-[#DCE6DA]/60 pb-3">
                        Tiga Pendekatan Utama
                    </h3>

                    <div class="space-y-3.5">
                        <div class="flex items-start gap-3.5 p-3 rounded-lg bg-[#F9FAF8] border border-[#DCE6DA]">
                            <div class="w-8 h-8 rounded-md bg-[#0A3D29] text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                01
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Partisipatif & Inklusif</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                     Melibatkan seluruh elemen masyarakat desa: pemerintah desa, tokoh masyarakat, kelompok tani, pemuda, dan anak-anak.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3 rounded-lg bg-[#F9FAF8] border border-[#DCE6DA]">
                            <div class="w-8 h-8 rounded-md bg-[#145C3B] text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                02
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Inovasi Digital Berkelanjutan</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                    Membangun platform profil desa, portal mandiri layanan surat warga, dan integrasi perpustakaan digital.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3 rounded-lg bg-[#F9FAF8] border border-[#DCE6DA]">
                            <div class="w-8 h-8 rounded-md bg-[#D9B85C] text-[#061C12] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                03
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Kemandirian Pasca Program</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                    Pengalihan keterampilan operasional dan tata kelola sistem kepada aparatur desa demi keberlanjutan program.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- 3. QUICK JUMP POJOK NAVIGATION BAR (Akses Cepat 5 Pojok) -->
    <!-- ===================================================================== -->
    <!-- ===================================================================== -->
    <!-- 3. QUICK JUMP POJOK NAVIGATION BAR (Glassmorphism Capsule Island) -->
    <!-- ===================================================================== -->
    @php
        $pojokIcons = [
            // 1. Pojok Harmoni -> Ikon KELUARGA (Solid: Ayah, Ibu, Anak)
            1 => '<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="6" r="2.2"/><circle cx="17" cy="6" r="2.2"/><circle cx="12" cy="11.5" r="1.6"/><path d="M7 9.5C4.5 9.5 3 11 3 13.5V18h3.5v-3c0-.8.7-1.5 1.5-1.5h1c.8 0 1.5.7 1.5 1.5v3H21v-4.5c0-2.5-1.5-4-4-4h-1.2c-.7.9-1.8 1.5-3 1.5h-1.6c-1.2 0-2.3-.6-3-1.5H7zm5 4.5c-1.5 0-2.5 1-2.5 2.2V18h5v-1.8c0-1.2-1-2.2-2.5-2.2z"/></svg>',
            
            // 2. Pojok Ceria -> Ikon LITERASI (Solid: Buku Terbuka Membaca / Open Book)
            2 => '<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C10.2 3.4 8 3 6 3 4.2 3 2.6 3.5 1.5 4.3c-.3.2-.5.6-.5 1v13.2c0 .6.6 1.1 1.2.9C3.4 18.8 4.7 18.5 6 18.5c2 0 4.2.5 6 1.6 1.8-1.1 4-1.6 6-1.6 1.3 0 2.6.3 3.8.9.6.2 1.2-.3 1.2-.9V5.3c0-.4-.2-.8-.5-1C21.4 3.5 19.8 3 18 3c-2 0-4.2.4-6 1.5zm-1 12.3c-1.5-.9-3.3-1.3-5-1.3-1.3 0-2.6.3-3.5.7V6.1c1-.4 2.2-.6 3.5-.6 1.7 0 3.5.4 5 1.3v10z"/></svg>',
            
            // 3. Pojok UMKM -> Ikon KERANJANG (Solid: Shopping Basket Belanja)
            3 => '<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M17.21 9l-4.38-6.56a1 1 0 00-1.66 0L6.79 9H2.5c-.83 0-1.5.67-1.5 1.5 0 .24.06.47.16.67L3.4 19.2c.3.9 1.1 1.8 2.1 1.8h13c1 0 1.8-.9 2.1-1.8l2.24-8.03c.1-.2.16-.43.16-.67 0-.83-.67-1.5-1.5-1.5h-4.29zm-5.21-4.22L14.8 9H9.2l2.8-4.22zM12 17.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
            
            // 4. Pojok Budaya -> Ikon GAMELAN (Solid: Gong Gamelan Jawa dengan Gayor Penyangga)
            4 => '<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M2 3.5c0-.6.4-1 1-1h18c.6 0 1 .4 1 1v2.5H2V3.5z"/><path d="M3 6h2.5v13.5H3V6zm15.5 0H21v13.5h-2.5V6z"/><path d="M1.5 19.5h5.5c.3 0 .5.2.5.5V21H1v-1c0-.3.2-.5.5-.5zm15.5 0h5.5c.3 0 .5.2.5.5V21h-6.5v-1c0-.3.2-.5.5-.5z"/><path d="M9.5 6h1.2v3.5H9.5V6zm3.8 0h1.2v3.5h-1.2V6z"/><circle cx="12" cy="13.8" r="5.2"/><circle cx="12" cy="13.8" r="1.6" fill="white"/></svg>',
            
            // 5. Pojok Tani -> Ikon PADI (Solid: Bulir Padi Tangkai Sheaf)
            5 => '<svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c.8 1.4.8 3.1 0 4.5-.8-1.4-.8-3.1 0-4.5zm-2.8 4.2c1.5.7 2.4 2.1 2.4 3.8-1.6-.3-2.9-1.4-3.4-2.8.2-.4.6-.7 1-.9zm5.6 0c.4.2.8.5 1 .9-.5 1.4-1.8 2.5-3.4 2.8 0-1.7.9-3.1 2.4-3.8zM8.3 11c1.5.6 2.5 2 2.6 3.6-1.7-.2-3.1-1.2-3.7-2.7.3-.4.7-.7 1.1-.9zm7.4 0c.4.2.8.5 1.1.9-.6 1.5-2 2.5-3.7 2.7.1-1.6 1.1-3 2.6-3.6zM7.5 15.8c1.5.6 2.6 1.9 2.7 3.5-1.7-.1-3.2-1.1-3.8-2.5.3-.4.7-.7 1.1-1zm9 0c.4.3.8.6 1.1 1-.6 1.4-2.1 2.4-3.8 2.5.1-1.6 1.2-2.9 2.7-3.5zM11 18.5v3.5h2v-3.5h-2z"/></svg>',
        ];
    @endphp

    <div x-data="{
        activeSlug: 'harmoni',
        isJumping: false,
        jumpTimeout: null,
        scrollToPojok(slug) {
            this.activeSlug = slug;
            this.isJumping = true;
            clearTimeout(this.jumpTimeout);
            
            const el = document.getElementById(slug);
            if (el) {
                const headerOffset = 135;
                const elementPosition = el.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'auto'
                });
            }
            
            this.jumpTimeout = setTimeout(() => {
                this.isJumping = false;
            }, 300);
        },
        init() {
            const slugs = [
                @foreach($pojoks as $p)
                    '{{ Str::slug(str_replace('Pojok ', '', $p->nama)) }}',
                @endforeach
            ];
            const observer = new IntersectionObserver((entries) => {
                if (this.isJumping) return;
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.activeSlug = entry.target.id;
                    }
                });
            }, {
                rootMargin: '-25% 0px -55% 0px',
                threshold: 0.1
            });
            slugs.forEach(id => {
                const el = document.getElementById(id);
                if (el) observer.observe(el);
            });
        }
    }" class="md:hidden sticky top-[86px] sm:top-[96px] z-20 py-2 sm:py-3 pointer-events-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- MODE MOBILE: Kapsul Island Nav Kaca Buram Glassmorphism (Membiaskan + Latar Menggelap + Teks Berwarna) -->
            <div class="flex items-center justify-center">
                <div class="inline-flex items-center p-1 rounded-full bg-white/65 backdrop-blur-xl backdrop-saturate-150 border border-white/60 shadow-[0_8px_32px_0_rgba(10,61,41,0.08),0_1px_3px_0_rgba(0,0,0,0.04)] gap-1 max-w-full overflow-x-auto scrollbar-none [&::-webkit-scrollbar]:hidden pointer-events-auto"
                     style="scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch;">
                    @foreach($pojoks as $p)
                        @php
                            $slugId = Str::slug(str_replace('Pojok ', '', $p->nama));
                            $icon = $pojokIcons[$p->id] ?? $pojokIcons[1];
                        @endphp
                        <a href="#{{ $slugId }}" 
                           @click.prevent="scrollToPojok('{{ $slugId }}')"
                           class="inline-flex items-center gap-1.5 rounded-full py-1.5 transition-all duration-300 ease-in-out shrink-0 select-none"
                           :class="activeSlug === '{{ $slugId }}' 
                               ? 'bg-slate-900/[0.12] backdrop-blur-md text-[#0A3D29] font-bold shadow-2xs px-3.5' 
                               : 'bg-transparent text-slate-500 hover:text-slate-700 hover:bg-white/30 px-2.5'">
                            
                            <!-- Ikon Kapsul (Berwarna saat Aktif) -->
                            <span class="transition-colors duration-300 shrink-0"
                                  :class="activeSlug === '{{ $slugId }}' ? 'text-[#0A3D29]' : 'text-slate-500'">
                                {!! $icon !!}
                            </span>

                            <!-- Teks Kapsul (Berwarna saat Aktif, Melebar Halus) -->
                            <span class="overflow-hidden transition-all duration-300 ease-in-out text-xs whitespace-nowrap"
                                  :class="activeSlug === '{{ $slugId }}' ? 'max-w-[140px] opacity-100 text-[#0A3D29]' : 'max-w-0 opacity-0'">
                                {{ $p->nama }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- 4. SECTION DEDIKASI PER-POJOK (FULL-WIDTH STRIPES BERSELANG-SELING) -->
    <!-- ===================================================================== -->
    <style>
        @media (min-width: 768px) {
            .mask-fade-even {
                -webkit-mask-image: linear-gradient(to left, black 25%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.35) 75%, transparent 100%), linear-gradient(to top left, black 35%, rgba(0,0,0,0.7) 65%, transparent 100%);
                mask-image: linear-gradient(to left, black 25%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.35) 75%, transparent 100%), linear-gradient(to top left, black 35%, rgba(0,0,0,0.7) 65%, transparent 100%);
            }
            .mask-fade-odd {
                -webkit-mask-image: linear-gradient(to right, black 25%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.35) 75%, transparent 100%), linear-gradient(to top right, black 35%, rgba(0,0,0,0.7) 65%, transparent 100%);
                mask-image: linear-gradient(to right, black 25%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.35) 75%, transparent 100%), linear-gradient(to top right, black 35%, rgba(0,0,0,0.7) 65%, transparent 100%);
            }
        }
        @media (max-width: 767.98px) {
            .mask-fade-mobile {
                -webkit-mask-image: linear-gradient(to bottom, black 70%, rgba(0,0,0,0.75) 85%, transparent 100%);
                mask-image: linear-gradient(to bottom, black 70%, rgba(0,0,0,0.75) 85%, transparent 100%);
            }
        }
    </style>
    <div class="divide-y divide-[#DCE6DA] border-b border-[#DCE6DA]">
        @foreach($pojoks as $index => $pojok)
                    @php
                        $slugId = Str::slug(str_replace('Pojok ', '', $pojok->nama));
                        
                        // Theme mapping for each pojok to create an engaging display atmosphere
                        $themes = [
                            1 => [
                                'category' => 'Psikososial & Keluarga',
                                'sasaran' => 'Ibu-Ibu Caregiver Keluarga & Warga Desa',
                                'fokus' => ['Pelatihan Psychological First Aid (PFA)', 'Penguatan Komunikasi Keluarga & Caregiver', 'Dukungan Psikososial Komunitas'],
                                'defaultImage' => asset('images/cover_ppko.png'),
                                'kurikulumLabel' => 'Kurikulum',
                                'modulLabel' => 'Modul PFA',
                            ],
                            2 => [
                                'category' => 'Literasi & Edukasi Anak',
                                'sasaran' => 'Anak-Anak Komunitas TPA & Pelajar Desa',
                                'fokus' => ['Kegiatan Belajar Edukatif & Menyenangkan', 'Penguatan Literasi & Minat Baca', 'Tumbuh Kembang Karakter Anak'],
                                'defaultImage' => asset('images/remen_maos_mockup_clean.png'),
                                'kurikulumLabel' => 'Kurikulum',
                                'modulLabel' => 'Modul Edukasi Anak',
                            ],
                            3 => [
                                'category' => 'Digitalisasi Usaha & UMKM',
                                'sasaran' => 'Ibu-Ibu Pelaku Usaha Rumahan & Kerajinan',
                                'fokus' => ['Pemanfaatan WhatsApp Bisnis', 'Digital Marketing Produk Rumahan', 'Foto Produk & Kemasan Menarik'],
                                'defaultImage' => asset('images/coffee_processing.png'),
                                'kurikulumLabel' => 'Kurikulum',
                                'modulLabel' => 'Modul Digital UMKM',
                            ],
                            4 => [
                                'category' => 'Budaya & Karang Taruna',
                                'sasaran' => 'Remaja Desa Catur & Karang Taruna',
                                'fokus' => ['Pelestarian Seni & Tradisi Budaya', 'Pengembangan Potensi Remaja Desa', 'Kearifan Lokal di Era Digital'],
                                'defaultImage' => asset('images/culture_pura.png'),
                                'kurikulumLabel' => 'Kurikulum',
                                'modulLabel' => 'Modul Seni & Tradisi',
                            ],
                            5 => [
                                'category' => 'Pertanian & Gapoktan',
                                'sasaran' => 'Komunitas Gabungan Kelompok Tani (Gapoktan)',
                                'fokus' => ['Penguatan Pengetahuan Pertanian', 'Optimalisasi Potensi Lahan', 'Pertanian Ramah Lingkungan & Mandiri'],
                                'defaultImage' => asset('images/sawah_irigasi.png'),
                                'kurikulumLabel' => 'Kurikulum',
                                'modulLabel' => 'Modul Pertanian Sehat',
                            ],
                        ];
                        $t = $themes[$pojok->id] ?? $themes[1];

                        $isEven = ($loop->iteration % 2 === 0);

                        $mainImage = null;
                        if (!empty($pojok->gambar)) {
                            $mainImage = asset('storage/' . $pojok->gambar);
                        } else {
                            foreach($pojok->kegiatans as $keg) {
                                if ($keg->thumbnail) {
                                    $mainImage = asset('storage/' . $keg->thumbnail);
                                    break;
                                }
                                if ($keg->galeriFotos->isNotEmpty()) {
                                    $mainImage = asset('storage/' . $keg->galeriFotos->first()->file_path);
                                    break;
                                }
                            }
                        }
                        if (!$mainImage) {
                            $mainImage = $t['defaultImage'] ?? asset('images/cover_ppko.png');
                        }
                    @endphp

                    @php
                        $bgHex = $loop->odd ? '#F8FAFC' : '#FFFFFF';
                        $bgRgb = $loop->odd ? '248, 250, 252' : '255, 255, 255';
                    @endphp

                    <!-- POJOK SHOWCASE ROW (SINERGI GAMBAR FADE & OVERLAY SESUAI WARNA LATAR SECTION) -->
                    <section id="{{ $slugId }}" class="w-full relative overflow-hidden pt-0 pb-12 sm:pb-20 md:py-20 lg:py-24 scroll-mt-36 border-b border-[#E2E8F0]/80" style="background-color: {{ $bgHex }};">
                        
                        <!-- 1. GAMBAR (MODE MOBILE: BANNER DI ATAS RASIO PROPORSIONAL 16:10; DESKTOP: LATAR SAMPING 68%) -->
                        <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] md:aspect-auto md:absolute md:inset-y-0 {{ $isEven ? 'md:right-0 md:left-auto' : 'md:left-0 md:right-auto' }} md:w-[65%] lg:w-[68%] md:h-full overflow-hidden pointer-events-none {{ $isEven ? 'mask-fade-even' : 'mask-fade-odd' }} mask-fade-mobile">
                            <img src="{{ $mainImage }}" 
                                 alt="{{ $pojok->nama }}" 
                                 class="w-full h-full object-cover object-center {{ $isEven ? 'md:object-right' : 'md:object-left' }}">
                            <!-- Overlay gradasi mobile di bagian bawah foto agar menyatu mulus dengan warna latar section -->
                            <div class="absolute inset-x-0 bottom-0 h-20 sm:h-24 md:hidden pointer-events-none"
                                 style="background: linear-gradient(to bottom, transparent 0%, rgba({{ $bgRgb }}, 0.6) 45%, rgba({{ $bgRgb }}, 1) 100%);">
                            </div>
                        </div>

                        <!-- 2. OVERLAY WARNA LATAR SECTION DI DESKTOP YANG BERSINERGI MULUS DENGAN GAMBAR -->
                        @if(!$isEven)
                            <!-- POJOK GANJIL: Teks di Kanan, Gambar di Kiri, Warna #F8FAFC -->
                            <div class="absolute inset-0 pointer-events-none hidden md:block" 
                                 style="background: linear-gradient(to left, rgba({{ $bgRgb }}, 1) 0%, rgba({{ $bgRgb }}, 1) 36%, rgba({{ $bgRgb }}, 0.94) 50%, rgba({{ $bgRgb }}, 0.68) 68%, rgba({{ $bgRgb }}, 0.25) 84%, rgba({{ $bgRgb }}, 0) 100%), linear-gradient(to bottom, rgba({{ $bgRgb }}, 0.35) 0%, transparent 35%);">
                            </div>
                        @else
                            <!-- POJOK GENAP: Teks di Kiri, Gambar di Kanan, Warna Putih (#FFFFFF) -->
                            <div class="absolute inset-0 pointer-events-none hidden md:block" 
                                 style="background: linear-gradient(to right, rgba({{ $bgRgb }}, 1) 0%, rgba({{ $bgRgb }}, 1) 36%, rgba({{ $bgRgb }}, 0.94) 50%, rgba({{ $bgRgb }}, 0.68) 68%, rgba({{ $bgRgb }}, 0.25) 84%, rgba({{ $bgRgb }}, 0) 100%), linear-gradient(to bottom, rgba({{ $bgRgb }}, 0.35) 0%, transparent 35%);">
                            </div>
                        @endif

                        <!-- 3. TOMBOL GANTI FOTO ADMIN (Tetap mudah diakses di sudut gambar) -->
                        @auth
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('admin.pojoks.foto.update', $pojok) }}" method="POST" enctype="multipart/form-data" class="absolute top-4 {{ $isEven ? 'right-4 sm:right-6' : 'md:left-4 md:sm:left-6 right-4' }} z-20">
                                    @csrf
                                    <label for="input-foto-pojok-{{ $pojok->id }}" class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-900/85 hover:bg-slate-900 text-white text-xs font-semibold shadow-sm backdrop-blur-sm border border-white/20 transition-all hover:scale-105 active:scale-95">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Ganti Foto</span>
                                    </label>
                                    <input type="file" id="input-foto-pojok-{{ $pojok->id }}" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="if(this.files.length > 0) { this.form.submit(); }">
                                </form>
                            @endif
                        @endauth

                        <!-- 4. KONTEN DETAIL (BERSIH LANGSUNG DI ATAS WARNA LATAR SECTION) -->
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pt-4 md:pt-0">
                            <div class="flex {{ $isEven ? 'justify-start' : 'justify-end' }}">
                                <div class="w-full md:w-1/2 lg:w-5/12 space-y-4">
                                    
                                    <!-- Judul Pojok -->
                                    <div>
                                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                                            {{ $index + 1 }}. {{ $pojok->nama }}
                                        </h3>
                                    </div>

                                    <!-- Sasaran -->
                                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0A3D29]"></span>
                                        <span>Sasaran: {{ $t['sasaran'] }}</span>
                                    </div>

                                    <!-- Deskripsi Singkat -->
                                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                        {{ $pojok->deskripsi_singkat }}
                                    </p>

                                    <!-- Tombol Kurikulum & Modul -->
                                    @php
                                        $kurikulumDoc = $pojok->kurikulums->first(function($k) {
                                            return stripos($k->judul, 'kurikulum') !== false || stripos($k->judul, 'silabus') !== false;
                                        }) ?? $pojok->kurikulums->first();

                                        $modulDoc = $pojok->kurikulums->first(function($k) use ($kurikulumDoc) {
                                            return (!$kurikulumDoc || $k->id !== $kurikulumDoc->id) && 
                                                   (stripos($k->judul, 'modul') !== false || stripos($k->judul, 'panduan') !== false || stripos($k->judul, 'pfa') !== false);
                                        }) ?? ($pojok->kurikulums->count() > 1 ? $pojok->kurikulums->skip(1)->first() : null);
                                    @endphp

                                    <div class="flex flex-wrap items-center gap-3 pt-2">
                                        <!-- Tombol Kurikulum -->
                                        @if($kurikulumDoc)
                                            <a href="{{ route('public.ppko.kurikulum.download', $kurikulumDoc) }}" 
                                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#0A3D29] hover:bg-[#145C3B] text-white shadow-2xs hover:shadow-xs text-xs font-bold transition-all group">
                                                <svg class="w-3.5 h-3.5 text-[#D9B85C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                <span>{{ $t['kurikulumLabel'] }}</span>
                                                <svg class="w-3.5 h-3.5 opacity-70 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        @else
                                            <a href="#galeri" 
                                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#0A3D29] hover:bg-[#145C3B] text-white shadow-2xs hover:shadow-xs text-xs font-bold transition-all group">
                                                <svg class="w-3.5 h-3.5 text-[#D9B85C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                <span>{{ $t['kurikulumLabel'] }}</span>
                                                <svg class="w-3.5 h-3.5 opacity-70 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @endif

                                        <!-- Tombol Modul -->
                                        @if($modulDoc)
                                            <a href="{{ route('public.ppko.kurikulum.download', $modulDoc) }}" 
                                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md {{ $loop->odd ? 'bg-white hover:bg-slate-50' : 'bg-[#F8FAFC] hover:bg-white' }} text-slate-800 border border-[#DCE6DA] shadow-2xs hover:shadow-xs text-xs font-semibold transition-all group">
                                                <svg class="w-3.5 h-3.5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                <span>{{ $t['modulLabel'] }}</span>
                                                <svg class="w-3.5 h-3.5 text-slate-500 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                        @else
                                            <a href="#galeri" 
                                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md {{ $loop->odd ? 'bg-white hover:bg-slate-50' : 'bg-[#F8FAFC] hover:bg-white' }} text-slate-800 border border-[#DCE6DA] shadow-2xs hover:shadow-xs text-xs font-semibold transition-all group">
                                                <svg class="w-3.5 h-3.5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                <span>{{ $t['modulLabel'] }}</span>
                                                <svg class="w-3.5 h-3.5 text-slate-500 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @endif

                                        @auth
                                            @if(auth()->user()->isAdmin())
                                                <div class="inline-flex items-center gap-2 ml-auto">
                                                    <a href="{{ route('admin.pojoks.edit', $pojok) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                                                        <span>Kelola</span>
                                                    </a>
                                                    <a href="{{ route('admin.kegiatans.create') }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs font-semibold transition">
                                                        <span>+ Kegiatan</span>
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

        <!-- ===================================================================== -->
        <!-- BAGIAN BAWAH: PERPUSTAKAAN, GALERI, DUKUNGAN, DAN PENUTUP -->
        <!-- ===================================================================== -->
        <div class="py-14 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

                <!-- ===================================================================== -->
                <!-- 5. PERPUSTAKAAN DIGITAL DESA CATUR (Showcase Unggulan) -->
                <!-- ===================================================================== -->
                <section id="perpustakaan" class="scroll-mt-36 bg-gradient-to-br from-[#0A3D29] via-[#145C3B] to-[#0A3D29] rounded-xl sm:rounded-2xl p-6 sm:p-10 text-white shadow-lg relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px]"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold bg-[#D9B85C] text-[#061C12] shadow-xs uppercase tracking-wider">
                            Pusat Literasi Daerah
                        </span>
                        <h3 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight text-white">
                            Perpustakaan Digital Desa Catur Cerdas
                        </h3>
                        <p class="text-sm sm:text-base text-emerald-100 leading-relaxed max-w-2xl font-normal">
                            Menghubungkan warga Desa Catur dengan ribuan koleksi buku digital, karya ilmiah, bacaan anak, dan panduan pertanian terapan secara daring 24/7.
                        </p>
                        <div class="pt-2">
                            <a href="https://desacaturbyl.perpustakaan.co.id/home.ks" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-white text-[#0A3D29] hover:bg-slate-100 text-xs sm:text-sm font-bold shadow-md transition">
                                <span>Buka Portal Perpustakaan Digital</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-4 bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/20 text-center space-y-2.5">
                        <span class="block font-serif text-3xl font-bold text-[#D9B85C]">Online</span>
                        <h4 class="text-sm font-bold text-white">Akses Katalog Terintegrasi</h4>
                        <p class="text-xs text-emerald-100">
                            Dapat diakses melalui gawai smartphone warga kapan pun dari rumah maupun balai desa.
                        </p>
                    </div>
                </div>
            </section>

            <!-- ===================================================================== -->
            <!-- 6. GALERI FOTO LAPANGAN (Sorotan Foto Dokumentasi Keseluruhan) -->
            <!-- ===================================================================== -->
            <section id="galeri" class="space-y-6 scroll-mt-32">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-[#0A3D29] uppercase tracking-wider bg-[#EAF1E8] px-3 py-1 rounded-md border border-[#0A3D29]/20">
                        <span>Sorotan Visual</span>
                    </div>
                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                        Galeri Dokumentasi Lapangan
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600">
                        Klik pada foto untuk memperbesar tampilan resolusi penuh dan melihat detail catatan kegiatan.
                    </p>
                </div>

                @if($galeriFotos->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                        @foreach($galeriFotos as $foto)
                            <div class="group relative aspect-square bg-slate-200 rounded-lg overflow-hidden cursor-pointer shadow-2xs hover:shadow-md transition"
                                 @click="openLightbox(
                                     '{{ asset('storage/' . $foto->file_path) }}',
                                     '{{ addslashes($foto->kegiatan->judul ?? 'PPKO Catur Cerdas') }}',
                                     '{{ addslashes($foto->kegiatan->pojok->nama ?? 'Pojok Pemberdayaan') }}',
                                     '{{ addslashes($foto->caption ?? ($foto->kegiatan->deskripsi ?? '')) }}',
                                     '{{ $foto->created_at->translatedFormat('d F Y') }}'
                                 )">
                                <img src="{{ asset('storage/' . $foto->file_path) }}" 
                                     alt="{{ $foto->caption ?? 'Dokumentasi PPKO Desa Catur' }}" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-2.5 text-white">
                                    <span class="text-[10px] font-bold text-[#D9B85C] uppercase tracking-wider">
                                        {{ $foto->kegiatan->pojok->nama ?? 'PPKO' }}
                                    </span>
                                    <p class="text-[11px] font-medium line-clamp-2 leading-tight">
                                        {{ $foto->caption ?: ($foto->kegiatan->judul ?? 'Dokumentasi') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-dashed border-slate-300 p-8 text-center max-w-md mx-auto">
                        <p class="text-xs text-slate-500">Galeri foto dokumentasi lapangan akan tampil otomatis setelah panitia mengunggah foto kegiatan.</p>
                    </div>
                @endif
            </section>

            <!-- ===================================================================== -->
            <!-- 7. DUKUNGAN & MITRA (PRD Section 4.1 #6) -->
            <!-- ===================================================================== -->
            <section class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-8 border border-[#DCE6DA] shadow-xs space-y-6">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#0A3D29]">Sinergi Lembaga</span>
                    <h3 class="font-serif text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900">
                        Dukungan & Kemitraan Strategis
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600">
                        Kolaborasi terpadu antara perguruan tinggi, pemerintah desa, pembimbing akademik, serta komunitas warga.
                    </p>
                </div>

                <!-- Stakeholder 4 Pillars -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-[#F9FAF8] rounded-xl p-4 sm:p-5 border border-[#DCE6DA] text-center space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-lg bg-[#0A3D29] text-white flex items-center justify-center font-bold text-xs">
                            UMS
                        </div>
                        <h4 class="font-serif font-bold text-sm text-slate-900">Universitas Muhammadiyah Surakarta</h4>
                        <p class="text-[11px] text-slate-500">IMM Al-Ghazali • Fakultas Psikologi UMS pelaksana utama program pengabdian.</p>
                    </div>

                    <div class="bg-[#F9FAF8] rounded-xl p-4 sm:p-5 border border-[#DCE6DA] text-center space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-lg bg-[#145C3B] text-white flex items-center justify-center font-bold text-xs">
                            DESA
                        </div>
                        <h4 class="font-serif font-bold text-sm text-slate-900">Pemerintah Desa Catur</h4>
                        <p class="text-[11px] text-slate-500">Kecamatan Sambi, Kabupaten Boyolali sebagai mitra lokus pemberdayaan.</p>
                    </div>

                    <div class="bg-[#F9FAF8] rounded-xl p-4 sm:p-5 border border-[#DCE6DA] text-center space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-lg bg-[#D9B85C] text-[#061C12] flex items-center justify-center font-bold text-xs">
                            DPL
                        </div>
                        <h4 class="font-serif font-bold text-sm text-slate-900">Dosen Pendamping Lapangan</h4>
                        <p class="text-[11px] text-slate-500">Supervisi akademik, transfer metodologi riset aksi, dan pendampingan lapangan.</p>
                    </div>

                    <div class="bg-[#F9FAF8] rounded-xl p-4 sm:p-5 border border-[#DCE6DA] text-center space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                            WARGA
                        </div>
                        <h4 class="font-serif font-bold text-sm text-slate-900">Komunitas & Karang Taruna</h4>
                        <p class="text-[11px] text-slate-500">Kelompok Tani, pelaku UMKM, kader Posyandu, serta pemuda Desa Catur.</p>
                    </div>
                </div>

                <!-- Existing Partners Logo (If any) -->
                @if(isset($partners) && $partners->isNotEmpty())
                    <div class="pt-4 border-t border-[#DCE6DA]/70 text-center">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-4">Mitra & Jaringan Pendukung</span>
                        <div class="flex flex-wrap items-center justify-center gap-6">
                            @foreach($partners as $partner)
                                <div class="h-10 flex items-center justify-center opacity-80 hover:opacity-100 transition" title="{{ $partner->name }}">
                                    @if($partner->logo_path)
                                        <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-8 max-w-[120px] object-contain">
                                    @else
                                        <span class="text-xs font-semibold text-slate-600">{{ $partner->name }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>

            <!-- ===================================================================== -->
            <!-- 8. PENUTUP & CALL TO ACTION (PRD Section 4.1 #7) -->
            <!-- ===================================================================== -->
            <section class="bg-gradient-to-br from-[#0A3D29] via-[#145C3B] to-[#0A3D29] rounded-xl sm:rounded-2xl p-6 sm:p-10 text-white text-center shadow-lg relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>

                <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold bg-[#D9B85C] text-[#061C12] shadow-xs uppercase tracking-wider">
                        Aksi Nyata Ormawa Indonesia
                    </span>
                    <h3 class="font-serif text-2xl sm:text-3xl font-extrabold leading-tight text-white">
                        Dukung Gerakan Berkelanjutan Desa Catur Cerdas
                    </h3>
                    <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-normal">
                        Kemandirian dan kecerdasan desa terwujud melalui partisipasi aktif setiap warga dan kepedulian generasi muda. Mari bersinergi dan berkontribusi untuk masa depan Desa Catur yang lebih berdaya.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                        <a href="{{ route('public.services.index') }}" class="px-5 py-2.5 rounded-lg bg-white text-[#0A3D29] hover:bg-slate-100 text-xs font-bold shadow-md transition">
                            Pusat Layanan Surat Warga
                        </a>
                        <a href="{{ route('public.news.index') }}" class="px-5 py-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition">
                            Warta Berita Desa Terkini
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

    <!-- ========================================================================= -->
    <!-- LIGHTBOX MODAL (Interactive Alpine.js) -->
    <!-- ========================================================================= -->
    <div x-show="lightboxOpen" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-[#041A12]/90 backdrop-blur-md transition-opacity"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Scrim backdrop click to close -->
        <div class="absolute inset-0" @click="closeLightbox()"></div>

        <!-- Modal Card Container -->
        <div class="relative z-10 bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl flex flex-col md:flex-row"
             @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Close Button -->
            <button type="button" 
                    @click="closeLightbox()" 
                    class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center transition text-sm">
                ✕
            </button>

            <!-- Image Area -->
            <div class="md:w-3/5 bg-black flex items-center justify-center min-h-[260px] max-h-[500px] md:max-h-none overflow-hidden">
                <template x-if="activeImg">
                    <img :src="activeImg" :alt="activeTitle" class="max-w-full max-h-full object-contain">
                </template>
                <template x-if="!activeImg">
                    <div class="text-slate-400 text-xs p-8 text-center">Tidak ada gambar pratinjau</div>
                </template>
            </div>

            <!-- Content Area -->
            <div class="md:w-2/5 p-6 sm:p-8 flex flex-col justify-between overflow-y-auto max-h-[400px] md:max-h-[560px]">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#EAF1E8] text-[#0A3D29]" x-text="activePojok"></span>
                        <span class="text-xs text-slate-400" x-text="activeDate"></span>
                    </div>

                    <h4 class="font-serif text-lg sm:text-xl font-bold text-slate-900 leading-snug" x-text="activeTitle"></h4>

                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2 whitespace-pre-line" x-text="activeCaption"></div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">PPKO Catur Cerdas 2026</span>
                    <button type="button" @click="closeLightbox()" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
