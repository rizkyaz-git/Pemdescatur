@props([
    'name' => 'file',
    'id' => null,
    'accept' => null,
    'current' => null,
    'currentName' => null,
    'currentType' => null,
    'multiple' => false,
    'required' => false,
    'dropzoneText' => 'Tarik & lepas file ke sini atau',
    'buttonText' => 'Pilih Berkas',
])

@php
    $inputId = $id ?? $name . '_' . uniqid();
    
    // Auto-detect current type if current URL is given
    $initialType = $currentType;
    if (!$initialType && $current) {
        $ext = strtolower(pathinfo($current, PATHINFO_EXTENSION));
        $initialType = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']) ? 'image' : 'file';
    }
@endphp

<div x-data="{
    isDragging: false,
    files: [
        @if($current)
        {
            name: '{{ addslashes($currentName ?? basename($current)) }}',
            type: '{{ $initialType }}',
            ext: '{{ strtolower(pathinfo($currentName ?? $current, PATHINFO_EXTENSION)) }}',
            url: '{{ $current }}',
            isExisting: true
        }
        @endif
    ],
    handleDrop(e) {
        this.isDragging = false;
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length) {
            this.$refs.input.files = dt.files;
            this.handleFiles(dt.files);
        }
    },
    handleSelect(e) {
        if (e.target.files && e.target.files.length) {
            this.handleFiles(e.target.files);
        }
    },
    handleFiles(fileList) {
        const isMultiple = {{ $multiple ? 'true' : 'false' }};
        const selected = isMultiple ? Array.from(fileList) : [fileList[0]];
        this.files = selected.map(f => {
            const isImg = f.type.startsWith('image/') || /\.(jpe?g|png|webp|gif|svg)$/i.test(f.name);
            const ext = f.name.split('.').pop().toLowerCase();
            return {
                name: f.name,
                type: isImg ? 'image' : 'file',
                ext: ext,
                url: isImg ? URL.createObjectURL(f) : null,
                isExisting: false
            };
        });
    },
    getFileCategory(ext) {
        if (!ext) return 'file';
        ext = ext.toLowerCase();
        if (['pdf'].includes(ext)) return 'pdf';
        if (['doc', 'docx', 'odt', 'rtf'].includes(ext)) return 'doc';
        if (['xls', 'xlsx', 'csv'].includes(ext)) return 'xls';
        if (['ppt', 'pptx'].includes(ext)) return 'ppt';
        if (['zip', 'rar', '7z', 'tar', 'gz'].includes(ext)) return 'archive';
        return 'file';
    }
}" class="w-full">
    <!-- Layout: 2 Kolom di Desktop (md+), 1 Kolom di Tablet/Mobile -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
        
        <!-- SISI KIRI: Area Upload / Dropzone -->
        <div 
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop($event)"
            @click="$refs.input.click()"
            :class="isDragging ? 'border-[#0F4C3A] bg-emerald-50/60' : 'border-[#CBD5E1] hover:border-[#0F4C3A]/60 bg-[#F8FAFC] hover:bg-slate-50'"
            class="border-2 border-dashed rounded-xl p-5 flex flex-col items-center justify-center text-center cursor-pointer transition-colors duration-150 min-h-[180px] sm:min-h-[200px]"
        >
            <input 
                x-ref="input"
                type="file" 
                name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
                id="{{ $inputId }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($multiple) multiple @endif
                @if($required && !$current) required @endif
                @change="handleSelect($event)"
                class="sr-only"
            >

            <!-- Minimalist Upload Icon -->
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#0F4C3A] flex items-center justify-center mb-2.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
            </div>

            <!-- Concise & Clear Wording -->
            <p class="text-xs text-slate-600 mb-2">
                {{ $dropzoneText }}
            </p>

            <button 
                type="button" 
                class="px-3.5 py-1.5 rounded-lg bg-white border border-[#E2E8F0] shadow-2xs hover:bg-[#0F4C3A] hover:text-white hover:border-[#0F4C3A] text-[#0F4C3A] text-xs font-semibold transition cursor-pointer"
                tabindex="-1"
            >
                {{ $buttonText }}
            </button>
        </div>

        <!-- SISI KANAN: Area Preview File -->
        <div class="border border-[#E2E8F0] rounded-xl bg-[#F8FAFC] p-3 flex flex-col items-center justify-center min-h-[180px] sm:min-h-[200px] overflow-hidden">
            
            <!-- State 1: Belum Ada Berkas Dipilih -->
            <template x-if="files.length === 0">
                <div class="flex flex-col items-center justify-center text-center p-4 text-slate-400">
                    <svg class="w-9 h-9 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xs font-medium">Pratinjau berkas</span>
                </div>
            </template>

            <!-- State 2: Satu Berkas (Single File) -->
            <template x-if="files.length === 1">
                <div class="w-full h-full flex items-center justify-center">
                    
                    <!-- Preview Jika Gambar -->
                    <template x-if="files[0].type === 'image'">
                        <div class="w-full h-full flex items-center justify-center rounded-lg bg-white p-1 border border-[#E2E8F0]/70 max-h-48 overflow-hidden">
                            <img :src="files[0].url" :alt="files[0].name" class="max-h-44 w-full object-contain rounded-md">
                        </div>
                    </template>

                    <!-- Preview Jika Non-Gambar: Ikon Format + Nama File Saja (Tanpa Metadata Apapun) -->
                    <template x-if="files[0].type !== 'image'">
                        <div class="flex flex-col items-center justify-center text-center p-3.5 w-full bg-white rounded-lg border border-[#E2E8F0]">
                            <!-- Format Icon Container -->
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-2"
                                 :class="{
                                     'bg-red-50 text-red-600': getFileCategory(files[0].ext) === 'pdf',
                                     'bg-blue-50 text-blue-600': getFileCategory(files[0].ext) === 'doc',
                                     'bg-emerald-50 text-emerald-600': getFileCategory(files[0].ext) === 'xls',
                                     'bg-amber-50 text-amber-600': getFileCategory(files[0].ext) === 'ppt',
                                     'bg-purple-50 text-purple-600': getFileCategory(files[0].ext) === 'archive',
                                     'bg-slate-100 text-slate-600': getFileCategory(files[0].ext) === 'file'
                                 }">
                                <!-- PDF Icon -->
                                <template x-if="getFileCategory(files[0].ext) === 'pdf'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </template>
                                <!-- Word / Doc Icon -->
                                <template x-if="getFileCategory(files[0].ext) === 'doc'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </template>
                                <!-- Excel / Spreadsheet Icon -->
                                <template x-if="getFileCategory(files[0].ext) === 'xls'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 4h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </template>
                                <!-- PowerPoint / Presentation Icon -->
                                <template x-if="getFileCategory(files[0].ext) === 'ppt'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                    </svg>
                                </template>
                                <!-- Archive Icon (ZIP/RAR) -->
                                <template x-if="getFileCategory(files[0].ext) === 'archive'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </template>
                                <!-- Generic Document Icon -->
                                <template x-if="getFileCategory(files[0].ext) === 'file'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </template>
                            </div>
                            
                            <!-- Hanya Nama / Judul File -->
                            <p class="font-semibold text-xs text-[#1E293B] max-w-full truncate px-2" :title="files[0].name" x-text="files[0].name"></p>
                        </div>
                    </template>
                </div>
            </template>

            <!-- State 3: Multiple Files -->
            <template x-if="files.length > 1">
                <div class="w-full grid grid-cols-2 gap-2 max-h-52 overflow-y-auto p-1 custom-scrollbar">
                    <template x-for="(file, idx) in files" :key="idx">
                        <div class="rounded-lg border border-[#E2E8F0] p-2 bg-white flex items-center gap-2 overflow-hidden">
                            <template x-if="file.type === 'image'">
                                <img :src="file.url" :alt="file.name" class="w-9 h-9 rounded-md object-cover shrink-0">
                            </template>
                            <template x-if="file.type !== 'image'">
                                <div class="w-9 h-9 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </template>
                            <span class="text-xs font-medium text-[#1E293B] truncate" :title="file.name" x-text="file.name"></span>
                        </div>
                    </template>
                </div>
            </template>

        </div>
    </div>
</div>
