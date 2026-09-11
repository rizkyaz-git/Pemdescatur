<div {{ $attributes->merge(['class' => 'bg-slate-50/80 rounded-xl p-2.5 sm:p-3.5 border border-slate-200/90 shadow-xs flex flex-col justify-between']) }} aria-hidden="true">
    <div>
        <!-- Photo Skeleton (Aspect 3:4, Rounded-lg matching real official card) -->
        <div class="aspect-[3/4] w-full rounded-lg skeleton-shimmer mb-2.5"></div>

        <!-- Position Line -->
        <div class="w-16 sm:w-20 h-2.5 rounded-sm skeleton-shimmer mb-1.5"></div>

        <!-- Name Lines (2 Lines) -->
        <div class="w-full h-3.5 rounded skeleton-shimmer mb-1"></div>
        <div class="w-2/3 h-3.5 rounded skeleton-shimmer"></div>
    </div>
</div>
