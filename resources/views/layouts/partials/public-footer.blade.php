<!-- ========================================================= -->
<!-- FOOTER SECTION (CLEAN & ELEGANT DESA CATUR STYLE) -->
<!-- ========================================================= -->
<footer class="bg-[#0A3B28] text-white pt-14 pb-8">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-10">

            <!-- Col 1: About & Info (4 cols) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-3">
                    @if(isset($globalLogo) && $globalLogo && Storage::disk('public')->exists($globalLogo))
                        <img src="{{ asset('storage/' . $globalLogo) }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                            class="h-10 w-auto object-contain shrink-0">
                    @elseif(file_exists(public_path('images/logo_catur.png')))
                        <img src="{{ asset('images/logo_catur.png') }}" alt="{{ $globalVillageName ?? 'Desa Catur' }}"
                            class="h-10 w-auto object-contain shrink-0">
                    @else
                        <div
                            class="w-9 h-9 bg-white text-[#0A3B28] rounded-full flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                            DC
                        </div>
                    @endif
                    <div>
                        <h3 class="font-serif text-xl font-bold text-white tracking-wide leading-tight">Pemerintah
                            Desa Catur</h3>
                        <p class="text-xs font-semibold text-[#D9B85C]">Kec. Sambi, Kab. Boyolali</p>
                    </div>
                </div>

                <div class="space-y-2 text-xs sm:text-sm text-slate-300 font-light pt-1">
                    <p class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[#D9B85C] shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $globalAddress ?? 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali 57376' }}</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#D9B85C] shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $globalEmail ?? 'pemerintahdesacatur@gmail.com' }}</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#D9B85C] shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                        </svg>
                        @php
                            $rawIg = !empty($globalInstagram) ? $globalInstagram : 'https://www.instagram.com/pemerintahdesacatur';
                            $igUrl = \Illuminate\Support\Str::startsWith($rawIg, ['http://', 'https://']) ? $rawIg : 'https://www.instagram.com/pemerintahdesacatur' . ltrim($rawIg, '@/');
                        @endphp
                        <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer"
                            class="hover:text-white transition">
                            <span>pemerintahdesacatur</span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Col 2: Tautan Cepat (3 cols) -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">TAUTAN CEPAT</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                    <li><a href="{{ route('public.profile') }}" class="hover:text-white transition">Profil Desa</a></li>
                    <li><a href="{{ route('public.officials') }}" class="hover:text-white transition">Struktur
                            Pemerintahan</a></li>
                    <li><a href="{{ route('public.news.index') }}" class="hover:text-white transition">Berita &
                            Pengumuman</a></li>
                    <li><a href="{{ route('public.gallery') }}" class="hover:text-white transition">Galeri Kegiatan</a>
                    </li>
                    <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Cetak Surat
                            Mandiri</a></li>
                    <li><a href="{{ route('warga.complaint.create') }}" class="hover:text-white transition">Laporan &
                            Pengaduan</a></li>
                    <li><a href="{{ route('public.ppko') }}" class="hover:text-white transition">PPKO Catur Cerdas</a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Layanan Surat Online (3 cols) -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">LAYANAN SURAT ONLINE</h4>
                @php
                    $footerLetterTemplates = \App\Models\LetterTemplate::select('id', 'name', 'code')->orderBy('name')->get();
                @endphp
                <ul class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                    @forelse($footerLetterTemplates as $tpl)
                        <li>
                            <a href="{{ route('warga.letter.index', ['search' => $tpl->name]) }}#katalog-surat"
                                class="hover:text-white transition">
                                {{ $tpl->name }} {{ $tpl->code ? "({$tpl->code})" : '' }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan
                                Usaha (SKU)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan
                                Domisili (SKD)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan
                                Tidak Mampu (SKTM)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Pengantar
                                Nikah (SPN)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan
                                Kelahiran (SKK)</a></li>
                        <li><a href="{{ route('warga.letter.index') }}" class="hover:text-white transition">Surat Keterangan
                                Kematian (SKKM)</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Col 4: Jam Pelayanan & Call Center (2 cols) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="text-xs font-bold text-[#D9B85C] uppercase tracking-wider">JAM PELAYANAN</h4>
                <div class="space-y-2 text-xs sm:text-sm text-slate-300 font-light">
                    <p class="font-medium text-white">Kantor Desa Catur</p>
                    <p class="text-xs text-slate-300">Senin - Jumat: 08.00 - 15.30 WIB</p>
                    <p class="text-xs text-slate-400">Sabtu, Minggu & Libur: Tutup</p>
                </div>
            </div>

        </div>

        <!-- Bottom Sub-Footer Bar -->
        <div
            class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-400 font-semibold tracking-wider uppercase">
            <p>&copy; {{ date('Y') }} PEMERINTAH DESA CATUR | TIM PPK ORMAWA CATUR CERDAS</p>
            <div class="flex items-center gap-4 sm:gap-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">BERANDA</a>
                <a href="{{ route('public.profile') }}" class="hover:text-white transition">PROFIL</a>
                <a href="{{ route('warga.complaint.create') }}" class="hover:text-white transition">PENGADUAN</a>
            </div>
        </div>
    </div>
</footer>