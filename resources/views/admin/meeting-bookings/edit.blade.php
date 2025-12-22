@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-6">
    <h1 class="text-2xl font-semibold mb-4">Редактировать встречу</h1>

    <form method="POST" action="{{ route('admin.meeting-bookings.update', $booking) }}">
        @method('PUT')
        @include('admin.meeting-bookings._form', ['booking' => $booking])
    </form>

    <form method="POST" action="{{ route('admin.meeting-bookings.destroy', $booking) }}"
          class="mt-6"
          onsubmit="return confirm('Удалить встречу?')">
        @csrf
        @method('DELETE')
        <button class="text-sm text-red-600 hover:underline">Удалить встречу</button>
    </form>
</div>
@endsection
