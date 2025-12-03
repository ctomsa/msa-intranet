@extends('layouts.app')

@section('content')
    <div class="msa-page-section">
        <div class="msa-card max-w-3xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900">
                        Новое мероприятие
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Заполните форму, чтобы добавить мероприятие в календарь компании.
                    </p>
                </div>

                <a href="{{ route('admin.events.index') }}" class="msa-link text-sm">
                    ← К списку мероприятий
                </a>
            </div>

            {{-- ВАЖНО: method="POST", правильный action и @csrf --}}
            <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="msa-label">Название</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="msa-input">
                    @error('title')
                        <p class="msa-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="msa-label">Описание</label>
                    <textarea name="description"
                              rows="4"
                              class="msa-textarea">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="msa-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="msa-label">Тип</label>
                    <input type="text"
                           name="type"
                           value="{{ old('type') }}"
                           class="msa-input">
                    @error('type')
                        <p class="msa-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="msa-label">Локация</label>
                    <input type="text"
                           name="location"
                           value="{{ old('location') }}"
                           class="msa-input">
                    @error('location')
                        <p class="msa-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="msa-label">Дата и время начала</label>
                    <input type="datetime-local"
                           name="start_at"
                           value="{{ old('start_at') }}"
                           class="msa-input">
                    @error('start_at')
                        <p class="msa-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.events.index') }}" class="msa-btn-secondary">
                        Отмена
                    </a>

                    {{-- ВАЖНО: type="submit" --}}
                    <button type="submit" class="msa-btn-primary">
                        Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection