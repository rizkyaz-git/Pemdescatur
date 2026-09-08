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

                                this.$nextTick(() => {
                                    const sections = document.querySelectorAll('.ppko-section-entrance');
                                    if ('IntersectionObserver' in window) {
                                        const observer = new IntersectionObserver((entries, obs) => {
                                            entries.forEach(entry => {
                                                if (entry.isIntersecting) {
                                                    entry.target.classList.add('is-revealed');
                                                    obs.unobserve(entry.target);
                                                }
                                            });
                                        }, {
                                            root: null,
                                            rootMargin: '0px 0px -40px 0px',
                                            threshold: 0.05
                                        });
                                        sections.forEach(sec => observer.observe(sec));
                                    } else {
                                        sections.forEach(sec => sec.classList.add('is-revealed'));
                                    }
                                });
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
                    <div
                        class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-[#DCE6DA] bg-white group ppko-section-entrance">
                        <picture class="block w-full">
                            <source media="(max-width: 767px)" srcset="{{ $ppkoCoverMobileUrl }}">
                            <img src="{{ $ppkoCoverUrl }}" alt="Cover Banner PPKO Catur Cerdas UMS 2026 Desa Catur"
                                class="w-full h-auto object-cover object-center group-hover:scale-[1.005] transition-transform duration-700 ease-out">
                        </picture>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- 2. LATAR BELAKANG & POTENSI DESA (PRD Section 4.1 #2) -->
                    <!-- ========================================================================= -->
                    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start ppko-section-entrance">
                        <div id="ppko-left-panel" class="lg:col-span-7 space-y-4">

                            <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                                Tentang Program
                            </h2>

                            <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed font-normal"
                                style="text-align: justify;">
                                <div class="catur-cerdas space-y-4">
                                    <div class="intro">
                                        <p style="text-align: justify;">
                                            <strong>Catur Cerdas</strong> merupakan program PPKO Ormawa oleh
                                            <strong>IMM Al-Ghozali Fakultas Psikologi, Universitas Muhammadiyah
                                                Surakarta</strong>
                                            di Desa Catur, Kecamatan Sambi, Kabupaten Boyolali. Program ini hadir
                                            untuk mendorong masyarakat menjadi lebih berdaya, mandiri, dan mampu
                                            mengembangkan potensi desa secara berkelanjutan.
                                        </p>
                                    </div>

                                    <div class="background">
                                        <p style="text-align: justify;">
                                            Desa Catur memiliki potensi besar sekaligus berbagai tantangan dalam
                                            kesehatan mental keluarga, kapasitas anak dan remaja, digitalisasi UMKM,
                                            pelestarian budaya, serta pengembangan pertanian. Catur Cerdas hadir
                                            melalui lima pojok pemberdayaan yang dirancang sesuai kebutuhan masyarakat :
                                        </p>
                                    </div>

                                    <div class="programs py-1">
                                        <ol class="programs-list">
                                            <li class="program-item">
                                                <span class="program-num">1.</span>
                                                <span class="program-name">Pojok Harmoni</span>
                                                <span class="program-colon">:</span>
                                                <span class="program-desc">Penguatan kesehatan mental keluarga melalui
                                                    Psychological First Aid dan komunikasi keluarga.</span>
                                            </li>
                                            <li class="program-item">
                                                <span class="program-num">2.</span>
                                                <span class="program-name">Pojok Ceria</span>
                                                <span class="program-colon">:</span>
                                                <span class="program-desc">Ruang belajar dan literasi kreatif bagi anak-anak
                                                    komunitas TPA.</span>
                                            </li>
                                            <li class="program-item">
                                                <span class="program-num">3.</span>
                                                <span class="program-name">Pojok UMKM Go Digital</span>
                                                <span class="program-colon">:</span>
                                                <span class="program-desc">Pendampingan pemanfaatan WhatsApp Business dan
                                                    teknologi digital untuk pengembangan usaha.</span>
                                            </li>
                                            <li class="program-item">
                                                <span class="program-num">4.</span>
                                                <span class="program-name">Pojok Budaya</span>
                                                <span class="program-colon">:</span>
                                                <span class="program-desc">Penguatan peran remaja dan Karang Taruna dalam
                                                    mengenal serta mengembangkan budaya lokal.</span>
                                            </li>
                                            <li class="program-item">
                                                <span class="program-num">5.</span>
                                                <span class="program-name">Pojok Tani</span>
                                                <span class="program-colon">:</span>
                                                <span class="program-desc">Penguatan pengetahuan dan optimalisasi potensi
                                                    pertanian bersama kelompok tani.</span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="impact pt-1">
                                        <p style="text-align: justify;">
                                            Catur Cerdas tidak sekadar memberikan program, tetapi membangun
                                            pengetahuan, keterampilan, dan jejaring yang dapat terus dikembangkan
                                            masyarakat. Dukungan Pemerintah Desa Catur, Universitas Muhammadiyah
                                            Surakarta, dosen pendamping, mitra, dan komunitas menjadi bagian penting
                                            dalam mewujudkan keberlanjutan program.
                                        </p>
                                    </div>

                                    <div class="closing pt-1">
                                        <p style="text-align: justify;">
                                            Catur Cerdas percaya bahwa desa yang mandiri adalah desa yang mampu
                                            mengenali potensi, menghadapi tantangan, dan bergerak bersama.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Kanan: Detail Program, Mitra Program & Instagram Feed -->
                        <div class="lg:col-span-5 flex flex-col space-y-6">
                            <!-- Kartu 1: Detail Program & Mitra Program -->
                            <div id="ppko-detail-card"
                                class="bg-white rounded-xl border border-[#DCE6DA] shadow-xs p-5 sm:p-6 space-y-3 shrink-0">
                                <div class="flex items-center justify-between pb-3 border-b border-[#DCE6DA]">
                                    <h3 class="font-serif text-lg sm:text-xl font-bold text-slate-900 leading-tight">
                                        Detail Program
                                    </h3>
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.ppko.index') }}#kelola-detail-program"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-[#0A3D29] bg-[#EAF1E8] hover:bg-[#d5e5d1] px-2.5 py-1 rounded-md transition shadow-2xs"
                                                title="Kelola detail program di Admin PPKO">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Kelola</span>
                                            </a>
                                        @endif
                                    @endauth
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                                        <tbody class="text-slate-700">
                                            @forelse($programDetails ?? [] as $index => $detail)
                                                <tr
                                                    class="border-b border-[#DCE6DA] last:border-b-0 hover:bg-slate-50/60 transition-colors">
                                                    <td
                                                        class="py-3 pr-3 pl-0 font-bold text-slate-900 align-top w-[36%] sm:w-[32%] leading-relaxed">
                                                        {{ $detail->aspek }}
                                                    </td>
                                                    <td class="py-3 pl-2 pr-0 leading-relaxed align-top text-slate-700">
                                                        @php
                                                            $rawKeterangan = trim($detail->keterangan ?? '');
                                                            $lines = preg_split('/\r\n|\r|\n/', $rawKeterangan);
                                                            $hasNumberPrefix = false;
                                                            foreach ($lines as $line) {
                                                                if (preg_match('/^\s*(\d+)[\.\)]\s*(.+)$/', trim($line))) {
                                                                    $hasNumberPrefix = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp

                                                        @if($hasNumberPrefix)
                                                            <div class="space-y-2">
                                                                @foreach($lines as $line)
                                                                    @php
                                                                        $trimmed = trim($line);
                                                                    @endphp
                                                                    @if(preg_match('/^\s*(\d+)[\.\)]\s*(.+)$/', $trimmed, $m))
                                                                        <div class="grid grid-cols-[auto_1fr] gap-x-2.5 items-baseline">
                                                                            <span
                                                                                class="font-bold text-[#0A3D29] select-none text-xs sm:text-sm shrink-0 leading-relaxed">{{ $m[1] }}.</span>
                                                                            <span
                                                                                class="text-justify text-slate-700 leading-relaxed">{{ $m[2] }}</span>
                                                                        </div>
                                                                    @elseif(!empty($trimmed))
                                                                        <p class="text-justify text-slate-700 leading-relaxed">
                                                                            {{ $trimmed }}
                                                                        </p>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-justify text-slate-700 leading-relaxed">
                                                                {!! nl2br(e($rawKeterangan)) !!}
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="py-6 px-0 text-center text-slate-400 italic">
                                                        Belum ada data detail program yang ditambahkan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Lembaga Mitra Program -->
                                <div class="border-t border-[#DCE6DA] pt-4 space-y-2.5">
                                    <h4 class="text-xs font-semibold text-slate-500 text-center tracking-wider uppercase">
                                        Mitra Program</h4>
                                    <!-- Tampilan Desktop & Tablet (>= sm): Sebaris Penuh (7 Logo, Proporsional & Terpusat) -->
                                    <div
                                        class="hidden sm:flex items-center justify-center gap-3.5 sm:gap-4 lg:gap-4.5 w-full flex-nowrap pt-1.5">
                                        <a href="https://kemdiktisaintek.go.id/" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="Kemendiktisaintek">
                                            <img src="{{ asset('images/TUTWURI.png') }}" alt="Tut Wuri Handayani"
                                                class="h-7.5 sm:h-8 lg:h-8.5 w-auto max-w-[60px] object-contain">
                                        </a>
                                        <a href="https://kemdiktisaintek.go.id/en" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="Diktisaintek Berdampak">
                                            <img src="{{ asset('images/DIKTISAINTEK.png') }}" alt="Diktisaintek"
                                                class="h-6.5 sm:h-7 lg:h-7.5 w-auto max-w-[88px] object-contain">
                                        </a>
                                        <a href="https://ppkormawa.kemdiktisaintek.go.id/" target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="PPK Ormawa">
                                            <img src="{{ asset('images/PPK_ORMAWA.png') }}" alt="PPK Ormawa"
                                                class="h-7.5 sm:h-8 lg:h-8.5 w-auto max-w-[60px] object-contain">
                                        </a>
                                        <a href="https://www.ums.ac.id/" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="Universitas Muhammadiyah Surakarta">
                                            <img src="{{ asset('images/UMS.png') }}"
                                                alt="Universitas Muhammadiyah Surakarta"
                                                class="h-6.5 sm:h-7 lg:h-7.5 w-auto max-w-[88px] object-contain">
                                        </a>
                                        <a href="https://www.instagram.com/imm_alghozali/" target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="Ikatan Mahasiswa Muhammadiyah Al-Ghozali Fakultas Psikologi UMS">
                                            <img src="{{ asset('images/IMMALGHO.png') }}" alt="IMM Al-Ghozali"
                                                class="h-7.5 sm:h-8 lg:h-8.5 w-auto max-w-[60px] object-contain">
                                        </a>
                                        <a href="https://www.instagram.com/ppko_caturcerdas/" target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="PPK Ormawa Catur Cerdas UMS 2026">
                                            <img src="{{ asset('images/CATURCERDAS.png') }}" alt="Catur Cerdas"
                                                class="h-7.5 sm:h-8 lg:h-8.5 w-auto max-w-[70px] object-contain">
                                        </a>
                                        <a href="https://boyolali.go.id/" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                            title="Pemerintah Kabupaten Boyolali">
                                            <img src="{{ asset('images/PEMKABBYL.png') }}" alt="Pemkab Boyolali"
                                                class="h-7.5 sm:h-8 lg:h-8.5 w-auto max-w-[60px] object-contain">
                                        </a>
                                    </div>

                                    <!-- Tampilan Mobile (< sm): 2 Baris Rata Tengah & Sama Besar -->
                                    <div class="sm:hidden space-y-3 pt-1.5">
                                        <!-- Baris 1: 4 Logo (Kementerian & Perguruan Tinggi) Rata Tengah -->
                                        <div class="flex items-center justify-center gap-3 w-full">
                                            <a href="https://kemdiktisaintek.go.id/" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="Kemendiktisaintek">
                                                <img src="{{ asset('images/TUTWURI.png') }}" alt="Tut Wuri Handayani"
                                                    class="h-6 w-auto object-contain">
                                            </a>
                                            <a href="https://kemdiktisaintek.go.id/en" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="Diktisaintek Berdampak">
                                                <img src="{{ asset('images/DIKTISAINTEK.png') }}" alt="Diktisaintek"
                                                    class="h-5 w-auto max-w-[54px] object-contain">
                                            </a>
                                            <a href="https://ppkormawa.kemdiktisaintek.go.id/" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="PPK Ormawa">
                                                <img src="{{ asset('images/PPK_ORMAWA.png') }}" alt="PPK Ormawa"
                                                    class="h-6 w-auto object-contain">
                                            </a>
                                            <a href="https://www.ums.ac.id/" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="Universitas Muhammadiyah Surakarta">
                                                <img src="{{ asset('images/UMS.png') }}"
                                                    alt="Universitas Muhammadiyah Surakarta"
                                                    class="h-5 w-auto max-w-[54px] object-contain">
                                            </a>
                                        </div>

                                        <!-- Baris 2: 3 Logo (Organisasi Mahasiswa, Program & Pemkab) Rata Tengah -->
                                        <div class="flex items-center justify-center gap-5 w-full">
                                            <a href="https://www.instagram.com/imm_alghozali/" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="Ikatan Mahasiswa Muhammadiyah Al-Ghozali Fakultas Psikologi UMS">
                                                <img src="{{ asset('images/IMMALGHO.png') }}" alt="IMM Al-Ghozali"
                                                    class="h-6 w-auto object-contain">
                                            </a>
                                            <a href="https://www.instagram.com/ppko_caturcerdas/" target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="PPK Ormawa Catur Cerdas UMS 2026">
                                                <img src="{{ asset('images/CATURCERDAS.png') }}" alt="Catur Cerdas"
                                                    class="h-7 w-auto object-contain">
                                            </a>
                                            <a href="https://boyolali.go.id/" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center w-14 h-8 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                                                title="Pemerintah Kabupaten Boyolali">
                                                <img src="{{ asset('images/PEMKABBYL.png') }}" alt="Pemkab Boyolali"
                                                    class="h-6 w-auto object-contain">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kartu 2: Profil Instagram PPKO Catur Cerdas (Pas Sejajar Panel Kiri pada Desktop) -->
                            <div id="ppko-ig-card"
                                class="relative bg-white rounded-xl border border-[#DCE6DA] shadow-xs p-3 sm:p-3.5 overflow-hidden flex flex-col min-h-[126px]">
                                <!-- Iframe Embed Instagram (Hanya bagian profil, pas sejajar teks kiri) -->
                                <div id="ppko-ig-frame-container"
                                    class="relative w-full h-[126px] overflow-hidden rounded-lg bg-slate-50 border border-[#DCE6DA]/70">
                                    <iframe src="https://www.instagram.com/ppko_caturcerdas/embed"
                                        class="w-full h-[450px] border-0" frameborder="0" scrolling="no"
                                        allowtransparency="true" allow="encrypted-media" loading="lazy"
                                        title="Profil Instagram PPKO Catur Cerdas">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
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
                            color: #0f172a;
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
                            color: #0f172a;
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

                    /* ─── Entrance Animation: Subtle Fade Pop-Up on Each Section ─── */
                    .ppko-section-entrance {
                        opacity: 0;
                        transform: translateY(22px) scale(0.985);
                        transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
                        will-change: opacity, transform;
                    }

                    .ppko-section-entrance.is-revealed {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }

                    @media (prefers-reduced-motion: reduce) {
                        .ppko-section-entrance {
                            opacity: 1 !important;
                            transform: none !important;
                            transition: none !important;
                        }
                    }
                </style>
                <div id="katalog-pojok-container"
                    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-6 sm:space-y-8">
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
                                    'defaultImage' => asset('images/remen_maos_mockup.png'),
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

                            $mainImage = !empty($pojok->gambar) ? asset('storage/' . $pojok->gambar) : ($t['defaultImage'] ?? asset('images/cover_ppko.png'));
                        @endphp

                        @php
                            $bgHex = '#F8FAFC';
                            $bgRgb = '248, 250, 252';
                        @endphp

                        <!-- POJOK SHOWCASE ROW (BERGAYA KARTU: FOTO TANPA MARGIN LUAR KECUALI SISI BERBATASAN DENGAN TEKS) -->
                        <section id="{{ $slugId }}"
                            class="w-full relative rounded-xl border border-[#DCE6DA] shadow-xs overflow-hidden scroll-mt-28 md:scroll-mt-36 bg-[#F8FAFC] ppko-section-entrance">
                            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                                <!-- 1. GAMBAR MANDIRI (FLUSH KE TEPI LUAR KARTU, UKURAN FIKS & RASIO OTOMATIS) -->
                                <div
                                    class="w-full lg:col-span-5 {{ $isEven ? 'lg:order-2' : 'lg:order-1' }} relative min-h-[220px] sm:min-h-[260px] lg:min-h-0">
                                    <div
                                        class="relative w-full aspect-[16/10] sm:aspect-[16/9] lg:aspect-auto lg:h-full lg:absolute lg:inset-0 bg-slate-100 group overflow-hidden">
                                        <img src="{{ $mainImage }}" alt="{{ $pojok->nama }}"
                                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                                        <!-- TOMBOL GANTI FOTO ADMIN (DI SUDUT FOTO) -->
                                        @auth
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('admin.ppko.foto.update', $pojok) }}" method="POST"
                                                    enctype="multipart/form-data"
                                                    class="absolute top-3 {{ $isEven ? 'right-3' : 'left-3' }} z-10">
                                                    @csrf
                                                    <label for="input-foto-pojok-{{ $pojok->id }}"
                                                        class="cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md bg-slate-900/85 hover:bg-slate-900 text-white text-xs font-semibold shadow-md backdrop-blur-sm border border-white/20 transition-all hover:scale-105 active:scale-95">
                                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span>Ganti Foto Sampul</span>
                                                    </label>
                                                    <input type="file" id="input-foto-pojok-{{ $pojok->id }}" name="foto" class="hidden"
                                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                                        onchange="if(this.files.length > 0) { this.form.submit(); }">
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                <!-- 2. KONTEN DETAIL TEKS & MODUL FILE UNDUHAN (MEMILIKI JARAK NYAMAN DARI FOTO) -->
                                <div
                                    class="w-full lg:col-span-7 {{ $isEven ? 'lg:order-1' : 'lg:order-2' }} p-6 sm:p-8 lg:p-9 flex flex-col justify-center space-y-4 min-h-[280px] lg:min-h-[320px]">
                                    <!-- Judul Pojok -->
                                    <div>
                                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                                            {{ $index + 1 }}. {{ $pojok->nama }}
                                        </h3>
                                    </div>

                                    <!-- Deskripsi Singkat (Mendukung Rich Text Quill) -->
                                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed text-justify space-y-2 [&>p]:leading-relaxed [&>ul]:list-disc [&>ul]:list-inside [&>ol]:list-decimal [&>ol]:list-inside [&>a]:text-[#0A3D29] [&>a]:underline hover:[&>a]:text-[#145C3B]">
                                        {!! $pojok->deskripsi_singkat !!}
                                    </div>

                                    <!-- Garis Pemisah Tipis di Bawah Deskripsi Pojok -->
                                    <div class="border-b border-[#DCE6DA]/80"></div>

                                    @php
                                        $isPojokBudaya = str_contains(strtolower($pojok->nama), 'budaya') || $pojok->id == 4;
                                        $isPojokCeria = str_contains(strtolower($pojok->nama), 'ceria') || $pojok->id == 2;
                                        $isPojokTani = str_contains(strtolower($pojok->nama), 'tani') || $pojok->id == 5;
                                        $hasMitra = $isPojokBudaya || $isPojokCeria || $isPojokTani;
                                    @endphp

                                    <!-- File Unduhan, Modul Materi & Kemitraan -->
                                    @if($pojok->kurikulums->isNotEmpty() || $hasMitra)
                                        <div class="space-y-2">
                                            @if($pojok->kurikulums->isNotEmpty())
                                                @foreach($pojok->kurikulums as $file)
                                                    <div x-data="{ expanded: false }"
                                                        class="rounded-xl bg-slate-100/80 border border-slate-200/90 transition-colors duration-200 overflow-hidden group">

                                                        <!-- Header Bar: Hover menggelapkan area yang ditekan, seluruh baris bisa diklik -->
                                                        <div class="p-2.5 sm:p-3 flex justify-between gap-2.5 sm:gap-3 cursor-pointer select-none transition-colors duration-200 hover:bg-slate-200/70 active:bg-slate-300/70"
                                                            :class="expanded ? 'items-start bg-slate-200/50' : 'items-center'"
                                                            @click="expanded = !expanded" title="Klik untuk melihat detail lengkap">

                                                            <!-- Judul File & Ikon -->
                                                            <div class="flex gap-2.5 sm:gap-3 min-w-0 flex-1"
                                                                :class="expanded ? 'items-start' : 'items-center'">
                                                                <span
                                                                    class="w-8 h-8 rounded-lg bg-[#0A3D29]/10 text-[#0A3D29] flex items-center justify-center shrink-0 transition-colors group-hover:bg-[#0A3D29]/15">
                                                                    <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                </span>
                                                                <div class="min-w-0 flex-1">
                                                                    <h5 class="text-xs sm:text-sm font-bold text-slate-800 leading-snug"
                                                                        :class="expanded ? 'whitespace-normal' : 'truncate'"
                                                                        title="{{ $file->judul }}">
                                                                        {{ $file->judul }}
                                                                    </h5>
                                                                    <span class="text-[11px] text-slate-500 font-medium block mt-0.5">
                                                                        {{ $file->formatted_file_size }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Action Buttons: Tombol Atas & Chevron -->
                                                            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                                                                <!-- Tombol Lihat & Unduh: Tampil saat tertutup, disembunyikan saat dropdown dibuka -->
                                                                <div x-show="!expanded" x-cloak
                                                                    class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                                                                    <!-- Tombol Lihat -->
                                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                                        rel="noopener noreferrer" @click.stop
                                                                        class="inline-flex items-center justify-center gap-1 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-slate-900 px-2.5 py-1.5 rounded-lg transition shadow-2xs group shrink-0"
                                                                        title="Lihat dokumen di tab baru"
                                                                        aria-label="Lihat {{ $file->judul }}">
                                                                        <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-slate-700 transition-colors"
                                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                        <span class="hidden xs:inline">Lihat</span>
                                                                    </a>

                                                                    <!-- Tombol Unduh -->
                                                                    <a href="{{ route('public.ppko.kurikulum.download', $file) }}"
                                                                        @click.stop
                                                                        class="inline-flex items-center justify-center gap-1 text-xs font-semibold text-white bg-[#0A3D29] hover:bg-[#145C3B] px-2.5 py-1.5 rounded-lg transition shadow-2xs group shrink-0"
                                                                        title="Unduh file dokumen" aria-label="Unduh {{ $file->judul }}">
                                                                        <svg class="w-3.5 h-3.5 text-[#D9B85C]" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                        </svg>
                                                                        <span class="hidden xs:inline">Unduh</span>
                                                                    </a>
                                                                </div>

                                                                <!-- Chevron Indicator -->
                                                                <div
                                                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-400 transition-colors shrink-0">
                                                                    <svg class="w-4 h-4 transform transition-transform duration-300 ease-in-out text-slate-500"
                                                                        :class="expanded ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Expanded Dropdown Content -->
                                                        <div x-show="expanded" x-cloak x-collapse.duration.300ms>
                                                            <div class="px-3.5 pb-3.5 pt-1 space-y-3">
                                                                <!-- Deskripsi Dokumen (Jika Ada) -->
                                                                @if(!empty($file->deskripsi))
                                                                    <p
                                                                        class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line text-justify">
                                                                        {{ $file->deskripsi }}
                                                                    </p>
                                                                @else
                                                                    <p class="text-xs text-slate-400 italic">Tidak ada deskripsi tambahan untuk
                                                                        dokumen ini.</p>
                                                                @endif

                                                                <!-- Tombol Aksi di Bawah (Penuh & nyaman diakses) -->
                                                                <div class="grid grid-cols-2 gap-2 pt-1">
                                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                                        rel="noopener noreferrer"
                                                                        class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-slate-900 py-2 px-2.5 rounded-lg transition shadow-2xs group text-center"
                                                                        title="Lihat file di tab baru">
                                                                        <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-slate-700 transition-colors shrink-0"
                                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                        <span>Buka Dokumen</span>
                                                                    </a>

                                                                    <a href="{{ route('public.ppko.kurikulum.download', $file) }}"
                                                                        class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-white bg-[#0A3D29] hover:bg-[#145C3B] py-2 px-2.5 rounded-lg transition shadow-2xs group text-center"
                                                                        title="Unduh file dokumen">
                                                                        <svg class="w-3.5 h-3.5 text-[#D9B85C] shrink-0" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                        </svg>
                                                                        <span>Unduh File</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endif

                                            <!-- Dropdown Mitra Komunitas TPA (Khusus Pojok Ceria) -->
                                            @if($isPojokCeria)
                                                <div x-data="{ expanded: false }"
                                                    class="rounded-xl bg-slate-100/80 border border-slate-200/90 transition-colors duration-200 overflow-hidden group">

                                                    <!-- Header Bar -->
                                                    <div class="p-2.5 sm:p-3 flex justify-between items-center gap-2.5 sm:gap-3 cursor-pointer select-none transition-colors duration-200 hover:bg-slate-200/70 active:bg-slate-300/70"
                                                        :class="expanded ? 'bg-slate-200/50' : ''" @click="expanded = !expanded"
                                                        title="Klik untuk melihat daftar mitra komunitas TPA">

                                                        <!-- Judul & Ikon -->
                                                        <div class="flex gap-2.5 sm:gap-3 min-w-0 flex-1 items-center">
                                                            <span
                                                                class="w-8 h-8 rounded-lg bg-[#0A3D29]/10 text-[#0A3D29] flex items-center justify-center shrink-0 transition-colors group-hover:bg-[#0A3D29]/15">
                                                                <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                                </svg>
                                                            </span>
                                                            <div class="min-w-0 flex-1">
                                                                <h5 class="text-xs sm:text-sm font-bold text-slate-800 leading-snug">
                                                                    Mitra Komunitas TPA
                                                                </h5>
                                                                <span class="text-[11px] text-slate-500 font-medium block mt-0.5">
                                                                    2 Komunitas TPA Desa Catur
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Chevron Indicator -->
                                                        <div
                                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-400 transition-colors shrink-0">
                                                            <svg class="w-4 h-4 transform transition-transform duration-300 ease-in-out text-slate-500"
                                                                :class="expanded ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                    d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <!-- Expanded Content: Numbered List -->
                                                    <div x-show="expanded" x-cloak x-collapse.duration.300ms>
                                                        <div class="px-3.5 pb-3.5 pt-2 border-t border-slate-200/70 bg-white/70">
                                                            <ol
                                                                class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm text-slate-700">
                                                                @php
                                                                    $tpaList = [
                                                                        'TPA Masjid Gumukrejo',
                                                                        'TPA Masjid Dukuh Catur'
                                                                    ];
                                                                @endphp
                                                                @foreach($tpaList as $tpaIdx => $tpaName)
                                                                    <li
                                                                        class="flex items-center gap-2.5 py-1.5 px-2.5 rounded-lg bg-white border border-slate-200/80 shadow-2xs">
                                                                        <span
                                                                            class="w-5 h-5 rounded-full bg-[#0A3D29]/10 text-[#0A3D29] text-[11px] font-bold flex items-center justify-center shrink-0">
                                                                            {{ $tpaIdx + 1 }}
                                                                        </span>
                                                                        <span
                                                                            class="text-slate-800 text-xs sm:text-sm font-medium leading-snug">
                                                                            {{ $tpaName }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Dropdown Mitra Karang Taruna (Khusus Pojok Budaya) -->
                                            @if($isPojokBudaya)
                                                <div x-data="{ expanded: false }"
                                                    class="rounded-xl bg-slate-100/80 border border-slate-200/90 transition-colors duration-200 overflow-hidden group">

                                                    <!-- Header Bar -->
                                                    <div class="p-2.5 sm:p-3 flex justify-between items-center gap-2.5 sm:gap-3 cursor-pointer select-none transition-colors duration-200 hover:bg-slate-200/70 active:bg-slate-300/70"
                                                        :class="expanded ? 'bg-slate-200/50' : ''" @click="expanded = !expanded"
                                                        title="Klik untuk melihat daftar mitra karang taruna">

                                                        <!-- Judul & Ikon -->
                                                        <div class="flex gap-2.5 sm:gap-3 min-w-0 flex-1 items-center">
                                                            <span
                                                                class="w-8 h-8 rounded-lg bg-[#0A3D29]/10 text-[#0A3D29] flex items-center justify-center shrink-0 transition-colors group-hover:bg-[#0A3D29]/15">
                                                                <svg class="w-4 h-4 text-[#0A3D29]" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                            </span>
                                                            <div class="min-w-0 flex-1">
                                                                <h5 class="text-xs sm:text-sm font-bold text-slate-800 leading-snug">
                                                                    Mitra Karang Taruna
                                                                </h5>
                                                                <span class="text-[11px] text-slate-500 font-medium block mt-0.5">
                                                                    13 Karang Taruna Pedukuhan Desa Catur
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Chevron Indicator -->
                                                        <div
                                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-400 transition-colors shrink-0">
                                                            <svg class="w-4 h-4 transform transition-transform duration-300 ease-in-out text-slate-500"
                                                                :class="expanded ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                    d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <!-- Expanded Content: Numbered List -->
                                                    <div x-show="expanded" x-cloak x-collapse.duration.300ms>
                                                        <div class="px-3.5 pb-3.5 pt-2 border-t border-slate-200/70 bg-white/70">
                                                            <ol
                                                                class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm text-slate-700">
                                                                @php
                                                                    $karangTarunaList = [
                                                                        'Karang Taruna Dukuh Kungon',
                                                                        'Karang Taruna Dukuh Catur',
                                                                        'Karang Taruna Dukuh Sabrangan',
                                                                        'Karang Taruna Dukuh Karakan',
                                                                        'Karang Taruna Dukuh Gunungpuyuh',
                                                                        'Karang Taruna Dukuh Gumuk Ngembes',
                                                                        'Karang Taruna Dukuh Tropayan',
                                                                        'Karang Taruna Dukuh Giring',
                                                                        'Karang Taruna Dukuh Karangjowo',
                                                                        'Karang Taruna Dukuh Bakalan',
                                                                        'Karang Taruna Dukuh Kragan',
                                                                        'Karang Taruna Dukuh Wonotoro',
                                                                        'Karang Taruna Dukuh Gumukrejo'
                                                                    ];
                                                                @endphp
                                                                @foreach($karangTarunaList as $ktIdx => $ktName)
                                                                    <li
                                                                        class="flex items-center gap-2.5 py-1.5 px-2.5 rounded-lg bg-white border border-slate-200/80 shadow-2xs">
                                                                        <span
                                                                            class="w-5 h-5 rounded-full bg-[#0A3D29]/10 text-[#0A3D29] text-[11px] font-bold flex items-center justify-center shrink-0">
                                                                            {{ $ktIdx + 1 }}
                                                                        </span>
                                                                        <span
                                                                            class="text-slate-800 text-xs sm:text-sm font-medium leading-snug">
                                                                            {{ $ktName }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Dropdown Mitra Komunitas GAPOKTAN (Khusus Pojok Tani) -->
                                            @if($isPojokTani)
                                                <div x-data="{ expanded: false }"
                                                    class="rounded-xl bg-slate-100/80 border border-slate-200/90 transition-colors duration-200 overflow-hidden group">

                                                    <!-- Header Bar -->
                                                    <div class="p-2.5 sm:p-3 flex justify-between items-center gap-2.5 sm:gap-3 cursor-pointer select-none transition-colors duration-200 hover:bg-slate-200/70 active:bg-slate-300/70"
                                                        :class="expanded ? 'bg-slate-200/50' : ''" @click="expanded = !expanded"
                                                        title="Klik untuk melihat daftar mitra komunitas GAPOKTAN">

                                                        <!-- Judul & Ikon -->
                                                        <div class="flex gap-2.5 sm:gap-3 min-w-0 flex-1 items-center">
                                                            <span
                                                                class="w-8 h-8 rounded-lg bg-[#0A3D29]/10 text-[#0A3D29] flex items-center justify-center shrink-0 transition-colors group-hover:bg-[#0A3D29]/15">
                                                                <svg class="w-4 h-4 text-[#0A3D29]" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path d="M7 20h10" />
                                                                    <path d="M10 20c0-4 1-7 2-10" />
                                                                    <path d="M12 10a4 4 0 0 1 4-4c0 3-1.5 5-4 5" />
                                                                    <path d="M12 14a4 4 0 0 0-4-4c0 3 1.5 5 4 5" />
                                                                </svg>
                                                            </span>
                                                            <div class="min-w-0 flex-1">
                                                                <h5 class="text-xs sm:text-sm font-bold text-slate-800 leading-snug">
                                                                    Mitra Komunitas GAPOKTAN
                                                                </h5>
                                                                <span class="text-[11px] text-slate-500 font-medium block mt-0.5">
                                                                    Gabungan Kelompok Tani Desa Catur
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Chevron Indicator -->
                                                        <div
                                                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center text-slate-400 transition-colors shrink-0">
                                                            <svg class="w-4 h-4 transform transition-transform duration-300 ease-in-out text-slate-500"
                                                                :class="expanded ? 'rotate-180 text-[#0A3D29]' : ''" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                    d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <!-- Expanded Content: Numbered List -->
                                                    <div x-show="expanded" x-cloak x-collapse.duration.300ms>
                                                        <div class="px-3.5 pb-3.5 pt-2 border-t border-slate-200/70 bg-white/70">
                                                            <ol class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm text-slate-700">
                                                                @php
                                                                    $gapoktanList = [
                                                                        'Kelompok Tani Budi Rahayu',
                                                                        'Kelompok Tani Ngudi Rejeki',
                                                                        'Kelompok Tani Sarono Tani',
                                                                        'Kelompok Tani Marsudi Mulyo'
                                                                    ];
                                                                @endphp
                                                                @foreach($gapoktanList as $gIdx => $gName)
                                                                    <li
                                                                        class="flex items-center gap-2.5 py-1.5 px-2.5 rounded-lg bg-white border border-slate-200/80 shadow-2xs">
                                                                        <span
                                                                            class="w-5 h-5 rounded-full bg-[#0A3D29]/10 text-[#0A3D29] text-[11px] font-bold flex items-center justify-center shrink-0">
                                                                            {{ $gIdx + 1 }}
                                                                        </span>
                                                                        <span
                                                                            class="text-slate-800 text-xs sm:text-sm font-medium leading-snug">
                                                                            {{ $gName }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <div class="pt-2 flex items-center justify-end">
                                                <a href="{{ route('admin.ppko.edit', $pojok) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-[#0A3D29] hover:bg-[#145C3B] text-white text-xs font-semibold transition shadow-2xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <span>Kelola Foto & File</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endauth
                                </div>

                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- LIGHTBOX MODAL (Interactive Alpine.js) -->
        <!-- ========================================================================= -->
        <div x-show="lightboxOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-[#041A12]/90 backdrop-blur-md transition-opacity"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Scrim backdrop click to close -->
            <div class="absolute inset-0" @click="closeLightbox()"></div>

            <!-- Modal Card Container -->
            <div class="relative z-10 bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl flex flex-col md:flex-row"
                @click.stop x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <!-- Close Button -->
                <button type="button" @click="closeLightbox()"
                    class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center transition text-sm">
                    ✕
                </button>

                <!-- Image Area -->
                <div
                    class="md:w-3/5 bg-black flex items-center justify-center min-h-[260px] max-h-[500px] md:max-h-none overflow-hidden">
                    <template x-if="activeImg">
                        <img :src="activeImg" :alt="activeTitle" class="max-w-full max-h-full object-contain">
                    </template>
                    <template x-if="!activeImg">
                        <div class="text-slate-400 text-xs p-8 text-center">Tidak ada gambar pratinjau</div>
                    </template>
                </div>

                <!-- Content Area -->
                <div
                    class="md:w-2/5 p-6 sm:p-8 flex flex-col justify-between overflow-y-auto max-h-[400px] md:max-h-[560px]">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#EAF1E8] text-[#0A3D29]"
                                x-text="activePojok"></span>
                            <span class="text-xs text-slate-400" x-text="activeDate"></span>
                        </div>

                        <h4 class="font-serif text-lg sm:text-xl font-bold text-slate-900 leading-snug"
                            x-text="activeTitle"></h4>

                        <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2 whitespace-pre-line"
                            x-text="activeCaption"></div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">PPKO Catur Cerdas 2026</span>
                        <button type="button" @click="closeLightbox()"
                            class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
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
                    <span class="text-xs sm:text-sm font-bold tracking-tight text-[#0A3D29] whitespace-nowrap"
                        x-text="activeName"></span>
                </div>

                <!-- Garis Pemisah Antara Indikator & Tombol Ke Bawah -->
                <div class="h-5 sm:h-6 w-px bg-[#0A3D29]/20 shrink-0"></div>

                <!-- Tombol Panah Ke Bawah (Kiri: Pojok Selanjutnya) -->
                <button type="button" @click="nextPojok()"
                    class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center text-[#0A3D29] active:bg-slate-900/[0.18] active:scale-90 transition-all cursor-pointer shrink-0"
                    aria-label="Pojok Selanjutnya" title="Pojok Selanjutnya">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Garis Pemisah Antara Tombol Bawah & Tombol Atas -->
                <div class="h-5 sm:h-6 w-px bg-[#0A3D29]/20 shrink-0"></div>
            </div>

            <!-- Tombol Panah Ke Atas / Kembali ke Atas (Selalu Tampil di Luar Maupun di Dalam Katalog Pojok) -->
            <button type="button" @click="prevPojok()"
                class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center text-[#0A3D29] active:bg-slate-900/[0.18] active:scale-90 transition-all cursor-pointer shrink-0"
                :aria-label="inPojokSection ? 'Pojok Sebelumnya / Kembali ke Atas' : 'Kembali ke Atas'"
                :title="inPojokSection ? 'Pojok Sebelumnya / Kembali ke Atas' : 'Kembali ke Atas'">
                <svg class="w-5 h-5 text-[#0A3D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function syncIgCardWithLeftPanel() {
            const leftPanel = document.getElementById('ppko-left-panel');
            const igCard = document.getElementById('ppko-ig-card');
            const igFrame = document.getElementById('ppko-ig-frame-container');
            if (!leftPanel || !igCard || !igFrame) return;

            // Pada tampilan mobile (< 1024px), gunakan tinggi standar yang rapi
            if (window.innerWidth < 1024) {
                igCard.style.height = '';
                igFrame.style.height = '126px';
                return;
            }

            // Reset terlebih dahulu agar posisi alami dapat diukur secara presisi
            igCard.style.height = '';
            igFrame.style.height = '';

            const leftRect = leftPanel.getBoundingClientRect();
            const igRect = igCard.getBoundingClientRect();

            // Hitung tinggi pas agar batas bawah kartu Instagram sejajar persis dengan batas bawah div panel kiri
            const targetHeight = Math.floor(leftRect.bottom - igRect.top);

            if (targetHeight > 60) {
                igCard.style.height = targetHeight + 'px';
                const cardStyle = window.getComputedStyle(igCard);
                const padTop = parseFloat(cardStyle.paddingTop) || 14;
                const padBottom = parseFloat(cardStyle.paddingBottom) || 14;
                const borderTop = parseFloat(cardStyle.borderTopWidth) || 1;
                const borderBottom = parseFloat(cardStyle.borderBottomWidth) || 1;
                const containerHeight = Math.max(60, targetHeight - padTop - padBottom - borderTop - borderBottom);
                igFrame.style.height = containerHeight + 'px';
            } else {
                igFrame.style.height = '126px';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            syncIgCardWithLeftPanel();
            window.addEventListener('resize', syncIgCardWithLeftPanel);
            window.addEventListener('load', syncIgCardWithLeftPanel);

            if (window.ResizeObserver) {
                const ro = new ResizeObserver(() => syncIgCardWithLeftPanel());
                const leftPanel = document.getElementById('ppko-left-panel');
                const detailCard = document.getElementById('ppko-detail-card');
                if (leftPanel) ro.observe(leftPanel);
                if (detailCard) ro.observe(detailCard);
            }
        });
    </script>
@endpush