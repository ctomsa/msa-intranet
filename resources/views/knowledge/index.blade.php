@extends('layouts.app')

@section('content')
    <div class="space-y-8 lg:space-y-10">
        {{-- HERO --}}
        <section class="msa-card msa-card-hero">
            <div class="flex flex-col gap-4 lg:gap-6">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight text-slate-900">
                        База знаний
                    </h1>
                    <p class="mt-2 text-sm lg:text-base text-slate-500 max-w-2xl">
                        Статьи, инструкции и материалы по ключевым направлениям работы MSA.
                    </p>
                </div>
            </div>
        </section>

        {{-- Фильтр по категориям --}}
        <section class="msa-card">
            <div class="flex flex-wrap items-center gap-2 lg:gap-3">
                {{-- "Все материалы" --}}
                <a href="{{ route('knowledge.index') }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                          border
                          {{ empty($currentCategory)
                                ? 'bg-slate-900 text-white border-slate-900'
                                : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-white hover:border-slate-300' }}">
                    Все материалы
                </a>

                @foreach($knowledgeCategories as $category)
                    <a href="{{ route('knowledge.index', ['category' => $category->code]) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                              border
                              {{ ($currentCategory === $category->code)
                                    ? 'bg-slate-900 text-white border-slate-900'
                                    : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-white hover:border-slate-300' }}">
                        {{ $category->label }}
                        <span class="ml-1 text-[10px] text-slate-400">
                            {{ $category->items_count ?? 0 }}
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Список материалов --}}
        <section class="msa-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900 tracking-tight">
                    @if($currentCategory)
                        {{ optional($knowledgeCategories->firstWhere('code', $currentCategory))->label ?? 'Материалы' }}
                    @else
                        Все материалы
                    @endif
                </h2>

                <span class="text-xs text-slate-400">
                    {{ $items->total() }} записей
                </span>
            </div>

            <div class="space-y-4">
                @forelse($items as $item)
                    <a href="{{ route('knowledge.show', $item) }}" class="block group">
                        <article
                            class="msa-card border border-slate-200 bg-white/80 p-4 sm:p-5
                                   transition-all duration-200 group-hover:-translate-y-0.5 group-hover:border-slate-300 group-hover:bg-white group-hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] cursor-pointer">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h3 class="text-sm sm:text-[15px] font-semibold text-slate-900 leading-snug line-clamp-2">
                                    {{ $item->title }}
                                </h3>

                                @if(!empty($item->category))
                                    <span class="msa-badge-neutral text-[10px]">
                                        {{ optional($knowledgeCategories->firstWhere('code', $item->category))->label ?? $item->category }}
                                    </span>
                                @endif
                            </div>

                            @if(!empty($item->excerpt ?? $item->content))
                                <p class="text-xs text-slate-500 mb-3 line-clamp-3">
                                    {{ Str::limit($item->excerpt ?? strip_tags($item->content), 220) }}
                                </p>
                            @endif

                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">
                                @if(!empty($item->updated_at))
                                    <div class="inline-flex items-center gap-1">
                                        <span>📅</span>
                                        <span>
                                            {{ $item->updated_at instanceof \Carbon\Carbon
                                                ? $item->updated_at->format('d.m.Y')
                                                : \Carbon\Carbon::parse($item->updated_at)->format('d.m.Y') }}
                                        </span>
                                    </div>
                                @endif

                                @if(!empty($item->author_name))
                                    <div class="inline-flex items-center gap-1">
                                        <span>👤</span>
                                        <span>{{ $item->author_name }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </a>
                @empty
                    <p class="text-sm text-slate-500">
                        Пока нет материалов в этой категории.
                    </p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $items->withQueryString()->links() }}
            </div>
        </section>
    </div>
@endsection