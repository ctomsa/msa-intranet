@csrf

<div class="space-y-4">
    <div>
        <label class="msa-label">Переговорка</label>
        <select name="meeting_room_id" class="msa-input">
            @foreach($rooms as $r)
                <option value="{{ $r->id }}"
                    @selected(old('meeting_room_id', $booking->meeting_room_id ?? $prefill_room_id ?? null) == $r->id)>
                    {{ $r->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="msa-label">Дата</label>
            <input type="date" name="date" class="msa-input"
                   value="{{ old('date', $booking->date ?? $prefill_date ?? '') }}">
        </div>

        <div>
            <label class="msa-label">Начало</label>
            <input type="time" name="start_time" class="msa-input"
                   step="900"
                   value="{{ old('start_time', $booking->start_time ?? $prefill_start ?? '') }}">
        </div>

        <div>
            <label class="msa-label">Конец</label>
            <input type="time" name="end_time" class="msa-input"
                   step="900"
                   value="{{ old('end_time', $booking->end_time ?? $prefill_end ?? '') }}">
        </div>
    </div>

    <div>
        <label class="msa-label">Автор бронирования (обязательно)</label>
        <input type="text" name="author_name" class="msa-input"
               value="{{ old('author_name', $booking->author_name ?? '') }}">
    </div>

    <div>
        <label class="msa-label">Комментарий</label>
        <textarea name="comment" class="msa-input" rows="3">{{ old('comment', $booking->comment ?? '') }}</textarea>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-100 rounded-lg p-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="flex gap-3">
        <button type="submit" class="msa-btn-primary">Сохранить</button>
        <a href="{{ url()->previous() }}" class="msa-link">Отмена</a>
    </div>
</div>
