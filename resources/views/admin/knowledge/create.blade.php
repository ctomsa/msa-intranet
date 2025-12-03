@extends('layouts.app')

@section('content')
<div class="msa-page-section">
    <div class="msa-page-header">
        <div>
            <h1 class="msa-page-title">Новый материал базы знаний</h1>
            <p class="msa-page-subtitle">
                Создайте статью с полезной информацией для команды.
            </p>
        </div>
        <a href="{{ route('admin.knowledge.index') }}" class="msa-link-back">← Назад к списку</a>
    </div>

    <div class="msa-card p-6 max-w-3xl">
        <form action="{{ route('admin.knowledge.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.knowledge._form', ['knowledge' => null, 'categories' => $categories])
        </form>
    </div>
</div>
@endsection