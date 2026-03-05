<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Alumno') }}: {{ $alumno->nombre }} {{ $alumno->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $alumno->nombre)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <x-input-label for="apellidos" :value="__('Apellidos')" />
                            <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full" :value="old('apellidos', $alumno->apellidos)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                        </div>

                        <!-- DNI -->
                        <div>
                            <x-input-label for="dni" :value="__('DNI / NIE')" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $alumno->dni)" />
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div>
                            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento', $alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('Y-m-d') : '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $alumno->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Telefono -->
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $alumno->telefono)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <!-- Direccion -->
                        <div>
                            <x-input-label for="direccion" :value="__('Dirección')" />
                            <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $alumno->direccion)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                        </div>

                        <!-- Residencia -->
                        <div>
                            <x-input-label for="residencia" :value="__('Residencia')" />
                            <x-text-input id="residencia" name="residencia" type="text" class="mt-1 block w-full" :value="old('residencia', $alumno->residencia)" />
                            <x-input-error class="mt-2" :messages="$errors->get('residencia')" />
                        </div>

                        <!-- Curso -->
                        <div>
                            <x-input-label for="curso" :value="__('Curso')" />
                            <x-text-input id="curso" name="curso" type="text" class="mt-1 block w-full" :value="old('curso', $alumno->curso)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('curso')" />
                        </div>

                        <!-- Grupo -->
                        <div>
                            <x-input-label for="grupo" :value="__('Grupo')" />
                            <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full" :value="old('grupo', $alumno->grupo)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('grupo')" />
                        </div>

                        <!-- Ciclo -->
                        <div>
                            <x-input-label for="ciclo" :value="__('Ciclo')" />
                            <x-text-input id="ciclo" name="ciclo" type="text" class="mt-1 block w-full" :value="old('ciclo', $alumno->ciclo)" />
                            <x-input-error class="mt-2" :messages="$errors->get('ciclo')" />
                        </div>

                        <!-- Año Ciclo -->
                        <div>
                            <x-input-label for="anio_ciclo" :value="__('Año del Ciclo')" />
                            <x-text-input id="anio_ciclo" name="anio_ciclo" type="text" class="mt-1 block w-full" :value="old('anio_ciclo', $alumno->anio_ciclo)" />
                            <x-input-error class="mt-2" :messages="$errors->get('anio_ciclo')" />
                        </div>

                        <!-- Carnet Conducir -->
                        <div class="flex items-center mt-4">
                            <input id="carnet_conducir" name="carnet_conducir" type="checkbox" value="1" {{ old('carnet_conducir', $alumno->carnet_conducir) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="carnet_conducir" class="ml-2 text-sm text-gray-600">Tiene carnet de conducir</label>
                            <x-input-error class="mt-2" :messages="$errors->get('carnet_conducir')" />
                        </div>

                        <!-- Coche Propio -->
                        <div class="flex items-center mt-4">
                            <input id="coche_propio" name="coche_propio" type="checkbox" value="1" {{ old('coche_propio', $alumno->coche_propio) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="coche_propio" class="ml-2 text-sm text-gray-600">Tiene coche propio</label>
                            <x-input-error class="mt-2" :messages="$errors->get('coche_propio')" />
                        </div>

                        <!-- Estudios Anteriores -->
                        <div class="md:col-span-2">
                            <x-input-label for="estudios_anteriores" :value="__('Estudios Anteriores')" />
                            <textarea id="estudios_anteriores" name="estudios_anteriores" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('estudios_anteriores', $alumno->estudios_anteriores) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('estudios_anteriores')" />
                        </div>

                        <!-- Prácticas Pasadas -->
                        <div>
                            <x-input-label for="practicas_pasadas" :value="__('Prácticas Pasadas')" />
                            <x-text-input id="practicas_pasadas" name="practicas_pasadas" type="text" class="mt-1 block w-full" :value="old('practicas_pasadas', $alumno->practicas_pasadas)" />
                            <x-input-error class="mt-2" :messages="$errors->get('practicas_pasadas')" />
                        </div>

                        <!-- Apto FFOE -->
                        <div class="flex items-center mt-4">
                            <input id="apto_ffoe" name="apto_ffoe" type="checkbox" value="1" {{ old('apto_ffoe', $alumno->apto_ffoe) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="apto_ffoe" class="ml-2 text-sm text-gray-600">Apto para FFOE</label>
                            <x-input-error class="mt-2" :messages="$errors->get('apto_ffoe')" />
                        </div>

                        <!-- Motivo Exclusión -->
                        <div>
                            <x-input-label for="motivo_exclusion" :value="__('Motivo de Exclusión')" />
                            <select id="motivo_exclusion" name="motivo_exclusion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Seleccione uno (opcional)</option>
                                <option value="no_prl" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'no_prl' ? 'selected' : '' }}>No PRL</option>
                                <option value="matricula_incompleta" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'matricula_incompleta' ? 'selected' : '' }}>Matrícula Incompleta</option>
                                <option value="otros" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('motivo_exclusion')" />
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones')" />
                            <textarea id="observaciones" name="observaciones" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('observaciones', $alumno->observaciones) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observaciones')" />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-button onclick="window.location='{{ route('alumnos.index') }}'">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Actualizar Alumno') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
