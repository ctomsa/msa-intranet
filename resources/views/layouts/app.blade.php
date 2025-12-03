<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'MSA Intranet') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="msa-page">
    <div class="msa-layout-shell">
  <header class="msa-topbar">
    <div class="msa-topbar-inner">

        {{-- Лого + левое меню --}}
        <div class="msa-topbar-left">
            <a href="{{ route('home') }}" class="msa-logo flex items-center gap-3">
                <img src="/images/msa-logo.png"
                     alt="MSA Logo"
                     class="h-10 w-auto object-contain" />

                <span class="msa-logo-text">
                    <span class="msa-logo-title">MSA Intranet</span>
                    <span class="msa-logo-subtitle">Internal workspace</span>
                </span>
            </a>

            <nav class="msa-nav">
                @php
                    $navItems = [
                        ['label' => 'Главная',    'route' => 'home'],
                        ['label' => 'Сотрудники', 'route' => 'employees.index'],
                        ['label' => 'База знаний','route' => 'knowledge.index'],
                        ['label' => 'Новости',    'route' => 'news.index'],
                        ['label' => 'Мероприятия','route' => 'events.index'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $active = request()->routeIs($item['route']);
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="msa-nav-link {{ $active ? 'msa-nav-link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Правая часть — поиск + профиль/кнопка входа --}}
        <div class="msa-topbar-right">
    <form action="{{ route('search') }}" method="GET" class="msa-search">
        <svg class="msa-search-icon" viewBox="0 0 20 20" fill="none">
            <path d="M9.5 3.5a6 6 0 104.472 10.064l2.732 2.732a.75.75 0 101.06-1.06l-2.732-2.733A6 6 0 009.5 3.5z"
                  stroke="currentColor" stroke-width="1.6" />
        </svg>
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Поиск"
            class="msa-search-input"
        >
    </form>

            @auth
                {{-- Профиль пользователя --}}
                <div class="msa-user">
                    <div class="msa-user-meta">
                        <span class="msa-user-name">{{ auth()->user()->name }}</span>
                        <span class="msa-user-role">MSA Team</span>
                    </div>
                    <div class="msa-user-avatar">
                        <span>{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            @else
                {{-- Кнопка входа для гостей --}}
                <a href="{{ route('login') }}" class="msa-btn-primary px-4 py-2 text-sm">
                    Войти
                </a>
            @endauth
        </div>

    </div>
</header>

        {{-- Контент страниц --}}
        <main class="msa-main">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>