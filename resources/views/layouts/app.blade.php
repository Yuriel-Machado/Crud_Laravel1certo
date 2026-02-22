<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistema')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-green-100">
    <script id="flash-data" type="application/json">
        @json([
            'success' => session('success'),
            'error' => session('error'),
            'errors' => $errors->any() ? $errors->all() : []
])
    </script>

    <header class="sticky top-0 z-40 backdrop-blur bg-black/80 border-b border-green-800">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-green-600 text-black flex items-center justify-center font-bold">
                    CL
                </div>
                <div class="leading-tight">
                    <div class="font-semibold">CRUD</div>
                    <div class="text-xs text-green-400">Produtos & Anúncios</div>
                </div>
            </div>

            <nav class="hidden sm:flex items-center gap-2">
                <a href="{{ route('produtos.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('produtos.*') ? 'bg-black' : '' }}">
                    Produtos
                </a>
                <a href="{{ route('anuncios.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('anuncios.*') ? 'bg-black' : '' }}">
                    Anúncios
                </a>

                @auth
                    @if(auth()->user()?->is_admin)
                        <a href="{{ route('users.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('users.*') ? 'bg-black' : '' }}">
                            Usuários
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-zinc-900 border border-green-800">
                        <div class="h-8 w-8 rounded-full bg-zinc-900 flex items-center justify-center font-semibold text-green-300">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="leading-tight">
                            <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-green-400">{{ auth()->user()->is_admin ? 'Administrador' : 'Cliente' }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-green-600 text-black text-sm font-semibold hover:bg-slate-800">
                            Sair
                        </button>
                    </form>
                @else
                    <a class="px-4 py-2 rounded-xl bg-green-600 text-black text-sm font-semibold hover:bg-slate-800"
                       href="{{ route('login') }}">
                        Entrar
                    </a>
                @endauth
            </div>
        </div>

        <nav class="sm:hidden border-t border-green-800 bg-black/80">
            <div class="max-w-6xl mx-auto px-4 py-2 flex items-center gap-2 overflow-x-auto">
                <a href="{{ route('produtos.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('produtos.*') ? 'bg-black' : '' }}">
                    Produtos
                </a>
                <a href="{{ route('anuncios.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('anuncios.*') ? 'bg-black' : '' }}">
                    Anúncios
                </a>
                @auth
                    @if(auth()->user()?->is_admin)
                        <a href="{{ route('users.index') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-black {{ request()->routeIs('users.*') ? 'bg-black' : '' }}">
                            Usuários
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="max-w-6xl mx-auto px-4 pb-10 text-xs text-green-400">
        <div class="flex items-center justify-between border-t border-green-800 pt-6">
            <span>© {{ date('Y') }} Yuriel Abreu</span>
            <span class="hidden sm:inline">Laravel • MySQL • Eloquent</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
