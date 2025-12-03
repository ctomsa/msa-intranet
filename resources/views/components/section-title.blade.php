@props(['subtitle' => null])

<div {{ $attributes->class('mb-4 flex flex-col gap-1') }}>
    <h2 class="text-lg font-semibold tracking-tight">{{ $slot }}</h2>
    @if($subtitle)
        <p class="text-sm text-msa-muted">{{ $subtitle }}</p>
    @endif
</div>