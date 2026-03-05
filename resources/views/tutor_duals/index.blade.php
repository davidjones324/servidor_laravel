<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-ies-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-ies-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión de Tutores Duales') }}
                </h2>
            </div>
            <a href="{{ route('tutores.create') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Tutor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-0 card-ies border-t-4 border-ies-green-500">
                <div class="p-6">
                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <button onclick="document.getElementById('filter-bar').classList.toggle('hidden')" class="p-2 text-gray-400 hover:text-ies-blue-600 transition-colors" title="Filtrar">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>

                        <div id="filter-bar" class="{{ request()->anyFilled(['search', 'ciclo']) ? '' : 'hidden' }} bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                            <form action="{{ route('tutores.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="search" :value="__('Buscar por nombre/apellidos')" />
                                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="request('search')" placeholder="Empieza por..." />
                                </div>
                                <div>
                                    <x-input-label for="ciclo" :value="__('Filtrar por Ciclo')" />
                                    <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos los ciclos</option>
                                        <option value="ASIR" {{ request('ciclo') == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                        <option value="DAM" {{ request('ciclo') == 'DAM' ? 'selected' : '' }}>DAM</option>
                                        <option value="SMR" {{ request('ciclo') == 'SMR' ? 'selected' : '' }}>SMR</option>
                                    </select>
                                </div>
                                <div class="flex items-end space-x-2">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-ies-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-ies-blue-700 active:bg-ies-blue-800 transition ease-in-out duration-150 shadow-sm">
                                        {{ __('Aplicar Filtro') }}
                                    </button>
                                    <a href="{{ route('tutores.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Limpiar') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-ies-green-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">Nombre Completo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">Ciclo</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-widest italic">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($tutores as $tutor)
                                <tr class="hover:bg-ies-green-50/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-lg bg-ies-green-100 flex items-center justify-center text-ies-green-700 font-bold mr-3">
                                                {{ substr($tutor->nombre, 0, 1) }}
                                            </div>
                                            <div class="text-sm font-bold text-gray-900">{{ $tutor->nombre }} {{ $tutor->apellidos }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium italic">
                                        {{ $tutor->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="badge-ies-green">
                                            {{ $tutor->ciclo }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('tutores.show', $tutor) }}" class="text-ies-blue-600 hover:text-ies-blue-900 transition" title="Ver">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('tutores.edit', $tutor) }}" class="text-ies-green-600 hover:text-ies-green-900 transition" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar tutor?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Borrar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-gray-500 italic font-medium">No hay tutores registrados.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 italic">
                    {{ $tutores->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
