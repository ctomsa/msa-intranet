@extends('layouts.app')
<div class="mr-fullbleed">
  <div class="mr-pagewrap">
    <!-- ВЕСЬ текущий контент show.blade.php оставь внутри -->
@section('content')
@php
    use Carbon\Carbon;

    $isAdmin = $isAdmin ?? (auth()->check() && (bool) (auth()->user()->is_admin ?? false));

    $today = Carbon::today();

    // 15 минут шаг сетки
    $step = 15;

    // Рабочее время комнаты
    $workStart = Carbon::createFromFormat('H:i:s', $room->work_start ?? '08:00:00');
    $workEnd   = Carbon::createFromFormat('H:i:s', $room->work_end ?? '20:00:00');

    $dayStart = $workStart->hour * 60 + $workStart->minute; // минуты
    $dayEnd   = $workEnd->hour * 60 + $workEnd->minute;     // минуты

    // Кол-во строк по времени (каждые 15 минут)
    $slotsCount = (int) ceil(($dayEnd - $dayStart) / $step); // 48 для 08:00-20:00
    $totalGridRows = 1 + $slotsCount; // +1 header row

    // Подготовим быстрый доступ: bookings уже пришли из контроллера
@endphp

<style>
.page-wrap { max-width: 1320px !important; width: 100% !important; margin: 0 auto; padding: 32px 18px; }
.card { width: 100% !important; }

.mr-fullbleed{
  width:100vw;
  margin-left:calc(50% - 50vw);
}

.mr-pagewrap{
  max-width:1320px;
  margin:0 auto;
  width:100%;
  padding: 0 18px; /* можно 24 */
}

/* если у тебя контейнер таблицы называется иначе — это ок, table всё равно растянется */
.mr-week-table,
.mr-schedule-table,
.week-table,
.schedule-table,

/* --- Force schedule area to stretch full width --- */
.mr-week-wrap,
.mr-schedule-wrap,
.week-wrap,
.schedule-wrap {
  display: flex;
  justify-content: stretch;
  align-items: stretch;
}

.mr-week-card,
.mr-schedule-card,
.week-card,
.schedule-card {
  flex: 1 1 auto;
  width: 100% !important;
  max-width: 1320px; /* как page-wrap */
}

