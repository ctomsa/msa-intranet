@props([
    'as' => 'div',
    'padding' => 'p-5',
])

@php
    $tag = $as;
@endphp

<{{ $tag }}
    {{ $attributes->class([
        'bg-msa-card/90 border border-msa-border/70 rounded-msa-card shadow-msa-card',
        'backdrop-blur-xl relative overflow-hidden',
        $padding,
    ]) }}
>
    {{-- лёгкий внутренний подсвет --}}
    <div class="pointer-events-none absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_0%_0%,rgba(123,97,255,0.25),transparent_55%)]"></div>
    <div class="relative">
        {{ $slot }}
    </div>
</{{ $tag }}>