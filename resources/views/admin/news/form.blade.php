@extends('layouts.app')

@section('content')
    <div class="space-y-6 max-w-3xl">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">
                {{ $mode === 'edit' ? 'Редактирование новости' : 'Новая новость' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Заполни основные поля. Остальное всегда можно поменять позже.
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700 space-y-1">
                <div class="font-semibold">Проверь форму:</div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="msa-card">
            <form
                method="POST"
                action="{{ $mode === 'edit'
                    ? route('admin.news.update', $news)
                    : route('admin.news.store') }}"
                class="space-y-5"
enctype="multipart/form-data"
            >
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                {{-- Заголовок --}}
                <div class="space-y-1.5">
                    <label for="title" class="block text-sm font-medium text-slate-800">
                        Заголовок *
                    </label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        required
                        class="msa-input"
                        value="{{ old('title', $news->title) }}"
                    >
                </div>

                {{-- Метка / аудитория / отдел --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label for="label" class="block text-sm font-medium text-slate-800">
                            Метка (бейдж)
                        </label>
                        <input
                            id="label"
                            name="label"
                            type="text"
                            class="msa-input"
                            placeholder="Важно, Для всех, HR…"
                            value="{{ old('label', $news->label) }}"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label for="audience" class="block text-sm font-medium text-slate-800">
                            Аудитория
                        </label>
                        <input
                            id="audience"
                            name="audience"
                            type="text"
                            class="msa-input"
                            placeholder="Все сотрудники, Продажи…"
                            value="{{ old('audience', $news->audience) }}"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label for="department" class="block text-sm font-medium text-slate-800">
                            Отдел
                        </label>
                        <input
                            id="department"
                            name="department"
                            type="text"
                            class="msa-input"
                            placeholder="IT отдел, HR, Маркетинг…"
                            value="{{ old('department', $news->department) }}"
                        >
                    </div>
                </div>

                {{-- Краткое описание --}}
                <div class="space-y-1.5">
                    <label for="excerpt" class="block text-sm font-medium text-slate-800">
                        Краткое описание (анонс)
                    </label>
                    <textarea
                        id="excerpt"
                        name="excerpt"
                        rows="3"
                        class="msa-input resize-none"
                        placeholder="Короткий текст, который показывается в списке новостей."
                    >{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                {{-- Полный текст --}}
                <div class="space-y-1.5">
                    <label for="content" class="block text-sm font-medium text-slate-800">
                        Полный текст
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="8"
                        class="msa-input font-mono text-[13px]"
                        placeholder="Можно использовать обычный текст или HTML."
                    >{{ old('content', $news->content) }}</textarea>
                </div>

                {{-- Дата публикации --}}
                <div class="space-y-1.5 max-w-xs">
                    <label for="published_at" class="block text-sm font-medium text-slate-800">
                        Дата публикации
                    </label>
                    <input
                        id="published_at"
                        name="published_at"
                        type="datetime-local"
                        class="msa-input"
                        value="{{ old('published_at',
                            $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : null) }}"
                    >
                    <p class="text-xs text-slate-400">
                        Можно оставить пустым — тогда в списке будет использована дата создания.
                    </p>
                </div>
<div class="mt-3">
    <label class="block mb-1">Файл</label>
    <input type="file" name="attachment" class="w-full border mb-4">
</div>

@if(!empty($news) && !empty($news->attachment_path))
    <div class="text-sm" style="margin-top:-8px;margin-bottom:12px;">
        📎 <a href="{{ Storage::url($news->attachment_path) }}" target="_blank">
            {{ $news->attachment_name ?? 'Файл' }}
        </a>
    </div>
@endif
                {{-- Кнопки --}}
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-2">
                    <a href="{{ route('admin.news.index') }}"
                       class="text-sm text-slate-500 hover:text-slate-800 transition-colors">
                        ← Назад к списку
                    </a>

                    <div class="flex gap-3">
                        @if($mode === 'edit')
                            <a href="{{ route('news.show', $news) }}"
                               class="msa-btn-secondary">
                                Открыть на портале
                            </a>
                        @endif

                        <button type="submit" class="msa-btn-primary">
                            {{ $mode === 'edit' ? 'Сохранить' : 'Создать новость' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
