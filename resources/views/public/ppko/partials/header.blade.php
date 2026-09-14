<!-- ========================================================================= -->
<!-- 1. TOP HEADER: ROUTE BREADCRUMBS & JUDUL HALAMAN                          -->
<!-- ========================================================================= -->
<header class="text-left space-y-2">
    <x-breadcrumbs :items="[
        ['label' => 'BERANDA', 'url' => route('home')],
        ['label' => 'PPK Ormawa']
    ]" />
    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#20332A] tracking-tight leading-tight">
        PPK Ormawa Catur Cerdas
    </h1>
</header>
