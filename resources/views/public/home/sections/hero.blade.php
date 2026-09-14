<!-- ========================================================= -->
<!-- SECTION 1: HERO SECTION (FULL LANDSCAPE BACKGROUND WITH SOFT GRADIENT OVERLAY) -->
<!-- ========================================================= -->
<section
    class="relative w-full bg-[#0A3D29] overflow-hidden -mt-20 pt-28 pb-36 min-h-screen min-h-[100dvh] flex flex-col justify-center items-center sm:min-h-0 sm:block sm:pt-44 sm:pb-32 lg:pt-48 lg:pb-36">

    @php
        $heroImageSrc = (!empty($globalHeroImage) && (file_exists(public_path('storage/' . $globalHeroImage)) || file_exists(storage_path('app/public/' . $globalHeroImage))))
            ? asset('storage/' . $globalHeroImage)
            : asset('images/hero_landscape.png');
    @endphp
    <!-- Hero Background Image - LCP optimized (eager + fetchpriority=high) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroImageSrc }}" alt="Pemerintah Desa Catur Sambi Boyolali"
            fetchpriority="high"
            loading="eager"
            decoding="async"
            class="w-full h-full object-cover object-center brightness-[0.58] [mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)] -webkit-[mask-image:linear-gradient(to_bottom,black_85%,transparent_100%)]">
        <!-- Soft Green Gradient Overlay for Text Contrast & High Image Visibility -->
        <div
            class="absolute inset-0 bg-gradient-to-b from-[#041A12]/60 via-[#072F20]/45 to-[#0A3D29]/95 pointer-events-none">
        </div>
    </div>

    <!-- Content Container (Centered Vertically on Mobile, Exact Original Layout on Desktop) -->
    <div
        class="relative z-10 max-w-[1280px] w-full mx-auto px-4 sm:px-6 lg:px-8 text-center flex-1 flex flex-col justify-center items-center py-5 sm:py-0 sm:block">
        <div
            class="max-w-xl sm:max-w-3xl lg:max-w-4xl mx-auto space-y-3 sm:space-y-6 flex flex-col items-center pt-0 sm:pt-8 lg:pt-10">

            <!-- 1. Headline -->
            <h1
                class="font-serif text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white leading-[1.2] sm:leading-[1.16] tracking-tight text-center max-w-4xl mx-auto drop-shadow-md fade-in-up">
                Selamat Datang di Website Resmi Pemerintah Desa Catur
            </h1>

            <!-- 2. Location Address Text -->
            <p
                class="text-xs sm:text-sm lg:text-base font-medium text-white/90 tracking-wide flex items-center justify-center gap-1.5 drop-shadow-sm mx-auto fade-in-up fade-in-up-d1">
                <span class="whitespace-normal sm:whitespace-nowrap">Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi,
                    Kab. Boyolali, Jawa Tengah 57376</span>
            </p>

        </div>
    </div>

</section>
