@extends('layouts.app')

@section('content')
<div class="msa-page-section">
    <div class="msa-page-header">
        <h1 class="msa-page-title">Редактирование сотрудника</h1>
        <p class="msa-page-subtitle">Обновите данные сотрудника и сохраните изменения.</p>
        <a href="{{ route('admin.employees.index') }}" class="msa-link mt-2">← Назад к списку</a>
    </div>

    <div class="msa-card max-w-2xl mx-auto">
        <form method="POST"
              action="{{ route('admin.employees.update', $employee) }}"
              enctype="multipart/form-data">
            @include('admin.employees.form', ['isEdit' => true, 'employee' => $employee])
        </form>
    </div>
</div>
@endsection