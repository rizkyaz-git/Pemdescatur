<tr {{ $attributes->merge(['class' => 'border-b border-[#F1F5F9]']) }} x-show="!isReady" aria-hidden="true">
    <td class="px-6 py-4">
        <div class="space-y-1.5 max-w-md">
            <div class="w-3/4 h-4 rounded-md skeleton-shimmer"></div>
            <div class="w-1/2 h-3 rounded-md skeleton-shimmer"></div>
        </div>
    </td>
    <td class="px-6 py-4">
        <div class="w-20 h-6 rounded-md skeleton-shimmer"></div>
    </td>
    <td class="px-6 py-4">
        <div class="w-20 h-6 rounded-full skeleton-shimmer"></div>
    </td>
    <td class="px-6 py-4">
        <div class="w-24 h-3.5 rounded skeleton-shimmer"></div>
    </td>
    <td class="px-6 py-4 text-right">
        <div class="inline-block w-16 h-7 rounded-lg skeleton-shimmer"></div>
    </td>
</tr>
