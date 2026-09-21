@php
    $coverMobileCandidates = [
        'images/ppko/ppko_display.png',
        'images/ppko_display.png',
        'assets/ppko/ppko_display.png',
        'assets/images/ppko_display.png',
        'images/ppko/cover_ppko_mobile.png',
        'assets/ppko/cover_ppko_mobile.png',
        'assets/images/cover_ppko_mobile.png',
        'images/cover_ppko_mobile.png',
    ];
    $ppkoCoverMobile = null;
    foreach ($coverMobileCandidates as $candidate) {
        if (file_exists(public_path($candidate))) {
            $ppkoCoverMobile = asset($candidate) . '?v=' . filemtime(public_path($candidate));
            break;
        }
    }
    if (!$ppkoCoverMobile) {
        $ppkoCoverMobile = asset('images/ppko/ppko_display.png');
    }
@endphp

<!-- ========================================================================= -->
<!-- 2. TENTANG PROGRAM & DETAIL PROGRAM                                       -->
<!-- ========================================================================= -->
<section id="tentang-program"
    class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start ppko-section-entrance pt-2 sm:pt-4">
    <div id="ppko-left-panel" class="lg:col-span-7 flex flex-col space-y-6">

        <!-- Kartu Pembungkus Tentang Program -->
        <div id="ppko-tentang-card"
            class="bg-white rounded-lg border border-[#DCE6DA] shadow-xs p-5 sm:p-6 space-y-4 shrink-0">
            <div class="flex items-center justify-between pb-3 border-b border-[#DCE6DA]">
                <div class="flex items-center gap-2.5">
                    <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#20332A] leading-tight">
                        Tentang Catur Cerdas
                    </h2>
                </div>
            </div>

            <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed font-normal"
                style="text-align: justify;">
                <div class="catur-cerdas space-y-4">
                    <div class="intro">
                        <p style="text-align: justify;">
                            <strong>Catur Cerdas</strong> merupakan program PPKO Ormawa oleh
                            <strong>IMM Al-Ghozali Fakultas Psikologi, Universitas Muhammadiyah Surakarta</strong>
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
                                <span class="program-desc">Ruang belajar dan literasi kreatif bagi anak-anak komunitas TPA.</span>
                            </li>
                            <li class="program-item">
                                <span class="program-num">3.</span>
                                <span class="program-name">Pojok UMKM Go Digital</span>
                                <span class="program-colon">:</span>
                                <span class="program-desc">Pendampingan pemanfaatan WhatsApp Business dan teknologi digital untuk pengembangan usaha.</span>
                            </li>
                            <li class="program-item">
                                <span class="program-num">4.</span>
                                <span class="program-name">Pojok Budaya</span>
                                <span class="program-colon">:</span>
                                <span class="program-desc">Penguatan peran remaja dan Karang Taruna dalam mengenal serta mengembangkan budaya lokal.</span>
                            </li>
                            <li class="program-item">
                                <span class="program-num">5.</span>
                                <span class="program-name">Pojok Tani</span>
                                <span class="program-colon">:</span>
                                <span class="program-desc">Penguatan pengetahuan dan optimalisasi potensi pertanian bersama kelompok tani.</span>
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
    </div>

    <!-- Panel Kanan: Detail Program & Banner Showcase PPKO -->
    <div id="ppko-right-panel" class="lg:col-span-5 flex flex-col space-y-6">

        <!-- Banner Showcase PPKO Card -->
        <div class="rounded-lg overflow-hidden border border-[#DCE6DA] shadow-xs bg-slate-100 group shrink-0 relative"
            x-data="{ bannerLoaded: false, bannerError: false }"
            x-init="if ($refs.bannerImg && $refs.bannerImg.complete) { bannerLoaded = true; }">
            <div x-show="!bannerLoaded && !bannerError" class="absolute inset-0 skeleton-shimmer z-10 pointer-events-none"></div>
            <img x-ref="bannerImg" src="{{ $ppkoCoverMobile }}" alt="PPKO Catur Cerdas Display Banner" loading="eager"
                fetchpriority="high" decoding="async" width="1920" height="1080"
                x-on:load="bannerLoaded = true;" x-on:error="bannerError = true;"
                class="w-full h-auto aspect-video object-cover object-center group-hover:scale-[1.01] transition-transform duration-500 transition-opacity duration-300"
                :class="(bannerLoaded && !bannerError) ? 'opacity-100' : 'opacity-0'">
        </div>

        <!-- Kartu 1: Detail Program & Mitra Program -->
        <div id="ppko-detail-card"
            class="bg-white rounded-lg border border-[#DCE6DA] shadow-xs p-5 sm:p-6 space-y-3 shrink-0 overflow-hidden">
            <div class="pb-3 border-b border-[#DCE6DA]">
                <h3 class="font-serif text-lg sm:text-xl font-bold text-[#20332A] leading-tight">
                    Detail Program
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <tbody class="text-slate-700">
                        @forelse($programDetails ?? [] as $index => $detail)
                            @php /** @var \App\Models\PpkoProgramDetail $detail */ @endphp
                            <tr class="border-b border-[#DCE6DA] last:border-b-0 hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 pr-3 pl-0 font-bold text-[#20332A] align-top w-[36%] sm:w-[32%] leading-relaxed">
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
                                                        <span class="font-bold text-[#0A3D29] select-none text-xs sm:text-sm shrink-0 leading-relaxed">{{ $m[1] }}.</span>
                                                        <span class="text-justify text-slate-700 leading-relaxed">{{ $m[2] }}</span>
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
            <div class="border-t border-[#DCE6DA] pt-3.5 sm:pt-4 space-y-2 sm:space-y-2.5">
                <h4 class="text-xs font-semibold text-slate-500 text-center tracking-wider uppercase">
                    Mitra Program</h4>
                <div class="flex items-center justify-center gap-1.5 xs:gap-2 sm:gap-2.5 w-full flex-nowrap pt-1">
                    <a href="https://kemdiktisaintek.go.id/" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="Kemendiktisaintek">
                        <img src="{{ asset('images/TUTWURI.png') }}" alt="Tut Wuri Handayani"
                            loading="lazy" decoding="async"
                            class="h-6.5 sm:h-7.5 w-auto max-w-[32px] sm:max-w-[36px] object-contain">
                    </a>
                    <a href="https://kemdiktisaintek.go.id/en" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="Diktisaintek Berdampak">
                        <img src="{{ asset('images/DIKTISAINTEK.png') }}" alt="Diktisaintek"
                            loading="lazy" decoding="async"
                            class="h-4.5 sm:h-5.5 w-auto max-w-[50px] sm:max-w-[58px] object-contain">
                    </a>
                    <a href="https://ppkormawa.kemdiktisaintek.go.id/" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="PPK Ormawa">
                        <img src="{{ asset('images/PPK_ORMAWA.png') }}" alt="PPK Ormawa" loading="lazy"
                            decoding="async"
                            class="h-6.5 sm:h-7.5 w-auto max-w-[32px] sm:max-w-[36px] object-contain">
                    </a>
                    <a href="https://www.ums.ac.id/" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="Universitas Muhammadiyah Surakarta">
                        <img src="{{ asset('images/UMS.png') }}"
                            alt="Universitas Muhammadiyah Surakarta" loading="lazy" decoding="async"
                            class="h-4.5 sm:h-5.5 w-auto max-w-[50px] sm:max-w-[58px] object-contain">
                    </a>
                    <a href="https://www.instagram.com/imm_alghozali/" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="Ikatan Mahasiswa Muhammadiyah Al-Ghozali Fakultas Psikologi UMS">
                        <img src="{{ asset('images/IMMALGHO.png') }}" alt="IMM Al-Ghozali"
                            loading="lazy" decoding="async"
                            class="h-6.5 sm:h-7.5 w-auto max-w-[32px] sm:max-w-[36px] object-contain">
                    </a>
                    <a href="https://www.instagram.com/ppko_caturcerdas/" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="PPK Ormawa Catur Cerdas UMS 2026">
                        <img src="{{ asset('images/CATURCERDAS.png') }}" alt="Catur Cerdas"
                            loading="lazy" decoding="async"
                            class="h-6.5 sm:h-7.5 w-auto max-w-[34px] sm:max-w-[38px] object-contain">
                    </a>
                    <a href="https://boyolali.go.id/" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center shrink-0 transition-transform hover:scale-110 active:scale-95 focus:outline-none"
                        title="Pemerintah Kabupaten Boyolali">
                        <img src="{{ asset('images/PEMKABBYL.png') }}" alt="Pemkab Boyolali"
                            loading="lazy" decoding="async"
                            class="h-6.5 sm:h-7.5 w-auto max-w-[26px] sm:max-w-[30px] object-contain">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
