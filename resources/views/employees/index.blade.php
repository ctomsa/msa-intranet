@extends('layouts.app')

@section('content')
<div class="msa-main">

    <h1 class="text-xl font-semibold mb-6">Сотрудники</h1>

    @forelse($employees as $groupName => $groupEmployees)

        {{-- Заголовок группы --}}
        <h2 class="mt-8 mb-3 text-lg font-semibold text-slate-900">
            {{ $groupName }}
        </h2>

        <div class="msa-card">
            <div class="grid gap-4 sm:gap-5 md:grid-cols-2 xl:grid-cols-3">

                @foreach($groupEmployees as $employee)
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
                            }
                        @endphp

                        {{-- Аватар --}}
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}"
                                 alt="{{ $employee->full_name }}"
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-slate-100
                                        flex items-center justify-center
                                        text-sm font-semibold text-slate-600">
                                {{ mb_substr($employee->full_name, 0, 1) }}
                            </div>
                        @endif

                        {{-- Текст --}}
                        <div class="flex-1 min-w-0">
@php
    $fioParts = preg_split('/\s+/', trim($employee->full_name));
    $lastName = $fioParts[0] ?? '';
    $firstInitial = isset($fioParts[1]) ? mb_substr($fioParts[1], 0, 1) . '.' : '';
    $middleInitial = isset($fioParts[2]) ? mb_substr($fioParts[2], 0, 1) . '.' : '';
@endphp

<div class="text-sm font-semibold text-slate-900 truncate">
    {{ $lastName }} {{ $firstInitial }}{{ $middleInitial }}
</div>
                            @if(!empty($employee->position))
                                <div class="text-xs text-slate-500 truncate">
                                    {{ $employee->position }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach

            </div>
        </div>

    @empty
        <div class="msa-card p-6 text-slate-500">
            Сотрудники не найдены
        </div>
    @endforelse

</div>
@endsection
