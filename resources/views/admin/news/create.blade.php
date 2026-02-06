<x-app-layout>
    <x-slot name="header">Добавить новость</x-slot>
<div style="padding:8px;margin:10px 0;border:2px dashed red;">
    DEBUG: create.blade.php UPDATED {{ now() }}
</div>

<form method="POST"
      action="{{ route('admin.news.store') }}"
      enctype="multipart/form-data">
    @csrf

        <label>Название</label>
        <input type="text" name="title" class="w-full border mb-4">

        <label>Текст</label>
        <textarea name="body" rows="6" class="w-full border mb-4"></textarea>

        <label>Дата публикации</label>
        <input type="datetime-local" name="published_at" class="w-full border mb-4">

            <label class="inline-flex items-center">
        <input type="checkbox" name="is_pinned" value="1" class="mr-2">
        Важная новость
    </label>

<div class="form-group" style="margin-top:12px;">
    <label>Файл</label>
    <input type="file" name="attachment" class="form-control">
</div>

    <div class="mt-6">
        <button
            type="submit"
            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
        >
            Сохранить
        </button>
    </div>
</form>
</x-app-layout>
