@csrf
@if($isEdit ?? false)
    @method('PUT')
@endif

<div class="space-y-4">
    {{-- ФИО --}}
    <div>
        <label class="msa-label">ФИО *</label>
        <input
            type="text"
            name="full_name"
            value="{{ old('full_name', $employee->full_name ?? '') }}"
            class="msa-input"
            required
        >
    </div>

    {{-- Должность --}}
    <div>
        <label class="msa-label">Должность</label>
        <input
            type="text"
            name="position"
            value="{{ old('position', $employee->position ?? '') }}"
            class="msa-input"
        >
    </div>

    {{-- Email + Телефон --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="msa-label">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $employee->email ?? '') }}"
                class="msa-input"
            >
        </div>

        <div>
            <label class="msa-label">Телефон</label>
            <input
                type="text"
                name="phone_mobile"
                value="{{ old('phone_mobile', $employee->phone_mobile ?? '') }}"
                class="msa-input"
            >
        </div>
    </div>

    {{-- Отдел --}}
    <div>
        <label class="msa-label">Отдел</label>
        <input
            type="text"
            name="department"
            value="{{ old('department', $employee->department ?? '') }}"
            class="msa-input"
        >
    </div>

    {{-- Краткое описание / зона ответственности (если хочешь оставить) --}}
    <div>
        <label class="msa-label">Краткое описание / зона ответственности</label>
        <textarea
            name="responsibilities"
            rows="3"
            class="msa-textarea"
        >{{ old('responsibilities', $employee->responsibilities ?? '') }}</textarea>
    </div>

    {{-- Аватар --}}
    <div>
        <label class="msa-label">Аватар (фото сотрудника)</label>
        <input
            type="file"
            name="avatar"
            class="msa-input"
            accept="image/*"
        >

        @if(!empty($employee->avatar_path ?? null))
            <div class="mt-3 flex items-center gap-3">
                <div class="text-xs text-slate-500">Текущий аватар:</div>
                <img
                    src="{{ asset('storage/'.$employee->avatar_path) }}"
                    alt="{{ $employee->full_name ?? '' }}"
                    class="w-12 h-12 rounded-full object-cover"
                    style="width: 64px; height: 64px;"
                >
            </div>
        @endif
    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('admin.employees.index') }}" class="msa-button msa-button--secondary">
        Отмена
    </a>

    <button type="submit" class="msa-button msa-button--primary">
        {{ ($isEdit ?? false) ? 'Сохранить изменения' : 'Сохранить' }}
    </button>
</div>