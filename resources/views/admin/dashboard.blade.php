@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">

    <h1 class="text-2xl font-semibold text-slate-900 mb-6">
        Административная панель
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Новости --}}
        <a href="{{ route('admin.news.index') }}"
           class="msa-card p-6 flex flex-col items-start justify-between hover:-translate-y-1 transition-transform">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 mb-2">Новости</h2>
                <p class="text-sm text-slate-500">Создание и редактирование новостей</p>
            </div>
        </a>

        {{-- Сотрудники --}}
        <a href="{{ route('admin.employees.index') }}"
           class="msa-card p-6 flex flex-col items-start justify-between hover:-translate-y-1 transition-transform">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 mb-2">Сотрудники</h2>
                <p class="text-sm text-slate-500">Управление профилями сотрудников</p>
            </div>
        </a>

        {{-- Мероприятия --}}
        <a href="{{ route('admin.events.index') }}"
           class="msa-card p-6 flex flex-col items-start justify-between hover:-translate-y-1 transition-transform">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 mb-2">Мероприятия</h2>
                <p class="text-sm text-slate-500">Создание и планирование событий</p>
            </div>
        </a>

        {{-- База знаний --}}
        <a href="{{ route('admin.knowledge.index') }}"
           class="msa-card p-6 flex flex-col items-start justify-between hover:-translate-y-1 transition-transform">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 mb-2">База знаний</h2>
                <p class="text-sm text-slate-500">Материалы и инструкции</p>
            </div>
        </a>

    </div>
</div>
@endsection