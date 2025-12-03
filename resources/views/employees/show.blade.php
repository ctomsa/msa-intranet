@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8">
        {{-- Хлебные крошки --}}
        <nav class="text-xs text-slate-400 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-slate-600">Главная</a>
            <span>/</span>
            <a href="{{ route('employees.index') }}" class="hover:text-slate-600">Сотрудники</a>
            <span>/</span>
            <span class="text-slate-500 line-clamp-1">{{ $employee->full_name }}</span>
        </nav>

        <article class="msa-card">
            <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-start">
                {{-- Аватар --}}
                @php
                    $avatarUrl = null;
                    if (!empty($employee->avatar_path)) {
                        $avatarUrl = asset('storage/'.$employee->avatar_path);
                    } elseif (!empty($employee->photo_url ?? null)) {
                        $avatarUrl = $employee->photo_url;
                    }
                @endphp

                <div class="shrink-0">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}"
                             alt="{{ $employee->full_name }}"
                             class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover">
                    @else
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-slate-100 flex items-center justify-center text-2xl font-semibold text-slate-500">
                            {{ mb_substr($employee->full_name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-3">
                    {{-- Имя + должность --}}
                    <div>
                        <h1 class="text-xl lg:text-2xl font-semibold tracking-tight text-slate-900">
                            {{ $employee->full_name }}
                        </h1>

                        @if(!empty($employee->position))
                            <p class="text-sm text-slate-600 mt-1">
                                {{ $employee->position }}
                            </p>
                        @endif

                        @if(!empty($employee->department))
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $employee->department }}
                            </p>
                        @endif
                    </div>

                    {{-- Контакты --}}
                    <div class="grid sm:grid-cols-2 gap-3 text-sm">
                        @if(!empty($employee->email))
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400">📧</span>
                                <a href="mailto:{{ $employee->email }}" class="msa-link break-all">
                                    {{ $employee->email }}
                                </a>
                            </div>
                        @endif

                        @if(!empty($employee->phone_internal))
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400">☎️</span>
                                <span>Внутренний: {{ $employee->phone_internal }}</span>
                            </div>
                        @endif

                        @if(!empty($employee->phone_mobile))
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400">📱</span>
                                <span>{{ $employee->phone_mobile }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Обязанности / описание --}}
                    @if(!empty($employee->responsibilities))
                        <div class="pt-3 border-t border-slate-100">
                            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
                                Зона ответственности
                            </h2>
                            <div class="text-sm text-slate-600">
                                {!! nl2br(e($employee->responsibilities)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </article>

        <div>
            <a href="{{ url()->previous() === url()->current()
                        ? route('employees.index')
                        : url()->previous() }}"
               class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700">
                ← Назад
            </a>
        </div>
    </div>
@endsection