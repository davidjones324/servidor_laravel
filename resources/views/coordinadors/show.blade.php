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
                    <!-- Información Básica -->
                    <!-- Información de Contacto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información de Contacto -->
                    <div class="bg-white border-4 border-blue-800 p-5 mb-4 shadow-none rounded-none h-full">
                        <h3 class="text-base font-black text-blue-900 mb-4 flex items-center gap-2">
                             <span class="p-1.5 bg-blue-100 text-blue-800 rounded text-sm">👤</span> 
                             Información de Contacto
                        </h3>
                        <div class="divide-y divide-slate-100">
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">Nombre:</span>
                                <span class="text-sm font-black text-slate-900 uppercase">{{ $coordinador->nombre }} {{ $coordinador->apellidos }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">DNI / ID:</span>
                                <span class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ $coordinador->dni }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">Email:</span>
                                <span class="text-sm font-black text-blue-800 break-all">{{ $coordinador->email }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">Teléfono:</span>
                                <span class="text-sm font-black font-mono text-blue-900">{{ $coordinador->telefono }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Estado Actual -->
                    <div class="bg-white border-4 border-green-800 p-5 mb-4 shadow-none rounded-none self-start">
                        <h3 class="text-base font-black text-green-900 mb-4 flex items-center gap-2">
                             <span class="p-1.5 bg-green-100 text-green-800 rounded text-sm">📊</span> 
                             Estado Actual
                        </h3>
                        <div class="divide-y divide-slate-100">
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">Fecha Alta:</span>
                                <span class="text-sm font-black text-slate-900 uppercase">{{ $coordinador->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="grid grid-cols-[140px_1fr] py-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase self-center">Estatus:</span>
                                <span class="text-xs font-black text-green-700 uppercase italic tracking-widest">ACTIVO</span>
                            </div>
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
