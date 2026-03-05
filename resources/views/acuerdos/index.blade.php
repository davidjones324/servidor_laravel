<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-ies-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">📄</span>
                </div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Gestión de Acuerdos') }}
                </h2>
            </div>
            <a href="{{ route('acuerdos.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Acuerdo
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

                        <div id="filter-bar" class="{{ request()->anyFilled(['search', 'estado_convenio', 'avisado']) ? '' : 'hidden' }} bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                            <form action="{{ route('acuerdos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-input-label for="search" :value="__('Nombre del Acuerdo')" />
                                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Empieza por..." />
                                </div>
                                <div>
                                    <x-input-label for="estado_convenio" :value="__('Estado Convenio')" />
                                    <select id="estado_convenio" name="estado_convenio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="pendiente" {{ request('estado_convenio') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="hecho_pendiente_firma" {{ request('estado_convenio') == 'hecho_pendiente_firma' ? 'selected' : '' }}>Hecho pte. Firma</option>
                                        <option value="firmado" {{ request('estado_convenio') == 'firmado' ? 'selected' : '' }}>Firmado</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="avisado" :value="__('Avisado')" />
                                    <select id="avisado" name="avisado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('avisado') === '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ request('avisado') === '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="flex items-end space-x-2">
                                    <x-primary-button type="submit">
                                        {{ __('Aplicar') }}
                                    </x-primary-button>
                                    @if(request()->anyFilled(['search', 'estado_convenio', 'avisado']))
                                        <a href="{{ route('acuerdos.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('Limpiar') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="table-header">
                                <tr>
                                    <th>Acuerdo</th>
                                    <th>Alumno</th>
                                    <th>Empresa</th>
                                    <th>Estado</th>
                                    <th>Avisado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($acuerdos as $acuerdo)
                                    <tr class="hover:bg-ies-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $acuerdo->nombre_acuerdo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $acuerdo->alumno->nombre }} {{ $acuerdo->alumno->apellidos }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acuerdo->empresa->razon_social }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $estadoClasses = match($acuerdo->estado_convenio) {
                                                    'firmado' => 'bg-ies-green-100 text-ies-green-700',
                                                    'hecho_pendiente_firma' => 'bg-ies-blue-100 text-ies-blue-700',
                                                    default => 'bg-amber-100 text-amber-700',
                                                };
                                                $estadoLabel = match($acuerdo->estado_convenio) {
                                                    'firmado' => 'Firmado',
                                                    'hecho_pendiente_firma' => 'Hecho pte. Firma',
                                                    default => 'Pendiente',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoClasses }}">
                                                {{ $estadoLabel }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($acuerdo->avisado)
                                                <span class="badge-ies-green">AVISADO</span>
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                            <div class="flex justify-end space-x-3">
                                                <a href="{{ route('acuerdos.show', $acuerdo) }}" class="text-ies-blue-600 hover:text-ies-blue-800 font-medium">Ver</a>
                                                <a href="{{ route('acuerdos.edit', $acuerdo) }}" class="text-ies-green-600 hover:text-ies-green-800 font-medium">Editar</a>
                                                <form action="{{ route('acuerdos.destroy', $acuerdo) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este acuerdo?')">
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
                                                <span class="text-3xl mb-2">📋</span>
                                                <span>No hay acuerdos registrados.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $acuerdos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
