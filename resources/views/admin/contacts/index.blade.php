@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Контакты</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Ключевые контактные лица (HR, IT, офис-менеджеры и др.).
                </p>
            </div>
        </div>

        @if($contacts->count())
            <div class="msa-card p-0 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            ФИО
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Роль
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Телефон
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($contacts as $contact)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3 align-top">
                                <div class="font-medium text-slate-900">
                                    {{ $contact->full_name ?? 'Без имени' }}
                                </div>
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $contact->position ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $contact->email ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $contact->phone ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="msa-card">
                <p class="text-sm text-slate-500">
                    Контактов пока нет. Добавь сотрудников в разделе «Сотрудники», а потом выберем, кого считать ключевыми контактами.
                </p>
            </div>
        @endif
    </div>
@endsection