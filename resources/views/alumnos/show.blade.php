<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Alumno') }}
            </h2>
            <a href="{{ route('alumnos.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Volver al listado</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="border-b pb-4 mb-4">
                    <h3 class="text-2xl font-bold">{{ $alumno->nombre }} {{ $alumno->apellidos }}</h3>
                    <p class="text-gray-600">
                        @if($alumno->dni) <span class="font-bold">DNI: {{ $alumno->dni }}</span> | @endif
                        {{ $alumno->email }} | {{ $alumno->telefono }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2 border-b">Datos Académicos</h4>
                        <p><strong>Curso:</strong> {{ $alumno->curso }}</p>
                        <p><strong>Grupo:</strong> {{ $alumno->grupo }}</p>
                        <p><strong>Residencia:</strong> {{ $alumno->residencia ?? 'No especificada' }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2 border-b">Otros Datos</h4>
                        <p><strong>Carnet Conducir:</strong> {{ $alumno->carnet_conducir ? 'Sí' : 'No' }}</p>
                        <p><strong>Coche Propio:</strong> {{ $alumno->coche_propio ? 'Sí' : 'No' }}</p>
                        <p><strong>Apto FFOE:</strong> {{ $alumno->apto_ffoe ? 'Sí' : 'No' }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <h4 class="font-bold text-gray-700 mb-2 border-b">Acuerdos de Prácticas</h4>
                    <!-- Aquí se listarían los acuerdos relacionados -->
                    <p class="text-gray-500 italic">No hay acuerdos registrados para este alumno.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
