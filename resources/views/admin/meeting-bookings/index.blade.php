@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6 space-y-4">
    <h1 class="text-2xl font-semibold">Встречи (админ)</h1>

    <a class="msa-link text-sm" href="{{ route('admin.meeting-bookings.create') }}">+ Добавить встречу</a>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left p-3">Дата</th>
                    <th class="text-left p-3">Время</th>
                    <th class="text-left p-3">Переговорка</th>
                    <th class="text-left p-3">Автор</th>
                    <th class="text-right p-3">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                    <tr class="border-t">
                        <td class="p-3">{{ \Carbon\Carbon::parse($b->date)->format('d.m.Y') }}</td>
                        <td class="p-3">{{ $b->start_time }}–{{ $b->end_time }}</td>
                        <td class="p-3">{{ $b->room?->name }}</td>
                        <td class="p-3">{{ $b->author_name }}</td>
                        <td class="p-3 text-right">
                            <a class="msa-link" href="{{ route('admin.meeting-bookings.edit', $b) }}">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $bookings->links() }}</div>
</div>
@endsection
