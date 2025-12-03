@extends('layouts.app')

@section('content')
<div class="msa-page-section">
    <div class="msa-page-header">
        <h1 class="msa-page-title">Новый сотрудник</h1>
        <p class="msa-page-subtitle">Карточка сотрудника для справочника и контактов.</p>
    </div>

    <div class="msa-card max-w-2xl mx-auto">
        <form method="POST"
              action="{{ route('admin.employees.store') }}"
              enctype="multipart/form-data">
            @include('admin.employees.form', ['isEdit' => false])
        </form>
    </div>
</div>
@endsection