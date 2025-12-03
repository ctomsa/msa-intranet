@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Заголовок + кнопка --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">
                    Новости — администрирование
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Управление новостями портала MSA Intranet.
                </p>
            </div>

            <a href="{{ route('admin.news.create') }}"
               class="msa-btn-primary">
                Добавить новость
            </a>
        </div>

        {{-- Флеш-сообщение --}}
        @if(session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-2 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Таблица новостей --}}
        <div class="msa-card p-0 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200/80">
                    <tr class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                        <th class="px-5 py-3 text-left">Заголовок</th>
                        <th class="px-5 py-3 text-left">Метка</th>
                        <th class="px-5 py-3 text-left">Аудитория</th>
                        <th class="px-5 py-3 text-left">Дата публикации</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3 align-top">
                                <div class="font-medium text-slate-900">
                                    {{ $item->title }}
                                </div>
                                @if($item->excerpt)
                                    <div class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                        {{ $item->excerpt }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 align-top text-xs text-slate-600">
                                {{ $item->label ?: '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-xs text-slate-600">
                                {{ $item->audience ?: '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-xs text-slate-500">
                                @php
    $date = $item->published_at ?? $item->created_at;
@endphp

@if ($date)
    {{ $date instanceof \Carbon\Carbon
        ? $date->format('d.m.Y')
        : \Carbon\Carbon::parse($date)->format('d.m.Y') }}
@else
    —
@endif
                            </td>
                            <td class="px-5 py-3 align-top">
                                <div class="flex justify-end gap-2 text-xs">
                                    <a href="{{ route('news.show', $item) }}"
                                       class="text-slate-500 hover:text-slate-900 transition-colors">
                                        Открыть
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item) }}"
                                       class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('Удалить новость?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-rose-500 hover:text-rose-700 transition-colors">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-6 text-sm text-slate-500 text-center">
                                Новостей пока нет.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Пагинация --}}
        @if($news instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div>
                {{ $news->links() }}
            </div>
        @endif
    </div>
@endsection