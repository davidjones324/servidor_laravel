<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Alumno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('alumnos.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full text-sm" :value="old('nombre')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <x-input-label for="apellidos" :value="__('Apellidos')" />
                            <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full text-sm" :value="old('apellidos')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                        </div>

                        <!-- DNI -->
                        <div>
                            <x-input-label for="dni" :value="__('DNI / NIE')" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full text-sm" :value="old('dni')" />
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        <!-- Nº SS -->
                        <div>
                            <x-input-label for="numero_ss" :value="__('Nº de la Seguridad Social')" />
                            <x-text-input id="numero_ss" name="numero_ss" type="text" class="mt-1 block w-full text-sm" :value="old('numero_ss')" />
                            <x-input-error class="mt-2" :messages="$errors->get('numero_ss')" />
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div>
                            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full text-sm" :value="old('fecha_nacimiento')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-sm" :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Telefono -->
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full text-sm" :value="old('telefono')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <!-- Seguro Escolar -->
                        <div class="flex items-center mt-6">
                            <input type="hidden" name="seguro_escolar" value="0">
                            <input id="seguro_escolar" name="seguro_escolar" type="checkbox" value="1" {{ old('seguro_escolar') ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="seguro_escolar" class="ml-2 text-sm font-medium text-gray-700">Tiene Seguro Escolar contratado</label>
                            <x-input-error class="mt-2" :messages="$errors->get('seguro_escolar')" />
                        </div>

                        <!-- Dirección Completa -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-4 uppercase tracking-wider">📍 Localización y Residencia</h4>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="domicilio" :value="__('Domicilio Habitual')" />
                            <x-text-input id="domicilio" name="domicilio" type="text" class="mt-1 block w-full text-sm" :value="old('domicilio')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('domicilio')" />
                            <input type="hidden" name="direccion" value="Migrado a domicilio">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="codigo_postal" :value="__('C. Postal')" />
                                <x-text-input id="codigo_postal" name="codigo_postal" type="text" class="mt-1 block w-full text-sm" :value="old('codigo_postal')" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="localidad" :value="__('Localidad')" />
                                <x-text-input id="localidad" name="localidad" type="text" class="mt-1 block w-full text-sm" :value="old('localidad')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="provincia" :value="__('Provincia')" />
                            <x-text-input id="provincia" name="provincia" type="text" class="mt-1 block w-full text-sm" :value="old('provincia')" />
                            <x-input-error class="mt-2" :messages="$errors->get('provincia')" />
                        </div>

                        <div>
                            <x-input-label for="residencia" :value="__('Residencia durante el curso')" />
                            <x-text-input id="residencia" name="residencia" type="text" class="mt-1 block w-full text-sm" :value="old('residencia')" placeholder="Pueblo/Ciudad" />
                            <x-input-error class="mt-2" :messages="$errors->get('residencia')" />
                        </div>

                        <div class="md:col-span-2 text-sm bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <x-input-label for="segunda_residencia" :value="__('Segunda Residencia (Otras localidades)')" />
                            <x-text-input id="segunda_residencia" name="segunda_residencia" type="text" class="mt-1 block w-full text-sm" :value="old('segunda_residencia')" placeholder="Indica otras localidades si dispone de ellas" />
                            <x-input-error class="mt-2" :messages="$errors->get('segunda_residencia')" />
                        </div>
                        
                        <!-- Block spacer -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-4 uppercase tracking-wider">🎓 Datos Académicos</h4>
                        </div>

                        <!-- Ciclo -->
                        <div>
                            <x-input-label for="ciclo" :value="__('Ciclo')" />
                            <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                <option value="">Seleccione Ciclo...</option>
                                <option value="ASIR" {{ old('ciclo') == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                <option value="DAM" {{ old('ciclo') == 'DAM' ? 'selected' : '' }}>DAM</option>
                                <option value="SMR" {{ old('ciclo') == 'SMR' ? 'selected' : '' }}>SMR</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('ciclo')" />
                        </div>

                        <!-- Año Ciclo y Grupo -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="anio_ciclo" :value="__('Curso')" />
                                <select id="anio_ciclo" name="anio_ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                    <option value="1" {{ old('anio_ciclo') == '1' ? 'selected' : '' }}>1º</option>
                                    <option value="2" {{ old('anio_ciclo') == '2' ? 'selected' : '' }}>2º</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('anio_ciclo')" />
                            </div>
                            <div>
                                <x-input-label for="grupo" :value="__('Grupo')" />
                                <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full text-sm" :value="old('grupo')" placeholder="A, B, C..." required />
                                <x-input-error class="mt-2" :messages="$errors->get('grupo')" />
                            </div>
                        </div>

                        <!-- Curso / Año Escolar -->
                        <div>
                            <x-input-label for="curso" :value="__('Año Académico')" />
                            <x-text-input id="curso" name="curso" type="text" class="mt-1 block w-full text-sm" :value="old('curso', '24/25')" placeholder="24/25" required />
                            <x-input-error class="mt-2" :messages="$errors->get('curso')" />
                        </div>

                        <!-- Estudios Anteriores -->
                        <div class="md:col-span-2">
                            <x-input-label for="estudios_anteriores" :value="__('Estudios Anteriores')" />
                            <textarea id="estudios_anteriores" name="estudios_anteriores" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm" placeholder="Indica estudios realizados previamente...">{{ old('estudios_anteriores') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('estudios_anteriores')" />
                        </div>

                        <!-- Block spacer -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-4 uppercase tracking-wider">🔄 Situación FCT / Otros</h4>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="ha_realizado_fct_anterior" value="0">
                            <input id="ha_realizado_fct_anterior" name="ha_realizado_fct_anterior" type="checkbox" value="1" {{ old('ha_realizado_fct_anterior') ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500" onchange="document.getElementById('fct_anterior_fields').style.display = this.checked ? 'grid' : 'none'">
                            <label for="ha_realizado_fct_anterior" class="ml-2 text-sm text-gray-600">¿Ha realizado FCT anteriormente?</label>
                        </div>

                        <div id="fct_anterior_fields" class="md:col-span-2 grid grid-cols-2 gap-4" style="display: {{ old('ha_realizado_fct_anterior') ? 'grid' : 'none' }}">
                            <div>
                                <x-input-label for="empresa_fct_anterior" :value="__('Empresa FCT Anterior')" />
                                <x-text-input id="empresa_fct_anterior" name="empresa_fct_anterior" type="text" class="mt-1 block w-full text-sm" :value="old('empresa_fct_anterior')" />
                                <x-input-error class="mt-2" :messages="$errors->get('empresa_fct_anterior')" />
                            </div>
                            <div>
                                <x-input-label for="localidad_fct_anterior" :value="__('Localidad FCT Anterior')" />
                                <x-text-input id="localidad_fct_anterior" name="localidad_fct_anterior" type="text" class="mt-1 block w-full text-sm" :value="old('localidad_fct_anterior')" />
                                <x-input-error class="mt-2" :messages="$errors->get('localidad_fct_anterior')" />
                            </div>
                        </div>

                        <!-- Carnet Conducir -->
                        <div class="flex items-center">
                            <input type="hidden" name="carnet_conducir" value="0">
                            <input id="carnet_conducir" name="carnet_conducir" type="checkbox" value="1" {{ old('carnet_conducir') ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="carnet_conducir" class="ml-2 text-sm text-gray-600">Tiene carnet de conducir (B)</label>
                        </div>

                        <!-- Coche Propio -->
                        <div class="flex items-center">
                            <input type="hidden" name="coche_propio" value="0">
                            <input id="coche_propio" name="coche_propio" type="checkbox" value="1" {{ old('coche_propio') ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="coche_propio" class="ml-2 text-sm text-gray-600">Tiene coche propio</label>
                        </div>

                        <!-- Apto FFEOE -->
                        <div class="flex items-center">
                            <input type="hidden" name="apto_ffoe" value="0">
                            <input id="apto_ffoe" name="apto_ffoe" type="checkbox" value="1" {{ old('apto_ffoe', 1) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500" onchange="document.getElementById('motivo_exclusion_container').style.display = this.checked ? 'none' : 'block'">
                            <label for="apto_ffoe" class="ml-2 text-sm font-medium text-gray-700">Apto para FFEOE / Dual</label>
                            <x-input-error class="mt-2" :messages="$errors->get('apto_ffoe')" />
                        </div>

                        <!-- Motivo Exclusión -->
                        <div id="motivo_exclusion_container" style="display: {{ old('apto_ffoe', 1) ? 'none' : 'block' }}">
                            <x-input-label for="motivo_exclusion" :value="__('Motivo de Exclusión')" />
                            <select id="motivo_exclusion" name="motivo_exclusion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                <option value="">Seleccione un motivo...</option>
                                <option value="Matrícula incompleta" {{ old('motivo_exclusion') == 'Matrícula incompleta' ? 'selected' : '' }}>Matrícula incompleta</option>
                                <option value="No supera RRLL IPE I" {{ old('motivo_exclusion') == 'No supera RRLL IPE I' ? 'selected' : '' }}>No supera RRLL IPE I</option>
                                <option value="No supera RRLL Redes" {{ old('motivo_exclusion') == 'No supera RRLL Redes' ? 'selected' : '' }}>No supera RRLL Redes</option>
                                <option value="No supera RRLL Montaje" {{ old('motivo_exclusion') == 'No supera RRLL Montaje' ? 'selected' : '' }}>No supera RRLL Montaje</option>
                                <option value="Ya cursada" {{ old('motivo_exclusion') == 'Ya cursada' ? 'selected' : '' }}>Ya cursada</option>
                                <option value="Baja" {{ old('motivo_exclusion') == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('motivo_exclusion')" />
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones Generales')" />
                            <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm" placeholder="Otras informaciones relevantes...">{{ old('observaciones') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observaciones')" />
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-end space-x-3">
                        <x-secondary-button onclick="window.location='{{ route('alumnos.index') }}'">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Crear Alumno') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
