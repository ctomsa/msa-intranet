@extends('layouts.app')

@section('content')
    <div class="space-y-6 lg:space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900">
                Результаты поиска
            </h1>
            <p class="text-sm text-slate-500">
                Запрос: <span class="font-medium">"{{ $q }}"</span>
            </p>
        </div>

        {{-- Новости --}}
        <div class="msa-card">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Новости</h2>
            @forelse($news as $item)
                <a href="{{ route('news.show', $item) }}"
                   class="block border-b border-slate-100 last:border-0 py-3 hover:bg-slate-50/60">
                    <div class="text-sm font-semibold text-slate-900">
                        {{ $item->title }}
                    </div>
                    @if(!empty($item->excerpt ?? $item->content))
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ Str::limit($item->excerpt ?? strip_tags($item->content), 140) }}
                        </div>
                    @endif
                </a>
            @empty
                <p class="text-sm text-slate-500">Ничего не найдено.</p>
            @endforelse
        </div>

        {{-- База знаний --}}
        <div class="msa-card">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">База знаний</h2>
            @forelse($knowledge as $item)
                <a href="{{ route('knowledge.show', $item) }}"
                   class="block border-b border-slate-100 last:border-0 py-3 hover:bg-slate-50/60">
                    <div class="text-sm font-semibold text-slate-900">
                        {{ $item->title }}
                    </div>
                    @if(!empty($item->excerpt ?? $item->content))
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ Str::limit($item->excerpt ?? strip_tags($item->content), 140) }}
                        </div>
                    @endif
                </a>
            @empty
                <p class="text-sm text-slate-500">Ничего не найдено.</p>
            @endforelse
        </div>

        {{-- Мероприятия --}}
        <div class="msa-card">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Мероприятия</h2>
            @forelse($events as $event)
                <a href="{{ route('events.show', $event) }}"
                   class="block border-b border-slate-100 last:border-0 py-3 hover:bg-slate-50/60">
                    <div class="text-sm font-semibold text-slate-900">
                        {{ $event->title }}
                    </div>
                    @if(!empty($event->description))
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ Str::limit($event->description, 140) }}
                        </div>
                    @endif
                </a>
            @empty
                <p class="text-sm text-slate-500">Ничего не найдено.</p>
            @endforelse
        </div>

        {{-- Сотрудники --}}
        <div class="msa-card">
            <h2 class="text-lg font-semibold text-slate-900 mb-3">Сотрудники</h2>
            @forelse($employees as $employee)
                <a href="{{ route('employees.show', $employee) }}"
                   class="flex items-center gap-3 border-b border-slate-100 last:border-0 py-3 hover:bg-slate-50/60">

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
                             class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-semibold text-slate-500">
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
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-500">Ничего не найдено.</p>
            @endforelse
        </div>
    </div>
@endsection