@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Сотрудники</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Справочник сотрудников компании.
                </p>
            </div>

            <a href="{{ route('admin.employees.create') }}" class="msa-btn-primary">
                + Добавить сотрудника
            </a>
        </div>

        @if($employees->count())
            <div class="msa-card p-0 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            ФИО
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Должность
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Телефон
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Отдел
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($employees as $employee)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3 align-top">
                                <div class="font-medium text-slate-900">
                                    {{ $employee->full_name ?? 'Без имени' }}
                                </div>
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $employee->position ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $employee->email ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $employee->phone_mobile ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-sm text-slate-700">
                                {{ $employee->department ?? '—' }}
                            </td>
                            <td class="px-5 py-3 align-top text-right text-xs">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.employees.edit', $employee) }}"
                                       class="text-slate-500 hover:text-slate-900">
                                        Редактировать
                                    </a>

                                    <form action="{{ route('admin.employees.destroy', $employee) }}"
                                          method="POST"
                                          onsubmit="return confirm('Удалить сотрудника?')">
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
                    {{ $employees->links() }}
                </div>
            </div>
        @else
            <div class="msa-card">
                <p class="text-sm text-slate-500">
                    Сотрудников пока нет. Нажми «Добавить сотрудника», чтобы создать карточку.
                </p>
            </div>
        @endif
    </div>
@endsection