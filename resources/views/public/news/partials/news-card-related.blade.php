@php
    $itemImageSrc = $item->image_path
        ? asset('storage/' . $item->image_path)
        : asset($defaultImages[$item->id % count($defaultImages)]);
@endphp

<a href="{{ route('public.news.show', $item->slug) }}"
   class="group block">
    <div class="aspect-[16/10] w-full overflow-hidden rounded-md bg-slate-100">
        <img src="{{ $itemImageSrc }}"
             alt="{{ $item->title }}"
             loading="lazy"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    <div class="pt-2.5 space-y-1">
        <h3 class="font-semibold text-[13px] text-slate-900 group-hover:text-[#0A3D29] transition-colors line-clamp-2 leading-snug">
            {{ $item->title }}
        </h3>
        <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 font-medium">
            <span>{{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}</span>
        </div>
    </div>
</a>
