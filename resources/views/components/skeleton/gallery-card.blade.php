<div {{ $attributes->merge(['class' => 'bg-white rounded-xl overflow-hidden border border-slate-200/90 shadow-xs flex flex-col']) }} aria-hidden="true">
    <!-- Image Box Skeleton with Badge Placeholder -->
    <div class="relative aspect-[16/10] w-full skeleton-shimmer">
        <div class="absolute top-3 left-3 w-16 h-5 rounded-full bg-white/70"></div>
    </div>

    <!-- Content Skeleton -->
    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
        <div class="space-y-2">
            <div class="w-full h-4 rounded skeleton-shimmer"></div>
            <div class="w-3/4 h-4 rounded skeleton-shimmer"></div>
            <div class="w-1/2 h-2.5 rounded skeleton-shimmer pt-1"></div>
        </div>
        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
            <div class="w-20 h-2.5 rounded skeleton-shimmer"></div>
            <div class="w-16 h-2.5 rounded skeleton-shimmer"></div>
        </div>
    </div>
</div>
