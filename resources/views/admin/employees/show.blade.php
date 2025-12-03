<x-app-layout>
    <x-slot name="header">{{ $employee->full_name }}</x-slot>

    @if ($employee->avatar_path)
        <img src="{{ asset('storage/'.$employee->avatar_path) }}" class="w-32 h-32 rounded-full mb-4">
    @endif

    <p><b>Должность:</b> {{ $employee->position }}</p>
    <p><b>Отдел:</b> {{ $employee->department }}</p>
    <p><b>Email:</b> {{ $employee->email }}</p>
    <p><b>Телефон (внутр.):</b> {{ $employee->phone_internal }}</p>
    <p><b>Телефон (моб.):</b> {{ $employee->phone_mobile }}</p>

    <hr class="my-4">

    <h3 class="font-bold">Обязанности:</h3>
    <p>{{ $employee->responsibilities }}</p>
</x-app-layout>