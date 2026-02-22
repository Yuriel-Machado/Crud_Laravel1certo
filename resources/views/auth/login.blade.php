@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Entrar</h1>
            <p class="text-sm text-green-300">Acesse sua conta para gerenciar seus produtos e anúncios.</p>
        </div>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="voce@exemplo.com"
                       required />
            </div>

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">Senha</label>
                <input type="password"
                       name="password"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300"
                       placeholder="••••••••"
                       required />
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-green-300">
                    <input type="checkbox" name="remember" value="1" class="rounded border-green-800" />
                    Lembrar
                </label>
            </div>

            <button class="w-full px-4 py-3 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800">
                Entrar
            </button>
        </form>

        <div class="mt-5 text-xs text-green-400">
            Não tem acesso? Peça para um administrador criar seu usuário.
        </div>
    </div>
</div>
@endsection
