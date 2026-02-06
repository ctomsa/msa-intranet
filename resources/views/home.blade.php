@extends('layouts.app')

@section('content')
<div class="msa-home-stack">
    <div class="space-y-8 lg:space-y-10">
        {{-- HERO / баннер --}}
        <section class="msa-card msa-card-hero">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900">
            MSA Intranet
        </h1>
        <p class="mt-2 text-sm lg:text-base text-slate-500 max-w-2xl">
            Новости, база знаний, контакты и мероприятия компании.
        </p>
    </div>

    </div>
        </section>

        {{-- Основная сетка: Новости / База знаний / Мероприятия + Контакты --}}
        <div class="grid gap-6 lg:gap-8 lg:grid-cols-3">
            {{-- Левая колонка – Новости --}}
            <section class="lg:col-span-1">
                <div class="msa-card h-full flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                            Новости
                        </h2>

                        <a href="{{ route('news.index') }}"
                           class="msa-link text-xs flex items-center gap-1 group">
                            Все новости
                            <span class="inline-block text-slate-400 group-hover:text-slate-700">→</span>
                        </a>
                    </div>

                    <div class="space-y-4 flex-1">
                        @forelse($news ?? [] as $item)
                            <a href="{{ route('news.show', $item) }}" class="block group">
                                <article
                                    class="msa-card border border-slate-200/80 bg-white/80 p-4 sm:p-5
                                           transition-all duration-200 group-hover:-translate-y-0.5 group-hover:border-slate-300 group-hover:bg-white group-hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] cursor-pointer">
                                    @if(!empty($item->label))
                                        <div class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                   bg-rose-50 text-rose-600 border border-rose-200 mb-2">
                                            {{ $item->label }}
                                        </div>
                                    @endif

                                    <h3 class="text-sm sm:text-[15px] font-semibold text-slate-900 mb-1.5 leading-snug line-clamp-2">
                                        {{ $item->title }}
                                    </h3>

                                    @if(!empty($item->excerpt ?? $item->content))
                                        <p class="text-xs text-slate-500 mb-3 line-clamp-3">
                                            {{ Str::limit($item->excerpt ?? strip_tags($item->content), 160) }}
                                        </p>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">
                                        @php
                                            $date = $item->published_at ?? $item->created_at ?? null;
                                        @endphp

                                        @if($date)
                                            <div class="inline-flex items-center gap-1">
                                                <span class="text-[11px]">📅</span>
                                                <span>
                                                    {{ $date instanceof \Carbon\Carbon ? $date->format('d.m.Y') : \Carbon\Carbon::parse($date)->format('d.m.Y') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if(!empty($item->author?->name ?? $item->author))
                                            <div class="inline-flex items-center gap-1">
                                                <span class="text-[11px]">👤</span>
                                                <span>
                                                    {{ is_object($item->author) ? ($item->author->name ?? 'Автор') : $item->author }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">
                                Пока новостей нет.
                            </p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- Центральная колонка – База знаний --}}
            <section class="lg:col-span-1">
                <div class="msa-card h-full flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                            База знаний
                        </h2>

                        <a href="{{ route('knowledge.index') }}"
                           class="msa-link text-xs flex items-center gap-1 group">
                            Открыть
                            <span>→</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:gap-5">
                        @forelse(($knowledgeCategories ?? []) as $category)
                            <a href="{{ route('knowledge.index', ['category' => $category->code]) }}"
                               class="group rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-4 sm:py-5 flex flex-col justify-between
                                      transition-all duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)]">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center
                                               text-slate-600 text-xs font-semibold group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                        {{ strtoupper(mb_substr($category->label, 0, 1)) }}
                                    </div>

                                    <span class="text-[11px] text-slate-400">
                                        {{ $category->items_count ?? 0 }} материалов
                                    </span>
                                </div>

                                <div>
                                    <h3 class="text-sm font-semibold text-slate-900 mb-1 leading-snug">
                                        {{ $category->label }}
                                    </h3>
                                    @if(!empty($category->description))
                                        <p class="text-xs text-slate-500 line-clamp-2">
                                            {{ $category->description }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500 col-span-2">
                                Категории базы знаний уже созданы, но материалов пока нет.
                            </p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- Правая колонка – Мероприятия + Контакты --}}
            <section class="lg:col-span-1">
                <div class="flex flex-col gap-6">
                    {{-- Ближайшие мероприятия --}}
                    <div class="msa-card flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                                Ближайшие мероприятия
                            </h2>

                            <a href="{{ route('events.index') }}"
                               class="msa-link text-xs flex items-center gap-1 group">
                                Все
                                <span>→</span>
                            </a>
                        </div>

                        <div class="space-y-4 flex-1">
                            @forelse($events ?? [] as $event)
                                <a href="{{ route('events.show', $event) }}" class="block group">
                                    <article
                                        class="msa-card border border-slate-200 bg-white/80 p-4 sm:p-5
                                               transition-all duration-200 group-hover:-translate-y-0.5 group-hover:border-slate-300 group-hover:bg-white group-hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] cursor-pointer">
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
                                                    <span class="line-clamp-1 max-w-[150px]">
                                                        {{ $event->location }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </article>
                                </a>
                            @empty
                                <p class="text-sm text-slate-500">
                                    Ближайших мероприятий пока нет.
                                </p>
                            @endforelse
                        </div>
                    </div>


{{-- Дни Рождения --}}
@if(isset($birthdays))
    <section>
        <div class="msa-card h-full flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                    🎂 Дни рождения в этом месяце:
                </h2>
            </div>

            <div class="space-y-3">
@if($birthdays->count())
    @foreach($birthdays as $employee)
        <div class="msa-card border border-slate-200 bg-white/80 p-4">
            <div class="text-sm font-semibold text-slate-900">
                {{ \Carbon\Carbon::parse($employee->birthday)->locale('ru')->translatedFormat('d F') }}
            </div>
            <div class="text-sm text-slate-600">
                 {{ $employee->full_name }}
            </div>
        </div>
    @endforeach
@else
    <p class="text-sm text-slate-500">
        В этом месяце дней рождений нет 🎂
    </p>
@endif
            </div>
        </div>
    </section>
@endif
                    {{-- Контакты / ключевые сотрудники --}}
                    <div class="msa-card h-full flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                                Контакты
                            </h2>

                            <a href="{{ route('employees.index') }}"
                               class="msa-link text-xs flex items-center gap-1">
                                Все сотрудники
                                <span>→</span>
                            </a>
                        </div>

                        <div class="space-y-3">
@foreach($contacts as $employee)
                                <a href="{{ route('employees.show', $employee) }}"
                                   class="group msa-card border border-slate-200 bg-white/80
                                          p-4 sm:p-5 flex items-center gap-3
                                          transition-all duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)]">
                                    @php
                                        $avatarUrl = null;
                                        if (!empty($employee->avatar_path)) {
                                            $avatarUrl = asset('storage/'.$employee->avatar_path);
                                        } elseif (!empty($employee->photo_url)) {
                                            $avatarUrl = $employee->photo_url;
                                        }
                                    @endphp

                                    @if($avatarUrl)
                                        <img src="{{ $avatarUrl }}"
                                             alt="{{ $employee->full_name }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-sm font-semibold text-slate-500">
                                            {{ mb_substr($employee->full_name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-slate-900 truncate">
                                            {{ $employee->full_name }}
                                        </div>
                                        @if(!empty($employee->position))
                                            <div class="text-xs text-slate-500 truncate">
                                                {{ $employee->position }}
                                            </div>
                                        @endif
                                        @if(!empty($employee->email))
                                            <div class="text-xs text-slate-400 truncate">
                                                {{ $employee->email }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach

                            @if(($employees ?? collect())->isEmpty())
                                <p class="text-sm text-slate-500">
                                    Сотрудников пока нет.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
