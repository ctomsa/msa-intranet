{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="space-y-6 lg:space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900">
                Мероприятия
            </h1>
        </div>

        <div class="msa-card">
            <div class="space-y-4">
                @forelse($events as $event)
                    <a href="{{ route('events.show', $event) }}"
                       class="group msa-card border border-slate-200 bg-white/80 p-4 sm:p-5
                              transition-all duration-200 hover:-translate-y-0.5 hover:border-slate-300
                              hover:bg-white hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] block">

                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm sm:text-[15px] font-semibold text-slate-900 leading-snug line-clamp-2">
                                {{ $event->title }}
                            </h3>

                            @if(!empty($event->type))
                                <span class="msa-badge-neutral ml-3 whitespace-nowrap">
                                    {{ $event->type }}
                                </span>
                            @endif
                        </div>

                        @if(!empty($event->description))
                            <p class="text-xs text-slate-500 mb-3 line-clamp-3">
                                {{ Str::limit($event->description, 160) }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">
                            @if(!empty($event->start_at))
                                <div class="inline-flex items-center gap-1">
                                    <span class="text-[11px]">📅</span>
                                    <span>
                                        {{ $event->start_at instanceof \Carbon\Carbon
                                            ? $event->start_at->format('d.m.Y H:i')
                                            : \Carbon\Carbon::parse($event->start_at)->format('d.m.Y H:i') }}
                                    </span>
                                </div>
                            @endif

                            @if(!empty($event->location))
                                <div class="inline-flex items-center gap-1">
                                    <span class="text-[11px]">📍</span>
                                    <span class="line-clamp-1 max-w-[200px]">
                                        {{ $event->location }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-500">
                        Мероприятий пока нет.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection