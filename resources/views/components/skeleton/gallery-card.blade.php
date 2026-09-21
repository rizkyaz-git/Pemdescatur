@props(['aspect' => 'aspect-[4/5]'])

<div {{ $attributes->merge(['class' => 'break-inside-avoid mb-3 sm:mb-5 lg:mb-6 rounded-xl overflow-hidden bg-slate-200 relative skeleton-shimmer ' . $aspect]) }} aria-hidden="true">
    <!-- Bottom Title Placeholder with Subtle Dark Gradient -->
    <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5 space-y-2 bg-gradient-to-t from-black/50 to-transparent">
        <div class="w-4/5 h-4 rounded-md bg-white/40"></div>
        <div class="w-1/2 h-3.5 rounded-md bg-white/30"></div>
    </div>
</div>
