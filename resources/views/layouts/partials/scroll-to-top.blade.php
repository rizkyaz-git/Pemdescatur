<!-- FLOATING SCROLL TO TOP BUTTON (RIGHT SIDE) -->
<div x-data="{ showScrollTop: false }"
     x-init="showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200"
     @scroll.window.passive="showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200"
     x-show="showScrollTop"
     x-cloak
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-6 scale-75"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-6 scale-75"
     class="fixed bottom-6 right-6 z-[99999] font-sans pointer-events-auto">
    <button type="button" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-white/80 hover:bg-white/95 backdrop-blur-3xl backdrop-saturate-200 border-2 border-white ring-1 ring-[#0A3D29]/25 shadow-2xl text-[#0A3D29] flex items-center justify-center cursor-pointer hover:scale-105 active:scale-95 transition-all duration-300 group shrink-0"
        aria-label="Kembali ke Atas" title="Kembali ke Atas">
        <svg class="w-5 h-5 text-[#0A3D29] group-hover:-translate-y-0.5 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>
