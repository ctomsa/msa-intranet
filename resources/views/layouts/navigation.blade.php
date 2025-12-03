<nav class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/80 backdrop-blur-md">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex h-14 items-center justify-between gap-6">
            {{-- Логотип --}}
            <div class="flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-full gradient-violet text-[11px] font-semibold text-white shadow-sm">
                    MSA
                </div>
                <span class="text-sm font-medium text-slate-800">
                    Intranet
                </span>
            </div>

            {{-- Главное меню --}}
            <div class="hidden md:flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}"
                   class="px-3 py-1.5 rounded-full transition
                          {{ request()->routeIs('home') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Главная
                </a>

                <a href="{{ route('news.index') }}"
                   class="px-3 py-1.5 rounded-full transition
                          {{ request()->routeIs('news.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Новости
                </a>

                <a href="{{ route('knowledge.index') }}"
                   class="px-3 py-1.5 rounded-full transition
                          {{ request()->routeIs('knowledge.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    База знаний
                </a>

                <a href="{{ route('employees.index') }}"
                   class="px-3 py-1.5 rounded-full transition
                          {{ request()->routeIs('employees.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Сотрудники
                </a>

                <a href="{{ route('events.index') }}"
                   class="px-3 py-1.5 rounded-full transition
                          {{ request()->routeIs('events.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Мероприятия
                </a>
            </div>

            {{-- Поиск + профиль --}}
            <div class="flex flex-1 items-center justify-end gap-4">
                <div class="hidden md:flex items-center w-64">
                    <div class="relative w-full">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400 text-xs">
                            🔍
                        </span>
                        <input
                            type="text"
                            placeholder="Поиск по порталу..."
                            class="w-full rounded-full border border-slate-200 bg-white/80 px-8 py-1.5 text-xs text-slate-700 placeholder:text-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-[rgba(106,91,255,0.35)] focus:border-transparent"
                        >
                    </div>
                </div>

                @auth
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-900 text-[11px] font-semibold text-white">
                            {{ strtoupper(mb_substr(Auth::user()->name ?? 'N', 0, 1)) }}
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-xs font-medium text-slate-800">
                                {{ Auth::user()->name ?? 'Профиль' }}
                            </span>
                            <span class="text-[10px] text-emerald-500">
                                в сети
                            </span>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>