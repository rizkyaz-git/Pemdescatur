<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 bg-[#0B231A] relative overflow-hidden">

        <!-- Latar Belakang Minimalis Halus -->
        @php
            $bgImage = file_exists(public_path('images/hero_landscape.png'))
                ? asset('images/hero_landscape.png')
                : (file_exists(public_path('images/sawah_irigasi.png')) ? asset('images/sawah_irigasi.png') : asset('images/cover_ppko.png'));
        @endphp
        <div class="absolute inset-0 z-0 select-none pointer-events-none">
            <img src="{{ $bgImage }}" alt="Latar Belakang Desa Catur"
                class="w-full h-full object-cover object-center opacity-15 filter blur-[1px]">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0B231A]/95 via-[#0B231A]/90 to-[#071913]/95"></div>
        </div>

        <!-- Tombol Kembali ke Beranda -->
        <div class="absolute top-5 left-5 z-20">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-xs font-medium text-slate-300 hover:text-white transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Kartu Register Minimalis -->
        <div class="relative z-10 w-full max-w-sm">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8">

                <!-- Header Brand & Judul -->
                <div class="text-center mb-6">
                    @if(file_exists(public_path('images/logo_catur.png')))
                        <img src="{{ asset('images/logo_catur.png') }}" alt="Logo Desa Catur"
                            class="w-12 h-12 mx-auto object-contain mb-3">
                    @endif
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Daftar Akun Baru
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Pemerintah Desa Catur
                    </p>
                </div>

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-medium text-slate-700 mb-1">
                            Nama Lengkap
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="masukkan nama lengkap..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29] transition @error('name') border-rose-300 ring-rose-200 @enderror">
                        @error('name')
                            <p class="text-[11px] text-rose-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-700 mb-1">
                            Alamat Email
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="masukkan email..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29] transition @error('email') border-rose-300 ring-rose-200 @enderror">
                        @error('email')
                            <p class="text-[11px] text-rose-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Kata Sandi -->
                    <div x-data="{ show: false }">
                        <label for="password" class="block text-xs font-medium text-slate-700 mb-1">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="new-password" placeholder="masukkan kata sandi..."
                                class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29] transition @error('password') border-rose-300 ring-rose-200 @enderror">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                                aria-label="Lihat kata sandi">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] text-rose-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Kata Sandi -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1">
                            Konfirmasi Kata Sandi
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="ulangi kata sandi..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#0A3D29] focus:ring-1 focus:ring-[#0A3D29] transition @error('password_confirmation') border-rose-300 ring-rose-200 @enderror">
                        @error('password_confirmation')
                            <p class="text-[11px] text-rose-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Daftar -->
                    <div class="pt-1">
                        <button type="submit"
                            class="w-full bg-[#0A3D29] hover:bg-[#072C21] active:bg-[#051F17] text-white font-medium text-xs sm:text-sm py-2.5 px-4 rounded-lg transition-colors duration-150 cursor-pointer">
                            Daftar
                        </button>
                    </div>
                </form>

                <!-- Switch ke Login -->
                <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-[#0A3D29] hover:underline ml-1">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
