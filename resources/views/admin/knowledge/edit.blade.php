@extends('layouts.app')

@section('content')
<div class="msa-page-section">
    <div class="msa-page-header">
        <div>
            <h1 class="msa-page-title">Редактирование материала</h1>
            <p class="msa-page-subtitle">
                Обновите данные и сохраните изменения.
            </p>
        </div>
        <a href="{{ route('admin.knowledge.index') }}" class="msa-link-back">← Назад к списку</a>
    </div>

    <div class="msa-card p-6 max-w-3xl">
        <form action="{{ route('admin.knowledge.update', $knowledge) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.knowledge._form', ['knowledge' => $knowledge, 'categories' => $categories])
        </form>
    </div>
</div>
@endsection