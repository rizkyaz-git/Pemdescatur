@extends('layouts.public')

@section('title', 'Sampaikan Laporan & Pengaduan - Pemerintah Desa Catur')
@section('meta_description', 'Formulir laporan & pengaduan umum Pemerintah Desa Catur. Sampaikan keluhan, aspirasi, atau permasalahan Anda dan kami akan menindaklanjuti melalui WhatsApp.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
            ['label' => 'Layanan', 'url' => '/'],
            ['label' => 'Pengaduan']
        ]" />
                <div>
                    <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Sampaikan Laporan & Pengaduan
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Isi formulir di bawah. Admin Desa akan menghubungi Anda melalui
                        WhatsApp untuk menindaklanjuti.</p>
                </div>
            </div>

            {{-- Flash Success --}}
            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-green-800 font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
                <form action="{{ route('warga.complaint.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('nama') border-rose-500 @enderror">
                        @error('nama')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No WhatsApp --}}
                    <div>
                        <label for="no_whatsapp" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="no_whatsapp" id="no_whatsapp" value="{{ old('no_whatsapp') }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('no_whatsapp') border-rose-500 @enderror">
                        <p class="text-[11px] text-slate-400 mt-1">Admin akan menghubungi Anda melalui nomor ini untuk
                            menindaklanjuti laporan.</p>
                        @error('no_whatsapp')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    @php
                        $kategoris = [
                            'infrastruktur' => 'Infrastruktur & Fasilitas Umum',
                            'kependudukan' => 'Administrasi & Kependudukan',
                            'keamanan' => 'Keamanan & Ketertiban',
                            'lingkungan' => 'Lingkungan & Kebersihan',
                            'layanan_publik' => 'Layanan Publik',
                            'lainnya' => 'Lainnya',
                        ];
                    @endphp
                    <div x-data="{
                            open: false,
                            selected: '{{ old('kategori', '') }}',
                            labels: {{ json_encode($kategoris) }},
                            get selectedLabel() {
                                return this.labels[this.selected] || '-- Pilih Kategori --';
                            },
                            select(val) {
                                this.selected = val;
                                this.open = false;
                            }
                        }" @click.away="open = false" class="relative">
                        <label class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Kategori Pengaduan <span class="text-rose-500">*</span>
                        </label>

                        {{-- Hidden Input untuk Form Submission --}}
                        <input type="hidden" name="kategori" :value="selected" required>

                        {{-- Mode Mobile: Native Select --}}
                        <div class="sm:hidden">
                            <select x-model="selected"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('kategori') border-rose-500 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mode Desktop: Dropdown Gaya Navbar (Backdrop Blur, Animated, Checkmark) --}}
                        <div class="hidden sm:block relative">
                            <!-- Trigger Button -->
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm bg-slate-50/40 text-slate-900 cursor-pointer text-left transition"
                                :class="open ? 'border-[#0A3D29] ring-2 ring-[#0A3D29]/20' : ''">
                                <span x-text="selectedLabel"
                                    :class="selected ? 'text-slate-900 font-medium' : 'text-slate-400'"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0"
                                    :class="open ? 'rotate-180 text-[#0A3D29]' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Box (Gaya Navbar Dropdown) -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute left-0 mt-1.5 w-full rounded-md p-1.5 z-50 overflow-hidden shadow-xl bg-white/95 backdrop-blur-2xl border border-slate-200/90 text-[#20332A]"
                                style="display: none;">

                                <div class="space-y-0.5">
                                    @foreach($kategoris as $val => $label)
                                        <button type="button" @click="select('{{ $val }}')"
                                            class="flex items-center justify-between w-full px-3.5 py-2.5 text-xs font-semibold rounded-md text-left transition-colors duration-150 cursor-pointer"
                                            :class="selected === '{{ $val }}' ? 'bg-[#0A3D29]/10 text-[#0A3D29] font-bold' : 'text-slate-700 hover:bg-black/[0.04] hover:text-[#0A3D29]'">
                                            <span>{{ $label }}</span>
                                            <template x-if="selected === '{{ $val }}'">
                                                <svg class="w-4 h-4 text-[#0A3D29] shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </template>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @error('kategori')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Isi Laporan --}}
                    <div>
                        <label for="isi_laporan" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Isi Laporan / Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="isi_laporan" id="isi_laporan" rows="5" required
                            placeholder="Jelaskan secara rinci permasalahan yang Anda laporkan, termasuk lokasi dan kronologi kejadian..."
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('isi_laporan') border-rose-500 @enderror">{{ old('isi_laporan') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Minimal 10 karakter, maksimal 2.000 karakter.</p>
                        @error('isi_laporan')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lampiran Bukti (File Picker seragam dengan CRUD Admin) --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-800 mb-2">
                            Lampiran Bukti <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <x-file-picker name="lampiran" accept="image/jpeg,image/png,image/jpg,application/pdf"
                            dropzoneText="Tarik & lepas foto atau dokumen bukti ke sini atau" buttonText="Pilih Berkas" />
                        <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.</p>
                        @error('lampiran')
                            <p class="text-xs text-rose-600 font-medium mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="reset"
                            class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                            Reset
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-6 rounded-lg transition shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span>Kirim</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection