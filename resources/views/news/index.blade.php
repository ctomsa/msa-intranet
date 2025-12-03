@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Заголовок --}}
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Новости компании</h1>
            <p class="text-sm text-slate-500 mt-1">
                Актуальные обновления и объявления для сотрудников.
            </p>
        </div>

        {{-- Список новостей --}}
        @if(isset($news) && $news->count())
            <div class="space-y-3">
                @foreach($news as $item)
                    @php
                        $date = $item->published_at ?? $item->created_at ?? null;

                        $rawAuthor = $item->author ?? null;
                        if (is_array($rawAuthor)) {
                            $authorName = $rawAuthor['name'] ?? null;
                        } elseif (is_object($rawAuthor)) {
                            $authorName = $rawAuthor->name ?? null;
                        } else {
                            $authorName = $rawAuthor;
                        }

                        $department = $item->department ?? null;
                    @endphp

                    <a href="{{ route('news.show', $item) }}"
                       class="block msa-card msa-card-hover rounded-3xl p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                {{-- Бейджи --}}
                                <div class="flex flex-wrap gap-2 mb-2 text-[11px]">
                                    @if(!empty($item->label))
                                        <span class="msa-badge msa-badge-primary">
                                            {{ $item->label }}
                                        </span>
                                    @endif

                                    @if(!empty($item->audience))
                                        <span class="msa-badge msa-badge-muted">
                                            {{ $item->audience }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Заголовок --}}
                                <h2 class="text-base font-semibold text-slate-900">
                                    {{ $item->title ?? 'Без названия' }}
                                </h2>

                                {{-- Краткое описание / текст --}}
                                @if(!empty($item->excerpt))
                                    <p class="text-sm text-slate-600 mt-2">
                                        {{ $item->excerpt }}
                                    </p>
                                @elseif(!empty($item->content))
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-3">
                                        {{ strip_tags($item->content) }}
                                    </p>
                                @endif

                                {{-- Метаданные --}}
                                <div class="mt-3 flex flex-wrap items-center gap-4 text-[11px] text-slate-500">
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
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="msa-card rounded-3xl p-6 text-sm text-slate-500">
                Пока нет новостей.
            </div>
        @endif
    </div>
@endsection