@extends('layouts.public')

@section('title', 'Pengajuan Surat - Pemerintah Desa Catur')
@section('meta_description', 'Formulir pengajuan surat resmi Pemerintah Desa Catur. Isi data diri Anda dan jenis surat yang dibutuhkan — admin desa akan menghubungi Anda melalui WhatsApp.')

@section('content')
    <div class="bg-white min-h-screen py-10 sm:py-14 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="text-left space-y-2">
                <x-breadcrumbs :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengajuan Surat']
        ]" />
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Pengajuan Surat
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Isi formulir di bawah. Petugas administrasi desa
                            akan memproses dan menghubungi Anda via WhatsApp.</p>
                    </div>
                    {{-- Tombol ke Template Cetak Mandiri --}}
                    <a href="{{ route('warga.letter.templates') }}"
                        class="h-10 rounded-xl bg-[#0A3D29] hover:bg-[#072B1D] text-white shadow-xs inline-flex items-center justify-center gap-2 px-4 text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer active:scale-95 shrink-0">
                        <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Template Cetak Mandiri</span>
                    </a>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
                <form action="{{ route('warga.letter.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="form_data[nama]" id="nama" value="{{ old('form_data.nama') }}" required
                            placeholder="Masukkan nama lengkap sesuai KTP"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 focus:bg-white transition @error('form_data.nama') border-rose-500 @enderror">
                        @error('form_data.nama')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="form_data[nik]" id="nik" value="{{ old('form_data.nik') }}" required
                            maxlength="16" inputmode="numeric" placeholder="16 digit NIK sesuai KTP / KK"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 focus:bg-white font-mono tracking-wider transition @error('form_data.nik') border-rose-500 @enderror">
                        @error('form_data.nik')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. WhatsApp --}}
                    <div>
                        <label for="telepon" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="form_data[telepon]" id="telepon" value="{{ old('form_data.telepon') }}"
                            required placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 focus:bg-white transition @error('form_data.telepon') border-rose-500 @enderror">
                        <p class="text-[11px] text-slate-400 mt-1">Petugas Desa akan menghubungi Anda melalui nomor ini
                            untuk verifikasi permohonan.</p>
                        @error('form_data.telepon')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Surat --}}
                    @php
                        $templatesList = $templates->mapWithKeys(function ($item) {
                            $label = $item->name . ($item->code ? ' (' . $item->code . ')' : '');
                            return [(string) $item->id => $label];
                        })->toArray();
                        $templatesList['lainnya'] = 'Lainnya (Tulis Manual)';

                        $initialTemplateId = (string) old('template_id', request('template_id', ''));
                        if (empty($initialTemplateId) && old('form_data.jenis_surat_lainnya')) {
                            $initialTemplateId = 'lainnya';
                        }
                    @endphp

                    <div x-data="{
                                    open: false,
                                    selected: '{{ $initialTemplateId }}',
                                    labels: {{ json_encode($templatesList) }},
                                    get selectedLabel() {
                                        return this.labels[this.selected] || '-- Pilih Jenis Surat --';
                                    },
                                    select(val) {
                                        this.selected = val;
                                        this.open = false;
                                        if (val === 'lainnya') {
                                            this.$nextTick(() => {
                                                const el = document.getElementById('jenis_surat_lainnya');
                                                if (el) el.focus();
                                            });
                                        }
                                    }
                                }" @click.away="open = false" class="relative">
                        <label class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Jenis Surat <span class="text-rose-500">*</span>
                        </label>

                        {{-- Hidden input for standard form submission --}}
                        <input type="hidden" name="template_id" :value="selected" required>

                        {{-- Mobile Select (sm:hidden) --}}
                        <div class="sm:hidden">
                            <select x-model="selected"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 @error('template_id') border-rose-500 @enderror">
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($templates as $tpl)
                                    <option value="{{ $tpl->id }}">
                                        {{ $tpl->name }}{{ $tpl->code ? ' (' . $tpl->code . ')' : '' }}
                                    </option>
                                @endforeach
                                <option value="lainnya">Lainnya (Tulis Manual)</option>
                            </select>
                        </div>

                        {{-- Desktop Dropdown (hidden sm:block) --}}
                        <div class="hidden sm:block relative">
                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full h-11 px-4 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm bg-slate-50/40 text-slate-900 cursor-pointer text-left transition shadow-2xs hover:bg-white"
                                :class="open ? 'border-[#0A3D29] ring-2 ring-[#0A3D29]/20 bg-white' : ''">
                                <span x-text="selectedLabel"
                                    :class="selected ? 'text-slate-900 font-semibold' : 'text-slate-400'"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0"
                                    :class="open ? 'rotate-180 text-[#0A3D29]' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-cloak 
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                class="absolute left-0 mt-1.5 w-full max-h-72 overflow-y-auto rounded-xl p-1.5 z-50 shadow-xl bg-white border border-slate-200 text-slate-800 space-y-0.5"
                                style="display: none;">

                                <div class="space-y-0.5">
                                    @foreach($templates as $tpl)
                                        @php $val = (string) $tpl->id; @endphp
                                        <button type="button" @click="select('{{ $val }}')"
                                            class="flex items-center justify-between w-full px-3.5 py-2.5 text-xs sm:text-sm font-medium rounded-lg text-left transition-colors duration-150 cursor-pointer"
                                            :class="selected === '{{ $val }}' ? 'bg-[#0A3D29] text-white font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-[#0A3D29]'">
                                            <span>{{ $tpl->name }}{{ $tpl->code ? ' (' . $tpl->code . ')' : '' }}</span>
                                            <template x-if="selected === '{{ $val }}'">
                                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </template>
                                        </button>
                                    @endforeach
                                </div>

                                {{-- Opsi Lainnya --}}
                                <div class="pt-1 mt-1 border-t border-slate-100">
                                    <button type="button" @click="select('lainnya')"
                                        class="flex items-center justify-between w-full px-3.5 py-2.5 text-xs sm:text-sm font-semibold rounded-lg text-left transition-colors duration-150 cursor-pointer"
                                        :class="selected === 'lainnya' ? 'bg-[#0A3D29] text-white' : 'text-slate-700 hover:bg-emerald-50/70 hover:text-[#0A3D29]'">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" :class="selected === 'lainnya' ? 'text-white' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Lainnya (Tulis Manual)</span>
                                        </div>
                                        <template x-if="selected === 'lainnya'">
                                            <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @error('template_id')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Form Tambahan Jika Memilih Lainnya --}}
                        <div x-show="selected === 'lainnya'" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-1.5 mt-3">
                            <label for="jenis_surat_lainnya" class="block text-[13px] font-semibold text-slate-800">
                                Nama / Jenis Surat yang Dibutuhkan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="form_data[jenis_surat_lainnya]" id="jenis_surat_lainnya"
                                value="{{ old('form_data.jenis_surat_lainnya') }}"
                                :required="selected === 'lainnya'"
                                placeholder="Contoh: Surat Rekomendasi, Surat Keterangan Belum Menikah, dll..."
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-white transition @error('form_data.jenis_surat_lainnya') border-rose-500 @enderror">
                            <p class="text-[11px] text-slate-500">Tuliskan nama atau jenis surat resmi yang Anda perlukan secara spesifik.</p>
                            @error('form_data.jenis_surat_lainnya')
                                <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Keperluan / Keterangan --}}
                    <div>
                        <label for="keperluan" class="block text-[13px] font-semibold text-slate-800 mb-1.5">
                            Keperluan / Keterangan Permohonan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="form_data[keperluan]" id="keperluan" rows="4" required
                            placeholder="Jelaskan maksud penggunaan surat ini (contoh: untuk keperluan pengajuan KUR bank, pendaftaran sekolah, dll)..."
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm text-slate-900 bg-slate-50/40 focus:bg-white transition @error('form_data.keperluan') border-rose-500 @enderror">{{ old('form_data.keperluan') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Minimal 10 karakter, maksimal 1.000 karakter.</p>
                        @error('form_data.keperluan')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="reset"
                            class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition cursor-pointer">
                            Reset
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#0A3D29] hover:bg-[#072B1D] text-white font-semibold text-xs py-2.5 px-6 rounded-lg transition shadow-xs cursor-pointer active:scale-95">
                            <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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