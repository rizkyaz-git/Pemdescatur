<div {{ $attributes->merge(['class' => 'space-y-2.5 w-full']) }} aria-hidden="true">
    <!-- Image Box Skeleton (Aspect 16:10, Rounded-xl matching real news card) -->
    <div class="w-full aspect-[16/10] rounded-xl skeleton-shimmer"></div>

    <!-- Content Lines Skeleton -->
    <div class="space-y-2 pt-1">
        <!-- Category Tag -->
        <div class="w-20 h-3 rounded-sm skeleton-shimmer"></div>
        <!-- Title 2 Lines -->
        <div class="w-full h-4 rounded skeleton-shimmer"></div>
        <div class="w-3/4 h-4 rounded skeleton-shimmer"></div>
        <!-- Date & Author Meta -->
        <div class="w-28 h-2.5 rounded skeleton-shimmer mt-1"></div>
        <!-- Excerpt Lines -->
        <div class="w-full h-2.5 rounded skeleton-shimmer"></div>
        <div class="w-4/5 h-2.5 rounded skeleton-shimmer"></div>
    </div>
</div>
