@extends('layouts.public')

@section('title', 'Beranda - Website Pemdes Catur')

@section('content')

    {{-- 1. Hero Section --}}
    @include('public.home.sections.hero')

    {{-- 2. Floating Shortcut Cards --}}
    @include('public.home.sections.shortcuts')

    {{-- 3. Berita Terkini --}}
    @include('public.home.sections.news')

    {{-- 4. Perpustakaan Digital Remen Maos --}}
    @include('public.home.sections.library')

    {{-- 5. Aparatur Desa --}}
    @include('public.home.sections.officials')

@endsection

@push('scripts')
    <script>
        // Scroll reveal using IntersectionObserver — fires global .scroll-reveal elements
        (function () {
            if (!('IntersectionObserver' in window)) {
                document.querySelectorAll('.scroll-reveal').forEach(function (el) {
                    el.classList.add('is-visible');
                });
                return;
            }
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.05, rootMargin: '0px 0px -20px 0px' });
            document.querySelectorAll('.scroll-reveal').forEach(function (el) {
                observer.observe(el);
            });
        })();
    </script>
@endpush