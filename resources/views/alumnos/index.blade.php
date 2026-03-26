<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-ies-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">🎓</span>
                </div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Gestión de Alumnos') }}
                </h2>
            </div>
            <a href="{{ route('alumnos.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Alumno
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="mb-4 p-3 bg-ies-green-100 text-ies-green-700 rounded-lg border border-ies-green-200 flex items-center space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <button onclick="document.getElementById('filter-bar').classList.toggle('hidden')" class="p-2 text-gray-400 hover:text-ies-blue-600 transition-colors" title="Filtrar">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>

                        <div id="filter-bar" class="{{ request()->anyFilled(['search', 'ciclo', 'grupo', 'curso']) ? '' : 'hidden' }} bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                            <form action="{{ route('alumnos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-input-label for="search" :value="__('Nombre / Apellidos')" />
                                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full text-sm" :value="request('search')" placeholder="Buscar..." />
                                </div>
                                <div>
                                    <x-input-label for="ciclo" :value="__('Ciclo')" />
                                    <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="ASIR" {{ request('ciclo') == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                        <option value="DAM" {{ request('ciclo') == 'DAM' ? 'selected' : '' }}>DAM</option>
                                        <option value="SMR" {{ request('ciclo') == 'SMR' ? 'selected' : '' }}>SMR</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="grupo" :value="__('Grupo')" />
                                    <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full text-sm" :value="request('grupo')" placeholder="A, B..." />
                                </div>
                                <div>
                                    <x-input-label for="curso" :value="__('Año Académico')" />
                                    <x-text-input id="curso" name="curso" type="text" class="mt-1 block w-full text-sm" :value="request('curso')" placeholder="24/25..." />
                                </div>
                                <div class="md:col-span-4 flex justify-end space-x-2 border-t pt-3 mt-1">
                                    @if(request()->anyFilled(['search', 'ciclo', 'grupo', 'curso']))
                                        <a href="{{ route('alumnos.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('Limpiar') }}
                                        </a>
                                    @endif
                                    <x-primary-button type="submit">
                                        {{ __('Filtrar Alumnos') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="table-header">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Ciclo</th>
                                    <th>Año Académico</th>
                                    <th>Grupo</th>
                                    <th>DNI</th>
                                    <th>Nº SS</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($alumnos as $alumno)
                                    <tr class="hover:bg-ies-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $alumno->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $alumno->apellidos }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($alumno->ciclo)
                                                <span class="badge-ies-green">{{ $alumno->ciclo }} {{ $alumno->anio_ciclo }}º</span>
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->curso }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->grupo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->dni ?? 'Sin DNI' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($alumno->numero_ss)
                                                <span class="font-mono text-gray-600">{{ $alumno->numero_ss }}</span>
                                            @else
                                                <span class="text-red-600 font-extrabold text-xs uppercase">SIN NSS</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                            <div class="flex justify-end space-x-3">
                                                <a href="{{ route('alumnos.show', $alumno) }}" class="text-ies-blue-600 hover:text-ies-blue-800 font-medium">Ver</a>
                                                <a href="{{ route('alumnos.edit', $alumno) }}" class="text-ies-green-600 hover:text-ies-green-800 font-medium">Editar</a>
                                                <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este alumno?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">
                                            <div class="flex flex-col items-center">
                                                <span class="text-3xl mb-2">📭</span>
                                                <span>No hay alumnos registrados.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $alumnos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
