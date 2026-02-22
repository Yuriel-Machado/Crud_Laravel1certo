@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Usuários</h1>
            <p class="text-sm text-green-300">Apenas administradores podem gerenciar usuários.</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="shrink-0 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
            <span class="text-base">＋</span> Novo usuário
        </a>
    </div>

    <div class="bg-zinc-900/70 backdrop-blur border border-green-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-black border-b border-green-800">
                    <tr class="text-green-300">
                        <th class="p-4 text-left font-semibold">Nome</th>
                        <th class="p-4 text-left font-semibold">Email</th>
                        <th class="p-4 text-left font-semibold">Perfil</th>
                        <th class="p-4 text-right font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-green-900 hover:bg-black/50">
                        <td class="p-4 font-semibold">{{ $user->name }}</td>
                        <td class="p-4 text-green-300">{{ $user->email }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->is_admin ? 'bg-slate-900 text-white' : 'bg-black text-green-300' }}">
                                {{ $user->is_admin ? 'Administrador' : 'Cliente' }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a class="px-3 py-1.5 rounded-lg border border-green-800 hover:bg-zinc-900 text-green-300"
                                   href="{{ route('users.show', $user) }}">Ver</a>
                                <a class="px-3 py-1.5 rounded-lg border border-green-800 hover:bg-zinc-900 text-green-300"
                                   href="{{ route('users.edit', $user) }}">Editar</a>
                                <form class="inline" method="POST" action="{{ route('users.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50"
                                            onclick="return confirm('Remover usuário?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-8 text-center text-green-300" colspan="4">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
