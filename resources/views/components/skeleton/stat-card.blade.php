<div {{ $attributes->merge(['class' => 'bg-white rounded-[20px] p-6 border border-[#E2E8F0] shadow-2xs flex flex-col justify-between']) }} aria-hidden="true">
    <div class="flex items-start justify-between">
        <div class="space-y-2.5 w-2/3">
            <!-- Badge Pill -->
            <div class="w-24 h-4 rounded-full skeleton-shimmer"></div>
            <!-- Label -->
            <div class="w-32 h-3 rounded skeleton-shimmer"></div>
            <!-- Big Number -->
            <div class="w-20 sm:w-28 h-8 rounded skeleton-shimmer"></div>
        </div>
        <!-- Rounded Icon Box -->
        <div class="w-12 h-12 rounded-2xl skeleton-shimmer shrink-0"></div>
    </div>

    <div class="pt-4 mt-4 border-t border-[#F1F5F9] flex items-center justify-between">
        <div class="w-32 h-2.5 rounded skeleton-shimmer"></div>
        <div class="w-16 h-2.5 rounded skeleton-shimmer"></div>
    </div>
</div>
