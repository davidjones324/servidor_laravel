<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-ies-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Perfil del Tutor Dual') }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('tutores.edit', $tutor) }}" class="btn-secondary text-xs uppercase tracking-widest px-4 py-2">
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('tutores.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 transition">
                    {{ __('Volver') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies border-t-4 border-ies-green-500 p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Avatar y Ciclo -->
                    <div class="flex flex-col items-center p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="w-24 h-24 bg-ies-green-100 rounded-full flex items-center justify-center text-ies-green-700 text-3xl font-bold mb-4 shadow-inner">
                            {{ substr($tutor->nombre, 0, 1) }}{{ substr($tutor->apellidos, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $tutor->nombre }} {{ $tutor->apellidos }}</h3>
                        <span class="badge-ies-green mt-2 text-sm px-4 py-1">Tutor {{ $tutor->ciclo }}</span>
                    </div>

                    <!-- Datos Detallados -->
                    <div class="md:col-span-2 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">DNI / NIE</p>
                                <p class="text-md font-semibold text-gray-800 tracking-tighter">{{ $tutor->dni }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono Directo</p>
                                <p class="text-md font-semibold text-gray-800">{{ $tutor->telefono }}</p>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Correo Institucional</p>
                            <a href="mailto:{{ $tutor->email }}" class="text-xl font-bold text-ies-blue-600 hover:text-ies-blue-800 transition break-all">
                                {{ $tutor->email }}
                            </a>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between text-gray-400 text-xs italic">
                            <span>Registrado el {{ $tutor->created_at->format('d/m/Y') }}</span>
                            <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-bold transition">Eliminar Cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
