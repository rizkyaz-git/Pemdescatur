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
        <div class="md:w-3/5 bg-slate-950 flex items-center justify-center min-h-[260px] max-h-[500px] md:max-h-none overflow-hidden relative"
            x-data="{ imgLoaded: false }"
            x-init="$watch('activeImg', () => { imgLoaded = false; })">
            <div x-show="activeImg && !imgLoaded" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
            <template x-if="activeImg">
                <img :src="activeImg" :alt="activeTitle"
                    @load="imgLoaded = true"
                    class="max-w-full max-h-full object-contain relative z-10 transition-opacity duration-300"
                    :class="imgLoaded ? 'opacity-100' : 'opacity-0'">
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
