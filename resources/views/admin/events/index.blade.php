@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Мероприятия</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Управление внутренними событиями и встречами.
                </p>
            </div>

            <a href="{{ route('admin.events.create') }}" class="msa-btn-primary">
                + Добавить мероприятие
            </a>
        </div>

        @if($events->count())
            <div class="msa-card p-0 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Название
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Дата и время
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Локация
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Тип
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($events as $event)
                        @php
                            $date = $event->start_at ?? null;
                            if ($date && ! $date instanceof \Carbon\Carbon) {
                                $date = \Carbon\Carbon::parse($date);
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3 align-top">
                                <div class="font-medium text-slate-900">
                                    {{ $event->title ?? 'Без названия' }}
                                </div>
                                @if(!empty($event->description))
                                    <div class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                        {{ \Illuminate\Support\Str::limit($event->description, 80) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                @if($date)
                                    {{ $date->format('d.m.Y H:i') }}
                                @else
                                    <span class="text-slate-400 text-xs">Не указано</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $event->location ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $event->type ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-right text-xs">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.events.edit', $event) }}"
                                       class="text-slate-500 hover:text-slate-900">
                                        Редактировать
                                    </a>

                                    <form action="{{ route('admin.events.destroy', $event) }}"
                                          method="POST"
                                          onsubmit="return confirm('Удалить мероприятие?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-rose-500 hover:text-rose-600">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $events->links() }}
                </div>
            </div>
        @else
            <div class="msa-card">
                <p class="text-sm text-slate-500">
                    Мероприятий пока нет. Нажми «Добавить мероприятие», чтобы создать первое.
                </p>
            </div>
        @endif
    </div>
@endsection