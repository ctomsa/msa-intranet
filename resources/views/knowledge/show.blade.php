@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8">
        {{-- Хлебные крошки --}}
        <nav class="text-xs text-slate-400 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-slate-600">Главная</a>
            <span>/</span>
            <a href="{{ route('knowledge.index') }}" class="hover:text-slate-600">База знаний</a>
            <span>/</span>
            <span class="text-slate-500 line-clamp-1">{{ $item->title }}</span>
        </nav>

        <article class="msa-card">
            {{-- Категория + дата + автор --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div class="flex flex-wrap items-center gap-2">
                    @if(!empty($item->category))
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold
                                     bg-slate-100 text-slate-700 border border-slate-200">
                            {{ match($item->category) {
                                'ved'            => 'ВЭД',
                                'fundraising'    => 'Привлечение финансирования',
                                'legal'          => 'Юридические услуги',
                                'growth'         => 'Развитие',
                                'private_office' => 'Private office',
                                default          => strtoupper($item->category),
                            } }}
                        </span>
                    @endif

                    @php
                        $date = $item->updated_at ?? $item->created_at ?? null;
                    @endphp

                    @if($date)
                        <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                            <span>📅</span>
                            <span>
                                {{ $date instanceof \Carbon\Carbon
                                    ? $date->format('d.m.Y H:i')
                                    : \Carbon\Carbon::parse($date)->format('d.m.Y H:i') }}
                            </span>
                        </span>
                    @endif
                </div>

                @if(!empty($item->author_name) || !empty($item->author_position))
                    <div class="text-right text-[11px] text-slate-400">
                        @if(!empty($item->author_name))
                            <div>Автор: {{ $item->author_name }}</div>
                        @endif
                        @if(!empty($item->author_position))
                            <div>{{ $item->author_position }}</div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Заголовок --}}
            <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900 mb-3">
                {{ $item->title }}
            </h1>

            {{-- Краткое описание / выжимка --}}
            @if(!empty($item->excerpt))
                <p class="text-sm lg:text-base text-slate-500 mb-6">
                    {{ $item->excerpt }}
                </p>
            @endif

            {{-- Основное содержимое --}}
            <div class="prose prose-sm lg:prose-base max-w-none prose-slate">
                @php
                    $content = $item->content ?? '';
                @endphp

                @if(\Illuminate\Support\Str::startsWith(trim($content), '<'))
                    {{-- Похоже на HTML — выводим как есть --}}
                    {!! $content !!}
                @else
                    {{-- Простой текст — сохраняем переводы строк --}}
                    {!! nl2br(e($content)) !!}
                @endif
            </div>

            {{-- Прикреплённый файл / картинка --}}
            @if(!empty($item->attachment_path))
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ asset('storage/'.$item->attachment_path) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900 msa-link">
                        📎 Открыть вложение
                    </a>
                </div>
            @endif
        </article>

        <div>
            <a href="{{ url()->previous() === url()->current()
                        ? route('knowledge.index')
                        : url()->previous() }}"
               class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700">
                ← Назад
            </a>
        </div>
    </div>
@endsection