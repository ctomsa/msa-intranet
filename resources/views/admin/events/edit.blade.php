@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-8">
        <div class="msa-card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900">
                        Редактировать мероприятие
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Обновите информацию и сохраните изменения.
                    </p>
                </div>

                <a href="{{ route('admin.events.index') }}"
                   class="msa-link text-sm flex items-center gap-1">
                    ← К списку мероприятий
                </a>
            </div>

            <form action="{{ route('admin.events.update', $event) }}"
                  method="POST"
                  class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Заголовок --}}
                <div>
                    <label for="title" class="msa-label">Название</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="msa-input"
                        value="{{ old('title', $event->title) }}"
                        required
                    >
                </div>

                {{-- Описание --}}
                <div>
                    <label for="description" class="msa-label">Описание</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="msa-input"
                    >{{ old('description', $event->description) }}</textarea>
                </div>

                {{-- Тип мероприятия --}}
                <div>
                    <label for="type" class="msa-label">Тип</label>
                    <input
                        type="text"
                        id="type"
                        name="type"
                        class="msa-input"
                        value="{{ old('type', $event->type) }}"
                        placeholder="Например: Внутреннее, Обучение, Встреча"
                    >
                </div>

                {{-- Локация --}}
                <div>
                    <label for="location" class="msa-label">Локация</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        class="msa-input"
                        value="{{ old('location', $event->location) }}"
                        placeholder="Офис, онлайн-ссылка, переговорка..."
                    >
                </div>

                {{-- Дата и время начала --}}
                <div>
                    <label for="start_at" class="msa-label">Дата и время начала</label>
                    <input
                        type="datetime-local"
                        id="start_at"
                        name="start_at"
                        class="msa-input"
                        value="{{ old('start_at', optional($event->start_at)->format('Y-m-d\TH:i')) }}"
                    >
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.events.index') }}"
                       class="msa-button msa-button--secondary">
                        Отмена
                    </a>

                    <button type="submit" class="msa-button">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection