@extends('layouts.public')

@section('title', 'PPKO Catur Cerdas UMS 2026 – Program Pemberdayaan Desa Catur')

@section('meta_description', 'Dokumentasi dan profil resmi Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) Catur Cerdas UMS di Desa Catur, Sambi, Boyolali.')

@section('content')

<!-- Alpine Lightbox Modal & Floating Pojok Navigation Scope -->
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
    },
    
    // Floating Pojok Navigation State (Mobile)
    pojoks: [
        @foreach($pojoks as $p)
            {
                id: '{{ Str::slug(str_replace('Pojok ', '', $p->nama)) }}',
                nama: '{{ $p->nama }}'
            },
        @endforeach
    ],
    activeSlug: 'harmoni',
    activeName: 'Pojok Harmoni',
    inPojokSection: false,
    
    init() {
        this.updatePojokState();
        window.addEventListener('scroll', () => {
            this.updatePojokState();
        }, { passive: true });
    },
    
    updatePojokState() {
        const container = document.getElementById('katalog-pojok-container');
        if (!container) return;
        
        const rect = container.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        
        // Aktif jika viewport sedang berada di dalam lingkup seksi katalog pojok
        this.inPojokSection = (rect.top <= vh * 0.75 && rect.bottom >= vh * 0.25);
        
        if (this.inPojokSection) {
            let closestSlug = this.pojoks[0]?.id || 'harmoni';
            let minDistance = Infinity;
            
            this.pojoks.forEach(p => {
                const el = document.getElementById(p.id);
                if (el) {
                    const elRect = el.getBoundingClientRect();
                    const distance = Math.abs(elRect.top - 80);
                    if (distance < minDistance) {
                        minDistance = distance;
                        closestSlug = p.id;
                    }
                }
            });
            
            this.activeSlug = closestSlug;
            const currentPojok = this.pojoks.find(p => p.id === this.activeSlug);
            if (currentPojok) {
                this.activeName = currentPojok.nama;
            }
        }
    },
    
    getCurrentIndex() {
        const idx = this.pojoks.findIndex(p => p.id === this.activeSlug);
        return idx !== -1 ? idx : 0;
    },
    
    scrollToSlug(slug) {
        this.activeSlug = slug;
        const currentPojok = this.pojoks.find(p => p.id === slug);
        if (currentPojok) {
            this.activeName = currentPojok.nama;
        }
        const el = document.getElementById(slug);
        if (el) {
            const headerOffset = 70;
            const elementPosition = el.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    },
    
    nextPojok() {
        if (!this.inPojokSection) {
            this.scrollToSlug(this.pojoks[0].id);
            return;
        }
        const idx = this.getCurrentIndex();
        if (idx < this.pojoks.length - 1) {
            this.scrollToSlug(this.pojoks[idx + 1].id);
        } else {
            const nextEl = document.getElementById('galeri') || document.querySelector('footer');
            if (nextEl) {
                nextEl.scrollIntoView({ behavior: 'smooth' });
            }
        }
    },
    
    prevPojok() {
        if (!this.inPojokSection) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        const idx = this.getCurrentIndex();
        if (idx > 0) {
            this.scrollToSlug(this.pojoks[idx - 1].id);
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
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
                    'images/ppko/cover_ppko.png',
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

                $coverMobileCandidates = [
                    'images/ppko/cover_ppko_mobile.png',
                ];
                $ppkoCoverMobileUrl = null;
                foreach ($coverMobileCandidates as $candidate) {
                    if (file_exists(public_path($candidate))) {
                        $ppkoCoverMobileUrl = asset($candidate);
                        break;
                    }
                }
                if (!$ppkoCoverMobileUrl) {
                    $ppkoCoverMobileUrl = $ppkoCoverUrl;
                }
            @endphp
            <div class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-[#DCE6DA] bg-white group">
                <picture class="block w-full">
                    <source media="(max-width: 767px)" srcset="{{ $ppkoCoverMobileUrl }}">
                    <img src="{{ $ppkoCoverUrl }}" 
                         alt="Cover Banner PPKO Catur Cerdas UMS 2026 Desa Catur" 
                         class="w-full h-auto object-cover object-center group-hover:scale-[1.005] transition-transform duration-700 ease-out">
                </picture>
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
      <!-- ===================================================================== -->
    <!-- 3. SECTION DEDIKASI PER-POJOK (BERGAYA KARTU) -->
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
    <div id="katalog-pojok-container" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-6 sm:space-y-8">
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
                        $bgHex = '#F8FAFC';
                        $bgRgb = '248, 250, 252';
                    @endphp

                    <!-- POJOK SHOWCASE ROW (BERGAYA KARTU DENGAN PEMBUNGKUS ROUNDED-XL) -->
                    <section id="{{ $slugId }}" class="w-full relative overflow-hidden rounded-xl border border-[#DCE6DA] shadow-xs pt-0 pb-12 sm:pb-20 md:py-20 lg:py-24 scroll-mt-28 md:scroll-mt-36" style="background-color: {{ $bgHex }};">
                        
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

    <!-- ========================================================================= -->
    <!-- ========================================================================= -->
    <!-- FLOATING MOBILE BOTTOM DOCK: MORPHING CAPSULE (KEMBALI KE ATAS & POJOK NAVIGATOR) -->
    <!-- ========================================================================= -->
    <div class="fixed bottom-6 right-6 z-[99999] md:hidden font-sans pointer-events-auto flex items-center h-11 sm:h-12 rounded-full bg-white/80 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl text-[#0A3D29] overflow-hidden select-none p-0.5 transition-all duration-500 ease-out"
         :title="inPojokSection ? ('Pojok Aktif: ' + activeName) : 'Kembali ke Atas'">
        
        <!-- Bagian Melebar ke Samping saat Masuk Katalog Pojok (Indikator & Panah Bawah) -->
        <div class="flex items-center transition-all duration-500 ease-out overflow-hidden"
             :class="inPojokSection ? 'max-w-[260px] opacity-100' : 'max-w-0 opacity-0 pointer-events-none'">
            
            <!-- Keterangan Pojok (Indikator) -->
            <div class="pl-3.5 pr-2.5 sm:pl-4 sm:pr-3 py-1 flex items-center shrink-0">
                <span class="text-xs sm:text-sm font-bold tracking-tight text-[#0A3D29] whitespace-nowrap" x-text="activeName"></span>
            </div>

            <!-- Garis Pemisah Antara Indikator & Tombol Ke Bawah -->
            <div class="h-5 sm:h-6 w-px bg-[#0A3D29]/20 shrink-0"></div>

            <!-- Tombol Panah Ke Bawah (Kiri: Pojok Selanjutnya) -->
            <button type="button" 
                    @click="nextPojok()" 
                    class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center text-[#0A3D29] active:bg-slate-900/[0.18] active:scale-90 transition-all cursor-pointer shrink-0"
                    aria-label="Pojok Selanjutnya"
                    title="Pojok Selanjutnya">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Garis Pemisah Antara Tombol Bawah & Tombol Atas -->
            <div class="h-5 sm:h-6 w-px bg-[#0A3D29]/20 shrink-0"></div>
        </div>

        <!-- Tombol Panah Ke Atas / Kembali ke Atas (Selalu Tampil di Luar Maupun di Dalam Katalog Pojok) -->
        <button type="button" 
                @click="prevPojok()" 
                class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center text-[#0A3D29] active:bg-slate-900/[0.18] active:scale-90 transition-all cursor-pointer shrink-0"
                :aria-label="inPojokSection ? 'Pojok Sebelumnya / Kembali ke Atas' : 'Kembali ke Atas'"
                :title="inPojokSection ? 'Pojok Sebelumnya / Kembali ke Atas' : 'Kembali ke Atas'">
            <svg class="w-5 h-5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>

</div>

@endsection
