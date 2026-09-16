@extends('layouts.public')

@section('title', 'PPKO Catur Cerdas UMS 2026 – PPK Ormawa Imm Al-Ghozali Fakultas Psikologi UMS')

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
                        rootMargin: '0px 0px 80px 0px',
                        threshold: 0.02
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
                const nextEl = document.getElementById('tentang-program') || document.getElementById('galeri') || document.querySelector('footer');
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
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10" style="margin: 0 auto;">

                    {{-- 1. Top Header & Breadcrumbs --}}
                    @include('public.ppko.partials.header')

                    {{-- 2. Tentang Program & Detail Program --}}
                    @include('public.ppko.partials.overview')

                </div>
            </div>

            {{-- 3. Katalog Dedikasi Per-Pojok --}}
            @include('public.ppko.partials.pojok-catalog')

            {{-- 4. Lightbox Modal --}}
            @include('public.ppko.partials.lightbox')

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
                const padTop = parseFloat(cardStyle.paddingTop) || 0;
                const padBottom = parseFloat(cardStyle.paddingBottom) || 0;
                const borderTop = parseFloat(cardStyle.borderTopWidth) || 1;
                const borderBottom = parseFloat(cardStyle.borderBottomWidth) || 1;
                const accentLine = igCard.querySelector('.ig-accent-line');
                const accentHeight = accentLine ? accentLine.offsetHeight : 0;
                const containerHeight = Math.max(60, targetHeight - padTop - padBottom - borderTop - borderBottom - accentHeight);
                igFrame.style.height = containerHeight + 'px';
            } else {
                igFrame.style.height = '126px';
            }
        }

        // Otomatis menyesuaikan ukuran font nomor & judul pojok agar membentang pas sampai ujung kanan kolom
        function fitAllPojokTitles() {
            const wraps = document.querySelectorAll('.pojok-header-wrap');
            wraps.forEach(wrap => {
                const num = wrap.querySelector('.pojok-num-text');
                const title = wrap.querySelector('.pojok-title-text');
                if (!num || !title) return;

                const wrapWidth = Math.floor(wrap.clientWidth);
                if (window.innerWidth >= 640 && wrapWidth > 150) {
                    const baseSize = 80;
                    num.style.fontSize = baseSize + 'px';
                    title.style.fontSize = baseSize + 'px';

                    const style = window.getComputedStyle(wrap);
                    const gap = parseFloat(style.columnGap || style.gap) || 16;
                    const totalContentWidth = num.offsetWidth + gap + title.offsetWidth;

                    if (totalContentWidth > 0) {
                        const targetWidth = wrapWidth - 2;
                        const computedSize = Math.floor(baseSize * (targetWidth / totalContentWidth));
                        const finalSize = Math.max(30, Math.min(120, computedSize));
                        num.style.fontSize = finalSize + 'px';
                        title.style.fontSize = finalSize + 'px';
                    }
                } else {
                    num.style.fontSize = '';
                    title.style.fontSize = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            syncIgCardWithLeftPanel();
            fitAllPojokTitles();

            window.addEventListener('resize', () => {
                syncIgCardWithLeftPanel();
                fitAllPojokTitles();
            });
            window.addEventListener('load', () => {
                syncIgCardWithLeftPanel();
                fitAllPojokTitles();
            });

            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(fitAllPojokTitles);
            }

            if (window.ResizeObserver) {
                const ro = new ResizeObserver(() => syncIgCardWithLeftPanel());
                const leftPanel = document.getElementById('ppko-left-panel');
                const detailCard = document.getElementById('ppko-detail-card');
                if (leftPanel) ro.observe(leftPanel);
                if (detailCard) ro.observe(detailCard);

                const roPojok = new ResizeObserver(() => fitAllPojokTitles());
                document.querySelectorAll('.pojok-header-wrap').forEach(wrap => {
                    if (wrap.parentElement) {
                        roPojok.observe(wrap.parentElement);
                    }
                });
            }
        });
    </script>
@endpush