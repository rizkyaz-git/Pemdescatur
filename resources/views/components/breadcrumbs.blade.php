@props(['items' => []])

<nav class="flex items-center text-xs font-semibold mb-2.5 text-left flex-wrap" aria-label="Breadcrumb">
    @foreach($items as $item)
        @if(!$loop->last && !empty($item['url']))
            <a href="{{ $item['url'] }}" class="text-[#0A3D29] hover:underline uppercase tracking-wider font-bold transition-colors">
                {{ $item['label'] ?? $item['name'] ?? '' }}
            </a>
            <span class="text-slate-300 mx-2 text-xs font-normal select-none">/</span>
        @else
            <span class="text-slate-500 font-medium truncate max-w-xs sm:max-w-md">
                {{ $item['label'] ?? $item['name'] ?? '' }}
            </span>
            @if(!$loop->last)
                <span class="text-slate-300 mx-2 text-xs font-normal select-none">/</span>
            @endif
        @endif
    @endforeach
</nav>
