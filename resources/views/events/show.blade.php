@extends('layouts.app')

@section('content')
    @php
        $start = $event->start_at ?? null;
        $end   = $event->end_at   ?? null;

        $organizer = $event->organizer ?? null;
        if (is_array($organizer)) {
            $organizerName = $organizer['name'] ?? null;
        } elseif (is_object($organizer)) {
            $organizerName = $organizer->name ?? null;
        } else {
            $organizerName = $organizer;
        }
    @endphp

    <div class="space-y-6">
        {{-- Back --}}
        <div>
            <a href="{{ route('events.index') }}"
               class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                ← К мероприятиям
            </a>
        </div>

        {{-- Карточка мероприятия --}}
        <article class="msa-card rounded-3xl p-6 sm:p-8 space-y-5">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-2">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                        {{ $event->title }}
                    </h1>

                    @if(!empty($event->subtitle))
                        <p class="text-sm text-slate-600">
                            {{ $event->subtitle }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 text-[11px] justify-end">
                    @if(!empty($event->type))
                        <span class="msa-badge msa-badge-muted">
                            {{ $event->type }}
                        </span>
                    @endif

                    @if(!empty($event->is_online))
                        <span class="msa-badge msa-badge-muted">
                            Online
                        </span>
                    @endif
                </div>
            </div>

            {{-- Дата / место / организатор --}}
            <div class="grid gap-4 sm:grid-cols-3 text-sm text-slate-600">
                <div class="space-y-1">
                    <div class="font-medium text-slate-900">Когда</div>
                    @if($start)
                        <div>
                            {{ $start instanceof \Carbon\Carbon ? $start->format('d.m.Y') : \Carbon\Carbon::parse($start)->format('d.m.Y') }}
                        </div>
                        <div class="text-slate-500">
                            {{ $start instanceof \Carbon\Carbon ? $start->format('H:i') : \Carbon\Carbon::parse($start)->format('H:i') }}
                            @if($end)
                                – {{ $end instanceof \Carbon\Carbon ? $end->format('H:i') : \Carbon\Carbon::parse($end)->format('H:i') }}
                            @endif
                        </div>
                    @else
                        <div class="text-slate-500">Дата и время уточняются</div>
                    @endif
                </div>

                <div class="space-y-1">
                    <div class="font-medium text-slate-900">Где</div>
                    @if(!empty($event->location))
                        <div>{{ $event->location }}</div>
                    @else
                        <div class="text-slate-500">
                            @if(!empty($event->is_online))
                                Онлайн-формат
                            @else
                                Локация уточняется
                            @endif
                        </div>
                    @endif
                </div>

                <div class="space-y-1">
                    <div class="font-medium text-slate-900">Организатор</div>
                    @if(!empty($organizerName))
                        <div>{{ $organizerName }}</div>
                    @else
                        <div class="text-slate-500">Не указано</div>
                    @endif

                    @if(!empty($event->participants))
                        <div class="text-[13px] text-slate-500">
                            Участников: {{ $event->participants }}
                        </div>
                    @endif
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- Описание --}}
            <div class="prose prose-sm sm:prose-base max-w-none text-slate-700">
                @if(!empty($event->description))
                    {!! nl2br(e($event->description)) !!}
                @else
                    <p>Описание мероприятия пока не добавлено.</p>
                @endif
            </div>

            {{-- Кнопка регистрации --}}
            @if(!empty($event->registration_url))
                <div class="pt-2">
                    <a href="{{ $event->registration_url }}" class="msa-btn-primary">
                        Зарегистрироваться
                    </a>
                </div>
            @endif
        </article>
    </div>
@endsection