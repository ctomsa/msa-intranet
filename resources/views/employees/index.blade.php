@extends('layouts.app')

@section('content')
    <div class="space-y-6 lg:space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900">
                Сотрудники
            </h1>
        </div>

        <div class="msa-card">
            <div class="grid gap-4 sm:gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse($employees as $employee)
                    <a href="{{ route('employees.show', $employee) }}"
                       class="group msa-card border border-slate-200 bg-white/80
                              p-4 sm:p-5 flex items-center gap-3
                              transition-all duration-200 hover:-translate-y-0.5
                              hover:border-slate-300 hover:bg-white
                              hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)]">

                        @php
                            $avatarUrl = null;
                            if (!empty($employee->avatar_path)) {
                                $avatarUrl = asset('storage/'.$employee->avatar_path);
                            } elseif (!empty($employee->photo_url ?? null)) {
                                $avatarUrl = $employee->photo_url;
                            }
                        @endphp

                        {{-- Аватар --}}
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}"
                                 alt="{{ $employee->full_name }}"
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-sm font-semibold text-slate-500">
                                {{ mb_substr($employee->full_name, 0, 1) }}
                            </div>
                        @endif

                        {{-- Текст --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-slate-900 truncate">
                                {{ $employee->full_name }}
                            </div>


@if(!empty($employee->birthday))
    <div style="margin-top: 4px; font-size: 14px;">
        🎂 {{ $employee->birthday->locale('ru')->translatedFormat('d F') }}
    </div>
@endif
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
                @empty
                    <p class="text-sm text-slate-500">
                        Сотрудников пока нет.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
