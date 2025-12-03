@extends('layouts.app')

@section('content')
    @php
        $date = $news->published_at ?? $news->created_at ?? null;

        $rawAuthor = $news->author ?? null;
        if (is_array($rawAuthor)) {
            $authorName = $rawAuthor['name'] ?? null;
        } elseif (is_object($rawAuthor)) {
            $authorName = $rawAuthor->name ?? null;
        } else {
            $authorName = $rawAuthor;
        }

        $department = $news->department ?? null;
    @endphp

    <div class="space-y-6">
        {{-- Back --}}
        <div>
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-900 transition">
                ← К списку новостей
            </a>
        </div>

        {{-- Карточка новости --}}
        <article class="msa-card rounded-3xl p-6 sm:p-8 space-y-4">
            {{-- Бейджи --}}
            <div class="flex flex-wrap gap-2 text-[11px]">
                @if(!empty($news->label))
                    <span class="msa-badge msa-badge-primary">
                        {{ $news->label }}
                    </span>
                @endif

                @if(!empty($news->audience))
                    <span class="msa-badge msa-badge-muted">
                        {{ $news->audience }}
                    </span>
                @endif
            </div>

            {{-- Заголовок --}}
            <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                {{ $news->title ?? 'Без названия' }}
            </h1>

            {{-- Метаданные --}}
            <div class="flex flex-wrap items-center gap-4 text-[13px] text-slate-500">
                @if($date)
                    <div class="inline-flex items-center gap-1">
                        <span>📅</span>
                        <span>
                            {{ $date instanceof \Carbon\Carbon ? $date->format('d.m.Y') : \Carbon\Carbon::parse($date)->format('d.m.Y') }}
                        </span>
                    </div>
                @endif

                @if(!empty($authorName))
                    <div class="inline-flex items-center gap-1">
                        <span>👤</span>
                        <span>{{ $authorName }}</span>
                    </div>
                @endif

                @if(!empty($department))
                    <div class="inline-flex items-center gap-1">
                        <span>🏷</span>
                        <span>{{ $department }}</span>
                    </div>
                @endif
            </div>

            <hr class="border-slate-100 my-2">

            {{-- Текст новости --}}
            <div class="prose prose-sm sm:prose-base max-w-none text-slate-700">
                @php
                    $content = $news->content ?? $news->body ?? null;
                @endphp

                @if($content)
                    {!! nl2br(e($content)) !!}
                @else
                    <p>Текст новости ещё не добавлен.</p>
                @endif
            </div>
        </article>
    </div>
@endsection