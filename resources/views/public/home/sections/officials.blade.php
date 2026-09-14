<!-- MAIN CONTAINER FOR LOWER SECTIONS (Aparatur Desa) -->
<div class="w-full bg-[#F8FAF7] border-b border-[#DCE6DA]">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-16 scroll-reveal">

        <!-- ========================================================= -->
        <!-- SECTION 4: APARATUR DESA (PERANGKAT DESA CATUR)             -->
        <!-- ========================================================= -->
        @php
            $officialList = [];
            if(isset($officials) && $officials->count() > 0) {
                foreach($officials as $off) {
                    $officialList[] = [
                        'name' => $off->name,
                        'position' => $off->position,
                        'photo' => $off->photo_path ? asset('storage/' . $off->photo_path) : null,
                    ];
                }
            } else {
                $officialList = [
                    ['name' => 'Dra. NUNIK S RAHAYU, M.Pd', 'position' => 'Kepala Desa Catur', 'photo' => null],
                    ['name' => 'Bambang Sugeng, S.Sos.', 'position' => 'Sekretaris Desa', 'photo' => null],
                    ['name' => 'Siti Rahmawati, A.Md.', 'position' => 'Kaur Keuangan', 'photo' => null],
                    ['name' => 'Tri Santoso, S.T.', 'position' => 'Kaur Perencanaan & Umum', 'photo' => null],
                    ['name' => 'Joko Widodo, S.P.', 'position' => 'Kasi Pelayanan', 'photo' => null],
                ];
            }
            $totalUnique = count($officialList);
            // Repeat 5 sets for infinite seamless sliding
            $allCards = [];
            for ($r = 0; $r < 5; $r++) {
                foreach ($officialList as $item) {
                    $allCards[] = $item;
                }
            }
            $initialIndex = $totalUnique * 2; // Start in middle set (Set 2)
        @endphp

        <section class="py-4 space-y-6 lg:space-y-8" 
                 x-data="{
                     totalUnique: {{ $totalUnique }},
                     totalCards: {{ count($allCards) }},
                     currentIndex: {{ $initialIndex }},
                     cardWidth: 240,
                     gap: 20,
                     containerWidth: 1000,
                     isDesktop: window.innerWidth >= 640,
                     isDragging: false,
                     dragStartX: 0,
                     dragOffset: 0,
                     withTransition: true,

                     init() {
                         this.updateDimensions();
                         window.addEventListener('resize', () => {
                             this.updateDimensions();
                         });
                     },

                     updateDimensions() {
                         if (this.$refs.container) {
                             this.containerWidth = this.$refs.container.clientWidth;
                         }
                         this.isDesktop = window.innerWidth >= 640;
                         this.cardWidth = this.isDesktop ? 240 : 210;
                         this.gap = this.isDesktop ? 20 : 12;
                     },

                     getStep() {
                         return this.cardWidth + this.gap;
                     },

                     getTransform() {
                         const step = this.getStep();
                         const centerPos = (this.containerWidth / 2) - (this.currentIndex * step + this.cardWidth / 2);
                         return centerPos + this.dragOffset;
                     },

                     next() {
                         this.goTo(this.currentIndex + 1);
                     },

                     prev() {
                         this.goTo(this.currentIndex - 1);
                     },

                     goTo(index) {
                         this.withTransition = true;
                         this.currentIndex = index;
                         this.checkWrap();
                     },

                     checkWrap() {
                         setTimeout(() => {
                             const minBoundary = this.totalUnique;
                             const maxBoundary = this.totalUnique * 3;
                             if (this.currentIndex < minBoundary || this.currentIndex >= maxBoundary) {
                                 this.withTransition = false;
                                 const offsetInSet = ((this.currentIndex % this.totalUnique) + this.totalUnique) % this.totalUnique;
                                 this.currentIndex = this.totalUnique * 2 + offsetInSet;
                             }
                         }, 360);
                     },

                     handleTouchStart(e) {
                         this.isDragging = true;
                         this.dragStartX = e.touches[0].clientX;
                         this.dragOffset = 0;
                     },

                     handleTouchMove(e) {
                         if (!this.isDragging) return;
                         this.dragOffset = e.touches[0].clientX - this.dragStartX;
                     },

                     handleTouchEnd() {
                         if (!this.isDragging) return;
                         this.isDragging = false;
                         if (this.dragOffset < -35) {
                             this.next();
                         } else if (this.dragOffset > 35) {
                             this.prev();
                         }
                         this.dragOffset = 0;
                     },

                     handleMouseDown(e) {
                         this.isDragging = true;
                         this.dragStartX = e.clientX;
                         this.dragOffset = 0;
                     },

                     handleMouseMove(e) {
                         if (!this.isDragging) return;
                         this.dragOffset = e.clientX - this.dragStartX;
                     },

                     handleMouseUp() {
                         if (!this.isDragging) return;
                         this.isDragging = false;
                         if (this.dragOffset < -35) {
                             this.next();
                         } else if (this.dragOffset > 35) {
                             this.prev();
                         }
                         this.dragOffset = 0;
                     }
                 }">

            <!-- Header Title -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-200 text-center sm:text-left">
                <div>
                    <h2 class="font-['Public_Sans',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight">
                        Perangkat Desa Catur
                    </h2>
                </div>

                <!-- Desktop Action Button (Right Aligned) -->
                <a href="{{ route('public.officials') }}"
                    class="hidden sm:inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0">
                    <span>Lihat Semua Aparatur</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Carousel Stage Container with Floating Glassmorphism Navigation Buttons -->
            <div class="relative group/stage">

                <!-- Floating Glassmorphism Button: Kiri -->
                <button type="button" @click="prev()"
                    class="absolute left-1 sm:left-3 md:left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/70 hover:bg-white/95 active:scale-90 backdrop-blur-md border border-white/80 text-[#0A3D29] flex items-center justify-center transition-all duration-200 shadow-[0_8px_22px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_28px_rgba(0,0,0,0.18)] cursor-pointer group"
                    aria-label="Aparatur Sebelumnya">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Floating Glassmorphism Button: Kanan -->
                <button type="button" @click="next()"
                    class="absolute right-1 sm:right-3 md:right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/70 hover:bg-white/95 active:scale-90 backdrop-blur-md border border-white/80 text-[#0A3D29] flex items-center justify-center transition-all duration-200 shadow-[0_8px_22px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_28px_rgba(0,0,0,0.18)] cursor-pointer group"
                    aria-label="Aparatur Selanjutnya">
                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Carousel Stage (Overflow Hidden, Centered Track) -->
                <div x-ref="container" 
                     class="relative overflow-hidden py-4 select-none touch-pan-y"
                     @touchstart="handleTouchStart($event)"
                     @touchmove="handleTouchMove($event)"
                     @touchend="handleTouchEnd()"
                     @mousedown="handleMouseDown($event)"
                     @mousemove="handleMouseMove($event)"
                     @mouseup="handleMouseUp()"
                     @mouseleave="handleMouseUp()">

                    <!-- Sliding Track -->
                    <div class="flex items-center"
                         :style="`transform: translateX(${getTransform()}px); transition: ${withTransition ? 'transform 360ms cubic-bezier(0.25, 1, 0.5, 1)' : 'none'};`">
                        @foreach($allCards as $index => $card)
                            <div @click="goTo({{ $index }})"
                                 class="shrink-0 group flex flex-col justify-between p-3.5 sm:p-4 rounded-xl bg-white border transition-all duration-300 ease-out cursor-pointer overflow-hidden transform"
                                 :style="`width: ${cardWidth}px; margin-right: ${gap}px;`"
                                 :class="{
                                     'filter-none opacity-100 scale-100 z-20 shadow-xl border-[#0A3D29]/40 ring-2 ring-[#0A3D29]/15': 
                                         (isDesktop && Math.abs({{ $index }} - currentIndex) <= 1) || (!isDesktop && {{ $index }} === currentIndex),
                                     'filter blur-[2px] opacity-50 scale-95 z-10 cursor-pointer hover:opacity-80': 
                                         (isDesktop && Math.abs({{ $index }} - currentIndex) === 2) || (!isDesktop && Math.abs({{ $index }} - currentIndex) === 1),
                                     'filter blur-[4px] opacity-10 scale-90 pointer-events-none z-0': 
                                         (isDesktop && Math.abs({{ $index }} - currentIndex) > 2) || (!isDesktop && Math.abs({{ $index }} - currentIndex) > 1)
                                 }">
                                <div>
                                    <!-- Photo Container (Original Compact Card Style) -->
                                    <div class="relative rounded-xl overflow-hidden aspect-[3/4] w-full bg-slate-100 mb-3 sm:mb-3.5 flex items-center justify-center shadow-2xs"
                                        x-data="{ loaded: false }" x-init="if ($refs.img && $refs.img.complete) { loaded = true; }">
                                        @if($card['photo'])
                                            <div x-show="!loaded" class="absolute inset-0 animate-shimmer-glow z-10 pointer-events-none"></div>
                                            <img x-ref="img" src="{{ $card['photo'] }}"
                                                alt="{{ $card['name'] }}" loading="lazy" @load="loaded = true;"
                                                class="relative z-10 w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                                                :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-105'">
                                        @else
                                            <div class="w-14 h-14 rounded-full bg-slate-200/80 flex items-center justify-center text-slate-400 group-hover:text-[#0A3D29] group-hover:bg-emerald-50 transition-colors">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Position Text (Original Minimalist Typography) -->
                                    <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-[#0A3D29] mb-1 line-clamp-1">
                                        {{ $card['position'] }}
                                    </p>

                                    <!-- Official Name (Original Bold Typography) -->
                                    <h3 class="font-['Public_Sans',sans-serif] text-sm sm:text-base font-extrabold text-slate-800 group-hover:text-[#0A3D29] transition-colors leading-snug line-clamp-2">
                                        {{ $card['name'] }}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Carousel Navigation Dots / Indicator -->
            <div class="flex justify-center items-center gap-1.5 pt-2">
                <template x-for="i in totalUnique" :key="i">
                    <button @click="goTo(totalUnique * 2 + (i - 1))"
                        class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                        :class="(((currentIndex % totalUnique) + totalUnique) % totalUnique) === (i - 1) 
                            ? 'w-6 bg-[#0A3D29]' 
                            : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                        :aria-label="'Perangkat ' + i">
                    </button>
                </template>
            </div>

            <!-- Mobile Bottom Action Button: Lihat Semua Aparatur (block sm:hidden) -->
            <div class="block sm:hidden text-center pt-2">
                <a href="{{ route('public.officials') }}"
                    class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#062c1d] text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 min-h-[44px]">
                    <span>Lihat Semua Perangkat</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </section>
    </div>
</div>
