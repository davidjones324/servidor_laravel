<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-ies-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Detalles del Acuerdo') }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('acuerdos.edit', $acuerdo) }}" class="btn-primary bg-ies-green-600 hover:bg-ies-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editar
                </a>
                <a href="{{ route('acuerdos.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Volver al listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-0 card-ies">
                <!-- Banner Superior -->
                <div class="bg-gradient-to-r from-ies-blue-600 to-ies-blue-800 px-10 py-8 text-white relative">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight truncate">{{ $acuerdo->nombre_acuerdo }}</h3>
                            <div class="flex flex-wrap items-center gap-6 text-blue-100">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $acuerdo->localidad }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $acuerdo->curso }} ({{ $acuerdo->ano }})
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end shrink-0">
                            <div class="mb-3">
                                @if($acuerdo->estado_convenio == 'firmado')
                                    <span class="px-5 py-2.5 rounded-full text-sm font-bold bg-green-500 text-white shadow-lg border border-green-400">Firmado</span>
                                @elseif($acuerdo->estado_convenio == 'hecho_pendiente_firma')
                                    <span class="px-5 py-2.5 rounded-full text-sm font-bold bg-yellow-500 text-white shadow-lg border border-yellow-400">Pendiente de Firma</span>
                                @else
                                    <span class="px-5 py-2.5 rounded-full text-sm font-bold bg-blue-400 text-white shadow-lg border border-blue-300">Pendiente</span>
                                @endif
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20">
                                <p class="text-xs text-blue-100 font-bold uppercase tracking-widest mb-0.5">Carga Horaria</p>
                                <p class="text-2xl font-black text-white">{{ $acuerdo->horas_totales }} <span class="text-sm font-normal text-blue-200 uppercase">horas</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Columna Izquierda: Entidades -->
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 border-b-2 border-ies-blue-100 pb-2 mb-4">Participantes</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <!-- Alumno -->
                                    <a href="{{ route('alumnos.show', $acuerdo->alumno) }}" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition shadow-sm group">
                                        <div class="h-12 w-12 rounded-full bg-ies-blue-100 flex items-center justify-center text-ies-blue-700 font-bold mr-4 group-hover:bg-ies-blue-600 group-hover:text-white transition">
                                            {{ substr($acuerdo->alumno->nombre, 0, 1) }}{{ substr($acuerdo->alumno->apellidos, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alumno</p>
                                            <p class="text-base font-bold text-gray-800 group-hover:text-ies-blue-600 transition">{{ $acuerdo->alumno->nombre }} {{ $acuerdo->alumno->apellidos }}</p>
                                        </div>
                                    </a>

                                    <!-- Empresa -->
                                    <a href="{{ route('empresas.show', $acuerdo->empresa) }}" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition shadow-sm group">
                                        <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-700 font-bold mr-4 group-hover:bg-gray-700 group-hover:text-white transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Empresa</p>
                                            <p class="text-base font-bold text-gray-800 group-hover:text-ies-blue-600 transition">{{ $acuerdo->empresa->razon_social }}</p>
                                        </div>
                                    </a>

                                    <!-- Tutor Dual -->
                                    <a href="{{ route('tutores.show', $acuerdo->tutorDual) }}" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition shadow-sm group">
                                        <div class="h-12 w-12 rounded-full bg-ies-green-100 flex items-center justify-center text-ies-green-700 font-bold mr-4 group-hover:bg-ies-green-600 group-hover:text-white transition">
                                            {{ substr($acuerdo->tutorDual->nombre, 0, 1) }}{{ substr($acuerdo->tutorDual->apellidos, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tutor Dual</p>
                                            <p class="text-base font-bold text-gray-800 group-hover:text-ies-blue-600 transition">{{ $acuerdo->tutorDual->nombre }} {{ $acuerdo->tutorDual->apellidos }}</p>
                                        </div>
                                    </a>

                                    <!-- Responsable -->
                                    <a href="{{ route('responsables.show', $acuerdo->responsable) }}" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition shadow-sm group">
                                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold mr-4 group-hover:bg-purple-600 group-hover:text-white transition">
                                            {{ substr($acuerdo->responsable->nombre, 0, 1) }}{{ substr($acuerdo->responsable->apellidos, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Responsable</p>
                                            <p class="text-base font-bold text-gray-800 group-hover:text-ies-blue-600 transition">{{ $acuerdo->responsable->nombre }} {{ $acuerdo->responsable->apellidos }}</p>
                                            @if($acuerdo->responsable->cargo)
                                                <p class="text-[10px] text-purple-600 font-bold uppercase">{{ $acuerdo->responsable->cargo }}</p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Contacto Empresa -->
                            @php
                                $contactoToShow = $acuerdo->contactoEmpresa ?? $acuerdo->empresa->tutorLaboralFct ?? $acuerdo->empresa->contactos->first();
                            @endphp

                            @if($contactoToShow)
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 border-b-2 border-ies-green-100 pb-2 mb-4">
                                    Contacto en la Empresa
                                    @if(!$acuerdo->contactoEmpresa)
                                        <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded ml-2 uppercase">Sugerido (Empresa)</span>
                                    @endif
                                </h4>
                                <div class="bg-ies-green-50/30 p-5 rounded-2xl border border-ies-green-100 relative overflow-hidden">
                                    <div class="absolute right-0 top-0 opacity-5 -mr-4 -mt-4">
                                        <svg class="w-32 h-32 text-ies-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center mb-4">
                                            <div class="h-10 w-10 rounded-full bg-ies-green-100 flex items-center justify-center text-ies-green-700 font-bold mr-3 shadow-sm border-2 border-white">
                                                {{ substr($contactoToShow->nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-md font-bold text-gray-900">{{ $contactoToShow->nombre }} {{ $contactoToShow->apellidos }}</p>
                                                <p class="text-xs font-bold text-ies-green-700 uppercase tracking-widest">{{ $contactoToShow->puesto }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center text-sm text-gray-700 bg-white/60 p-2 rounded-lg border border-white/40">
                                                <svg class="w-4 h-4 mr-2 text-ies-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                <span class="font-bold mr-2">Teléfono:</span> {{ $contactoToShow->telefono }}
                                            </div>
                                            @if($contactoToShow->correo)
                                            <div class="flex items-center text-sm text-gray-700 bg-white/60 p-2 rounded-lg border border-white/40">
                                                <svg class="w-4 h-4 mr-2 text-ies-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                <span class="font-bold mr-2">Email:</span> {{ $contactoToShow->correo }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Columna Derecha: Información Adicional -->
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 border-b-2 border-ies-blue-100 pb-2 mb-4">Detalles Técnicos</h4>
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Horario</p>
                                            <p class="text-gray-700 font-medium leading-relaxed">{{ $acuerdo->horario ?? 'No especificado' }}</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Grupo</p>
                                                <p class="text-gray-700 font-bold text-lg">{{ $acuerdo->grupo }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Año Académico</p>
                                                <p class="text-gray-700 font-bold text-lg">{{ $acuerdo->ano }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Estado de Aviso</p>
                                            @if($acuerdo->avisado)
                                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-ies-green-100 text-ies-green-800">
                                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                    Avisado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    No Avisado
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100/50">
                                <div class="flex items-start">
                                    <div class="p-2 bg-blue-100 rounded-lg mr-4">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-blue-900 mb-1">Última actualización</p>
                                        <p class="text-xs text-blue-700">{{ $acuerdo->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie de página con acciones destructivas -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end">
                    <form action="{{ route('acuerdos.destroy', $acuerdo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este acuerdo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm transition flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Eliminar Acuerdo Permanentemente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
