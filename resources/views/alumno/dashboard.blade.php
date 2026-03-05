<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-ies-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-ies-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Mi Perfil de Prácticas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Personal Data Card -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                        <h3 class="text-xl font-bold text-gray-800">Datos Personales</h3>
                        <span class="badge-ies-blue uppercase">Alumno</span>
                    </div>

                    @if($alumno = Auth::user()->alumno)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400">👤</span>
                                <p><strong class="text-gray-700">Nombre completo:</strong> <span class="text-gray-900">{{ $alumno->nombre }} {{ $alumno->apellidos }}</span></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400">📧</span>
                                <p><strong class="text-gray-700">Email:</strong> <span class="text-gray-900">{{ $alumno->email }}</span></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400">📱</span>
                                <p><strong class="text-gray-700">Teléfono:</strong> <span class="text-gray-900">{{ $alumno->telefono }}</span></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-400">📚</span>
                                <p><strong class="text-gray-700">Curso/Grupo:</strong> <span class="text-gray-900">{{ $alumno->curso }} - {{ $alumno->grupo }}</span></p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg flex items-center space-x-2">
                            <span>⚠️</span>
                            <span>No tienes una ficha de alumno asociada. Contacta con tu profesor.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Agreement Card -->
            <div class="card">
                <div class="card-body">
                    <h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-4 mb-5">Mi Acuerdo de Prácticas</h3>

                    @if($alumno && $acuerdo = $alumno->acuerdos()->latest()->first())
                        <div class="p-5 border border-gray-100 rounded-xl bg-gray-50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-bold text-ies-blue-700">{{ $acuerdo->nombre_acuerdo }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">Empresa: {{ $acuerdo->empresa->razon_social }}</p>
                                </div>
                                <span class="badge-ies-green uppercase">
                                    {{ $acuerdo->estado_convenio }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mt-4 pt-4 border-t border-gray-200">
                                <p><strong class="text-gray-700">Horas Totales:</strong> {{ $acuerdo->horas_totales }}</p>
                                <p><strong class="text-gray-700">Tutor Dual:</strong> {{ $acuerdo->tutorDual->nombre }} {{ $acuerdo->tutorDual->apellidos }}</p>
                                <p><strong class="text-gray-700">Curso:</strong> {{ $acuerdo->curso }} ({{ $acuerdo->ano }})</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Aún no tienes acuerdos de prácticas registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
