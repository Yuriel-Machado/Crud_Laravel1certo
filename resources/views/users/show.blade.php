@extends('layouts.app')
@section('title', 'Ver Usuário')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Usuário</h1>
            <p class="text-sm text-green-300">Detalhes do usuário.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('users.edit', $user) }}"
               class="px-4 py-2.5 rounded-xl border border-green-800 bg-zinc-900 hover:bg-black text-sm font-semibold text-green-300">
                Editar
            </a>
            <a href="{{ route('users.index') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
                <div class="text-xs uppercase tracking-wide text-green-400">Nome</div>
                <div class="text-lg font-semibold">{{ $user->name }}</div>
            </div>

            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800">
                <div class="text-xs uppercase tracking-wide text-green-400">Email</div>
                <div class="text-lg font-semibold">{{ $user->email }}</div>
            </div>

            <div class="p-4 rounded-xl bg-zinc-900 border border-green-800 sm:col-span-2">
                <div class="text-xs uppercase tracking-wide text-green-400">Perfil</div>
                <div class="text-lg font-semibold">{{ $user->is_admin ? 'Administrador' : 'Cliente' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
