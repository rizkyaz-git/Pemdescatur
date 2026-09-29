@props([
    'href',
    'label' => 'Lihat Semua',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'see-all-link']) }}>
    <span>{{ $label }}</span>
    <svg class="see-all-link__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
    </svg>
</a>
