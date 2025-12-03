<x-app-layout>
    <x-slot name="header">Редактировать новость</x-slot>

    <form method="POST" action="{{ route('admin.news.update', $news) }}">
        @csrf
        @method('PUT')

        <label>Название</label>
        <input type="text" name="title" value="{{ $news->title }}" class="w-full border mb-4">

        <label>Текст</label>
        <textarea name="body" rows="6" class="w-full border mb-4">{{ $news->body }}</textarea>

        <label>Дата публикации</label>
        <input type="datetime-local" name="published_at"
               value="{{ $news->published_at?->format('Y-m-d\TH:i') }}"
               class="w-full border mb-4">

        <label>
            <input type="checkbox" name="is_pinned" value="1" @checked($news->is_pinned)>
            Важная новость
        </label>

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white">Обновить</button>
    </form>
</x-app-layout>