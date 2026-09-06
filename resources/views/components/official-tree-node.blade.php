@props(['official', 'level' => 0])

<div class="flex flex-col items-center">
    <!-- Official Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 border border-[#bfcaba] p-5 w-64 text-center group relative transform hover:-translate-y-1">
        <div class="relative w-24 h-24 mx-auto mb-3">
            @if($official->photo_path)
                <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-[#0d631b] shadow-xs">
            @else
                <div class="w-24 h-24 rounded-full bg-emerald-100 border-4 border-[#0d631b] flex items-center justify-center text-[#0d631b] text-2xl font-bold font-serif shadow-xs">
                    {{ strtoupper(substr($official->name, 0, 2)) }}
                </div>
            @endif
        </div>
        
        <h4 class="font-serif font-bold text-base text-[#0d1c2f] group-hover:text-[#0d631b] transition leading-snug">
            {{ $official->name }}
        </h4>
        <p class="text-xs font-semibold text-[#855300] bg-amber-50 inline-block px-3 py-1 rounded-full border border-amber-200 mt-1.5">
            {{ $official->position }}
        </p>

        @if($official->phone || $official->email)
            <div class="mt-3 pt-3 border-t border-slate-100 text-xs text-slate-500 space-y-0.5">
                @if($official->phone) <p>📞 {{ $official->phone }}</p> @endif
                @if($official->email) <p>📧 {{ $official->email }}</p> @endif
            </div>
        @endif
    </div>

    <!-- Children Nodes Render Recursively -->
    @if($official->children && $official->children->count() > 0)
        <!-- Vertical connector line -->
        <div class="w-0.5 h-8 bg-[#0d631b]"></div>
        
        <!-- Horizontal connector & children grid -->
        <div class="flex flex-wrap justify-center gap-8 relative pt-4 border-t-2 border-[#0d631b]">
            @foreach($official->children as $child)
                <x-official-tree-node :official="$child" :level="$level + 1" />
            @endforeach
        </div>
    @endif
</div>
