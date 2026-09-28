@php
    $itemImageSrc = $item->image_path
        ? asset('storage/' . $item->image_path)
        : asset($defaultImages[$item->id % count($defaultImages)]);
@endphp

<a href="{{ route('public.news.show', $item->slug) }}"
   class="group flex gap-3 items-start py-2.5 border-b border-slate-100 last:border-b-0 last:pb-0">
    <div class="w-20 h-14 rounded-md overflow-hidden bg-slate-100 shrink-0">
        <img src="{{ $itemImageSrc }}"
             alt="{{ $item->title }}"
             loading="lazy"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    <div class="min-w-0 flex-1 space-y-1">
        <h3 class="font-semibold text-xs text-slate-900 group-hover:text-[#0A3D29] transition-colors line-clamp-2 leading-snug">
            {{ $item->title }}
        </h3>
        <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 font-medium">
            <span>{{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}</span>
        </div>
    </div>
</a>
