<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detalles del Coordinador') }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('coordinadores.edit', $coordinador) }}" class="inline-flex items-center px-4 py-2 bg-ies-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-ies-blue-700 active:bg-ies-blue-900 focus:outline-none focus:border-ies-blue-900 focus:ring ring-ies-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('coordinadores.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Volver') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-ies p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Información Básica -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-ies-blue-800 border-b border-gray-100 pb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información de Contacto
                        </h3>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nombre Completo</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $coordinador->nombre }} {{ $coordinador->apellidos }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">DNI / Identificación</p>
                            <p class="text-gray-800 font-medium">{{ $coordinador->dni }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Correo Electrónico</p>
                            <a href="mailto:{{ $coordinador->email }}" class="text-ies-blue-600 hover:underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $coordinador->email }}
                            </a>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Teléfono</p>
                            <p class="text-gray-800 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $coordinador->telefono }}
                            </p>
                        </div>
                    </div>

                    <!-- Estadísticas o Info Adicional -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 self-start">
                        <h3 class="text-md font-bold text-gray-700 mb-4 uppercase tracking-wider">Resumen de Actividad</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                                <p class="text-xs text-gray-400 uppercase font-bold">Fecha de Alta</p>
                                <p class="text-md font-semibold text-gray-700">{{ $coordinador->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold">Estado</p>
                                    <p class="text-md font-semibold text-green-600">Activo</p>
                                </div>
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex justify-start">
                    <form action="{{ route('coordinadores.destroy', $coordinador) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este coordinador? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center transition duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('Eliminar Coordinador Permanentemente') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
