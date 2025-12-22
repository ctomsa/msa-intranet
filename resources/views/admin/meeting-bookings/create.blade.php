@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-6">
    <h1 class="text-2xl font-semibold mb-4">Добавить встречу</h1>

    <form method="POST" action="{{ route('admin.meeting-bookings.store') }}">
        @include('admin.meeting-bookings._form')
    </form>
</div>
@endsection