.mr-week-table th, .mr-week-table td,
.mr-schedule-table th, .mr-schedule-table td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.mr-breadcrumb { font-size:14px; margin-bottom: 14px; display:flex; align-items:center; gap:10px; }
.mr-back { color:#6A5BFF; text-decoration:none; font-weight:600; }
.mr-back:hover { text-decoration: underline; }
.mr-sep { color:#9ca3af; }
    .mr-topbar { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-top: 18px; }
    .mr-btn {
        display:inline-flex; align-items:center; gap:8px;
        background:#6A5BFF; color:white; border-radius:999px;
        padding:12px 16px; font-weight:600; text-decoration:none;
        box-shadow: 0 10px 24px rgba(106,91,255,.22);
        border: 0;
    }
    .mr-btn:hover { filter: brightness(0.98); }

    .card {
        margin-top: 18px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 18px 50px rgba(16,24,40,.08);
        padding: 22px;
        border: 1px solid rgba(17,24,39,.06);
width: 100%; 
    }
    .card-h { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
    .card-title { font-size: 20px; font-weight: 800; color:#111827; margin:0; }
    .card-dates { color:#6b7280; font-size:14px; margin-top:4px; }


/* === Meeting room weekly schedule: keep it wide even when empty === */
.mr-week-card {
  width: 100%;
  max-width: 1320px;      /* под твой .page-wrap */
  margin: 0 auto;
}

.mr-week-table {
  width: 100%;
  table-layout: fixed;    /* ровные колонки */
}

/* чтобы длинные тексты не ломали ширину */
.mr-week-table th,
.mr-week-table td {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}


    /* GRID */
    .sched {
        margin-top: 14px;
        display: grid;
        grid-template-columns: 88px repeat(5, 1fr);
        grid-template-rows: 48px repeat(var(--slots), 26px);
        gap: 0;
        border: 1px solid rgba(17,24,39,.10);
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        background: #fff;
    }

    .sched-head {
        display:flex; align-items:center; justify-content:center;
        font-weight: 700; font-size: 14px; color:#111827;
        border-bottom: 1px solid rgba(17,24,39,.10);
        background: #fbfcff;
    }
    .sched-head small { display:block; font-weight:600; color:#6b7280; margin-top:2px; }

    .sched-time {
        padding-left: 12px;
        display:flex; align-items:center;
        font-size: 13px; color:#64748b;
        border-right: 1px solid rgba(17,24,39,.08);
        border-bottom: 1px solid rgba(17,24,39,.06);
        background: #fff;
    }

    .sched-cell {
        border-bottom: 1px solid rgba(17,24,39,.06);
        border-right: 1px solid rgba(17,24,39,.06);
        background: #fff;
    }

    .sched-col-today {
        background: rgba(106,91,255,.06);
    }
    .sched-head-today {
        background: rgba(106,91,255,.10);
        color:#3b33cc;
    }

    /* Booking blocks (overlay) */
    .booking {
        background:#6A5BFF;
        color:#fff;
        border-radius: 12px;
        padding: 10px 12px;
        margin: 3px 8px;
        box-shadow: 0 14px 34px rgba(106,91,255,.22);
        overflow: hidden;
        position: relative;
        z-index: 5;
        font-size: 13px;
    }
    .booking .t { font-weight: 800; font-size: 14px; }
    .booking .a { margin-top: 6px; opacity: .92; }
    .booking .d { margin-top: 3px; opacity: .92; }

    .booking-actions {
        position:absolute; right:10px; bottom:8px;
        display:flex; gap:10px; align-items:center;
        font-size: 12px;
    }
    .booking-actions a {
        color: rgba(255,255,255,.92);
        text-decoration: underline;
        font-weight: 600;
    }
    .booking-actions button {
        background: transparent;
        border: 0;
        color: rgba(255,255,255,.92);
        text-decoration: underline;
        font-weight: 700;
        cursor:pointer;
        padding:0;
    }
.mr-week-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  width:42px;
  height:42px;
  border-radius:12px;
  text-decoration:none;
  background:#fff;
  border:1px solid rgba(17,24,39,.08);
  box-shadow: 0 10px 24px rgba(16,24,40,.06);
  color:#111827;
  font-weight:700;
}
.mr-week-btn:hover{ filter: brightness(.99); }
.mr-header-card{
    margin-top: 14px;
    background:#fff;
    border-radius:18px;
    padding:18px 18px;
    border:1px solid rgba(17,24,39,.06);
    box-shadow: 0 18px 50px rgba(16,24,40,.06);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
}
.mr-header-left{ display:flex; flex-direction:column; gap:8px; }
.mr-header-title{ font-weight:800; color:#111827; font-size:18px; }
.mr-header-meta{ display:flex; gap:18px; color:#6b7280; font-size:14px; flex-wrap:wrap; }
.mr-meta-item{ display:flex; align-items:center; gap:8px; }




/* === FORCE wider content only on meeting-room page === */
.msa-main{
  max-width: none !important;          /* снимаем 80rem=1280px */
  width: 100% !important;
}

/* твой page-wrap должен управлять шириной */
.page-wrap{
  max-width: 1320px;
  margin: 0 auto;
  width: 100%;
  padding: 0 18px;
}

/* карточка расписания не должна сама себя сжимать */
/* Meeting rooms week grid */
.mr-days{
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 16px;
  width: 100%;
  align-items: start;
}

.mr-day-card{
  min-width: 0;
  background: #fff;
  border: 1px solid #e6e8f0;
  border-radius: 14px;
  overflow: hidden;
}

.mr-day-header{
  padding: 12px 14px;
  border-bottom: 1px solid #eef0f6;
  font-weight: 700;
}

.mr-day-body{
  padding: 12px 14px;
}

/* адаптив: на узких экранах можно сжимать */
@media (max-width: 1024px){
  .mr-days{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 640px){
  .mr-days{ grid-template-columns: 1fr; }
}
.mr-day-title{
  font-weight:700;
  font-size:14px;
  color:#111827;
}
.mr-day-body{ padding:12px; display:flex; flex-direction:column; gap:10px; }
.mr-day-empty{ color:#6b7280; font-size:13px; padding:10px 0; }
.mr-meeting {
  border: 1px solid #e5e7eb;
  background: #fff;
  border-radius: 14px;
  padding: 12px 14px;
}

.mr-meeting-time {
  font-weight: 600;
  margin-bottom: 6px;
}

.mr-meeting-title {
  font-weight: 500;
  margin-bottom: 6px;
}

.mr-meeting-author,
.mr-meeting-comment {
  display: block;
  font-size: 13px;
  line-height: 1.25;
  color: #6b7280;
}

.mr-meeting-actions {
  margin-top: 6px;
}
</style>

<div class="page-wrap">
<div class="mr-breadcrumb">
    <a href="{{ route('meeting-rooms.index') }}" class="mr-back">← Переговорки</a>
    <span class="mr-sep">/</span>
    <span>{{ $room->name }}</span>
</div>
    <div class="mr-topbar">
        <div>
            <h1 class="mr-title">{{ $room->name }}</h1>
            <div class="mr-sub">Рабочее время: {{ $room->work_start }} – {{ $room->work_end }}</div>
        </div>

        @if($isAdmin)
            <a class="mr-btn" href="{{ route('admin.meeting-bookings.create', ['room_id' => $room->id]) }}">+ Добавить встречу</a>
        @endif
    </div>

    <div class="card">
        <div class="card-h">
<div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
  <div>
    <div class="mr-card-title">Расписание на неделю</div>
    <div class="mr-card-sub">
      {{ $weekStart->format('d.m') }} — {{ $weekStart->copy()->addDays(4)->format('d.m') }}
    </div>
  </div>

  <div style="display:flex; gap:10px;">
    <a class="mr-week-btn" href="{{ route('meeting-rooms.show', $room) }}?week={{ $prevWeek->toDateString() }}">←</a>
    <a class="mr-week-btn" href="{{ route('meeting-rooms.show', $room) }}?week={{ $nextWeek->toDateString() }}">→</a>
  </div>
</div>
        </div>

<div class="mr-days">
    @php
        $ruDays2 = [
            'Mon' => 'пн',
            'Tue' => 'вт',
            'Wed' => 'ср',
            'Thu' => 'чт',
            'Fri' => 'пт',
        ];
    @endphp

    @foreach($days as $day)
        @php
            $dayKey = $day->toDateString();
            $dayBookings = ($bookings[$dayKey] ?? collect());
        @endphp

        <div class="mr-day-card">
            <div class="mr-day-header">
                <div class="mr-day-title">
                    {{ $ruDays2[$day->format('D')] ?? mb_strtolower($day->format('D')) }}, {{ $day->format('d.m') }}
                </div>
            </div>

            <div class="mr-day-body">
                @if($dayBookings->isEmpty())
                    <div class="mr-day-empty">Встреч не назначено</div>
                @else
                    @foreach($dayBookings as $b)
<div class="mr-meeting">
    <div class="mr-meeting-time">
        {{ substr($b->start_time,0,5) }} – {{ substr($b->end_time,0,5) }}
    </div>

    <div class="mr-meeting-title">
        {{ $b->title ?? 'Встреча' }}
    </div>

    @if(!empty($b->author_name))
        <div class="mr-meeting-author">👤 {{ $b->author_name }}</div>
    @endif

    @if(!empty($b->comment))
        <div class="mr-meeting-comment">{{ $b->comment }}</div>
    @endif

    @if(!empty($isAdmin) && $isAdmin)
        <div class="mr-meeting-actions">
            <a href="{{ url('/admin/meeting-bookings/'.$b->id.'/edit') }}">✏️</a>
        </div>
    @endif
</div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>
</div> {{-- end .page-wrap --}}
  </div>
</div>
@endsection
