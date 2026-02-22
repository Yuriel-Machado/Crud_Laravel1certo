@extends('layouts.app')
@section('title', 'Novo Usuário')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">Novo usuário</h1>
        <p class="text-sm text-green-300">Crie um usuário cliente ou administrador.</p>
    </div>

    <form method="POST" action="{{ route('users.store') }}" class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Nome</label>
                <input name="name" value="{{ old('name') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-green-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">Senha</label>
                <input type="password" name="password"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-green-300 mb-1">Confirmar senha</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-green-800 rounded-xl p-3 bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-slate-300" />
            </div>

            <div class="sm:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-green-300">
                    <input type="checkbox" name="is_admin" value="1" class="rounded border-green-800" @checked(old('is_admin')) />
                    Administrador
                </label>
                <div class="text-xs text-green-400 mt-1">Administradores conseguem acessar a aba Usuários.</div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300 text-center">
                Cancelar
            </a>
            <button class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Salvar
            </button>
        </div>
    </form>
</div>
@endsection
