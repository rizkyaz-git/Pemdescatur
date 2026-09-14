<!-- FLOATING SHORTCUT CARDS CONTAINER -->
<div
    class="relative z-30 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-56 mb-28 sm:-mt-14 sm:mb-6 lg:-mt-16 lg:mb-10 fade-in-up fade-in-up-d3">

    <!-- A. MOBILE MODE ONLY (< sm): Single Unified Floating Card with 5 Side-by-Side Items & Elevation Shadow -->
    <div
        class="block sm:hidden bg-white rounded-xl shadow-[0_12px_30px_-5px_rgba(0,0,0,0.22)] border border-slate-100 ring-1 ring-slate-900/5 py-3 px-1">
        <div class="grid grid-cols-5 divide-x divide-slate-100 text-center">

            <!-- 1. Berita & Kabar -->
            <a href="{{ route('public.news.index') }}"
                class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                </svg>
                <span
                    class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Berita</span>
            </a>

            <!-- 2. Surat Mandiri -->
            <a href="{{ route('warga.letter.index') }}"
                class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span
                    class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Surat</span>
            </a>

            <!-- 3. Pengaduan Warga -->
            <a href="{{ route('warga.complaint.index') }}"
                class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                </svg>
                <span
                    class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Aduan</span>
            </a>

            <!-- 4. Perpustakaan Digital -->
            <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank"
                rel="noopener noreferrer"
                class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span
                    class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">Perpus</span>
            </a>

            <!-- 5. Catur Cerdas -->
            <a href="{{ route('public.ppko') }}"
                class="flex flex-col items-center justify-center px-0.5 py-1 group transition-colors">
                <svg class="w-5 h-5 text-[#0A3D29] group-hover:scale-110 transition-transform mb-1 shrink-0" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                <span
                    class="block text-[10px] font-bold text-slate-800 group-hover:text-[#0A3D29] leading-tight truncate w-full">PPKO</span>
            </a>

        </div>
    </div>

    <!-- B. TABLET/DESKTOP MODE (>= sm): Single Unified Bar Card Container with Thin Vertical Dividers & Clean Alignment -->
    <div class="hidden sm:block bg-white rounded-xl shadow-2xl border border-slate-200/80 overflow-hidden">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-slate-100/90">

            <!-- Card 1: Berita & Kabar -->
            <a href="{{ route('public.news.index') }}"
                class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6m-6 4h6" />
                    </svg>
                    <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                        Berita Desa
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Informasi agenda, pengumuman, dan berita desa.
                </p>
            </a>

            <!-- Card 2: Surat Mandiri -->
            <a href="{{ route('warga.letter.index') }}"
                class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                        Surat Mandiri
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Unduh template surat resmi siap cetak desa.
                </p>
            </a>

            <!-- Card 3: Pengaduan Warga -->
            <a href="{{ route('warga.complaint.index') }}"
                class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.01 5.395m-1.01-5.395c.379 1.764.575 3.567.575 5.395 0 1.828-.196 3.631-.575 5.395m0 0a23.909 23.909 0 01-1.01 5.395m1.01-5.395A23.74 23.74 0 0118.795 21" />
                    </svg>
                    <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                        Pengaduan
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Saluran aspirasi dan keluhan fasilitas warga.
                </p>
            </a>

            <!-- Card 4: Perpustakaan Digital -->
            <a href="{{ $globalLibraryUrl ?? 'https://desacaturbyl.perpustakaan.co.id/home.ks' }}" target="_blank"
                rel="noopener noreferrer"
                class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                        Remen Maos
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Koleksi buku digital perpustakaan online desa.
                </p>
            </a>

            <!-- Card 5: PPK Ormawa -->
            <a href="{{ route('public.ppko') }}"
                class="p-4 lg:p-5 flex flex-col space-y-1.5 hover:bg-slate-100/80 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <h3 class="font-serif text-base font-bold text-slate-900 leading-snug">
                        Catur Cerdas
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium leading-relaxed text-left">
                    Halaman PPK Ormawa Catur Cerdas UMS.
                </p>
            </a>

        </div>
    </div>

</div>
