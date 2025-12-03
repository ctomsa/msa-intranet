@php
    /** @var \App\Models\KnowledgeItem|null $knowledge */
    $knowledge = $knowledge ?? null;
@endphp

<div class="space-y-4">
    <div>
        <label class="msa-label" for="title">Заголовок *</label>
        <input
            id="title"
            type="text"
            name="title"
            class="msa-input"
            value="{{ old('title', $knowledge->title ?? '') }}"
            required
        >
        @error('title')
            <p class="msa-input-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="msa-label" for="category">Категория *</label>
        <select
            id="category"
            name="category"
            class="msa-input"
            required
        >
            <option value="">Выберите категорию</option>
            @foreach($categories as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('category', $knowledge->category ?? '') === $value)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="msa-input-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="msa-label" for="excerpt">Краткое описание</label>
        <textarea
            id="excerpt"
            name="excerpt"
            class="msa-input"
            rows="3"
        >{{ old('excerpt', $knowledge->excerpt ?? '') }}</textarea>
        @error('excerpt')
            <p class="msa-input-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="msa-label" for="content">Содержимое *</label>
        <textarea
            id="content"
            name="content"
            class="msa-input"
            rows="8"
            required
        >{{ old('content', $knowledge->content ?? '') }}</textarea>
        @error('content')
            <p class="msa-input-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="msa-label" for="author_name">Автор (ФИО)</label>
            <input
                id="author_name"
                type="text"
                name="author_name"
                class="msa-input"
                value="{{ old('author_name', $knowledge->author_name ?? '') }}"
            >
            @error('author_name')
                <p class="msa-input-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="msa-label" for="author_position">Должность автора</label>
            <input
                id="author_position"
                type="text"
                name="author_position"
                class="msa-input"
                value="{{ old('author_position', $knowledge->author_position ?? '') }}"
            >
            @error('author_position')
                <p class="msa-input-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="msa-label" for="attachment">Файл-приложение</label>
        <input
            id="attachment"
            type="file"
            name="attachment"
            class="msa-input"
        >
        @error('attachment')
            <p class="msa-input-error">{{ $message }}</p>
        @enderror

        @if(!empty($knowledge?->attachment_url))
            <div class="mt-2 text-sm">
                Текущий файл:
                <a href="{{ $knowledge->attachment_url }}" target="_blank" class="msa-link">
                    Скачать
                </a>
            </div>
        @endif
    </div>

    <div class="pt-4 flex justify-end gap-3">
        <a href="{{ route('admin.knowledge.index') }}" class="msa-btn-secondary">
            Отмена
        </a>
        <button type="submit" class="msa-btn-primary">
            Сохранить
        </button>
    </div>
</div>