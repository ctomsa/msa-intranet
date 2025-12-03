@props([
    'variant' => 'default', // default | accent | danger | success
])

@php
    $base = 'inline-flex items-center px-2.5 py-0.5 rounded-msa-pill text-[11px] font-medium tracking-wide';
    $map = [
        'default' => 'bg-msa-badgeBg text-msa-muted',
        'accent'  => 'bg-msa-accent/15 text-msa-accent border border-msa-accent/40',
        'danger'  => 'bg-red-500/10 text-red-400 border border-red-500/40',
        'success' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/40',
    ];
@endphp

<span {{ $attributes->class([$base, $map[$variant] ?? $map['default']]) }}>
    {{ $slot }}
</span>