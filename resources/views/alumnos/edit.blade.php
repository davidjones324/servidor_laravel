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
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full text-sm" :value="old('nombre', $alumno->nombre)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <x-input-label for="apellidos" :value="__('Apellidos')" />
                            <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full text-sm" :value="old('apellidos', $alumno->apellidos)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                        </div>

                        <!-- DNI -->
                        <div>
                            <x-input-label for="dni" :value="__('DNI / NIE')" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full text-sm" :value="old('dni', $alumno->dni)" />
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        <!-- Nº SS -->
                        <div>
                            <x-input-label for="numero_ss" :value="__('Nº de la Seguridad Social')" />
                            <x-text-input id="numero_ss" name="numero_ss" type="text" class="mt-1 block w-full text-sm" :value="old('numero_ss', $alumno->numero_ss)" />
                            <x-input-error class="mt-2" :messages="$errors->get('numero_ss')" />
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div>
                            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full text-sm" :value="old('fecha_nacimiento', $alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('Y-m-d') : '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-sm" :value="old('email', $alumno->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Telefono -->
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full text-sm" :value="old('telefono', $alumno->telefono)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <!-- Seguro Escolar -->
                        <div class="flex items-center mt-6">
                            <input type="hidden" name="seguro_escolar" value="0">
                            <input id="seguro_escolar" name="seguro_escolar" type="checkbox" value="1" {{ old('seguro_escolar', $alumno->seguro_escolar) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="seguro_escolar" class="ml-2 text-sm font-medium text-gray-700">Tiene Seguro Escolar contratado</label>
                            <x-input-error class="mt-2" :messages="$errors->get('seguro_escolar')" />
                        </div>

                        <!-- Dirección Completa -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-4 uppercase tracking-wider">📍 Localización y Residencia</h4>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="domicilio" :value="__('Domicilio Habitual')" />
                            <x-text-input id="domicilio" name="domicilio" type="text" class="mt-1 block w-full text-sm" :value="old('domicilio', $alumno->domicilio ?? $alumno->direccion)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('domicilio')" />
                            <input type="hidden" name="direccion" value="{{ old('domicilio', $alumno->domicilio ?? $alumno->direccion) }}">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="codigo_postal" :value="__('C. Postal')" />
                                <x-text-input id="codigo_postal" name="codigo_postal" type="text" class="mt-1 block w-full text-sm" :value="old('codigo_postal', $alumno->codigo_postal)" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="localidad" :value="__('Localidad')" />
                                <x-text-input id="localidad" name="localidad" type="text" class="mt-1 block w-full text-sm" :value="old('localidad', $alumno->localidad)" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="provincia" :value="__('Provincia')" />
                            <x-text-input id="provincia" name="provincia" type="text" class="mt-1 block w-full text-sm" :value="old('provincia', $alumno->provincia)" />
                            <x-input-error class="mt-2" :messages="$errors->get('provincia')" />
                        </div>

                        <div>
                            <x-input-label for="residencia" :value="__('Residencia durante el curso')" />
                            <x-text-input id="residencia" name="residencia" type="text" class="mt-1 block w-full text-sm" :value="old('residencia', $alumno->residencia)" placeholder="Pueblo/Ciudad" />
                            <x-input-error class="mt-2" :messages="$errors->get('residencia')" />
                        </div>

                        <div class="md:col-span-2 text-sm bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <x-input-label for="segunda_residencia" :value="__('Segunda Residencia (Otras localidades)')" />
                            <x-text-input id="segunda_residencia" name="segunda_residencia" type="text" class="mt-1 block w-full text-sm" :value="old('segunda_residencia', $alumno->segunda_residencia)" placeholder="Indica otras localidades si dispone de ellas" />
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
                                <option value="ASIR" {{ old('ciclo', $alumno->ciclo) == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                <option value="DAM" {{ old('ciclo', $alumno->ciclo) == 'DAM' ? 'selected' : '' }}>DAM</option>
                                <option value="SMR" {{ old('ciclo', $alumno->ciclo) == 'SMR' ? 'selected' : '' }}>SMR</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('ciclo')" />
                        </div>

                        <!-- Año Ciclo y Grupo -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="anio_ciclo" :value="__('Curso')" />
                                <select id="anio_ciclo" name="anio_ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                    <option value="1" {{ old('anio_ciclo', $alumno->anio_ciclo) == '1' ? 'selected' : '' }}>1º</option>
                                    <option value="2" {{ old('anio_ciclo', $alumno->anio_ciclo) == '2' ? 'selected' : '' }}>2º</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('anio_ciclo')" />
                            </div>
                            <div>
                                <x-input-label for="grupo" :value="__('Grupo')" />
                                <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full text-sm" :value="old('grupo', $alumno->grupo)" placeholder="A, B, C..." required />
                                <x-input-error class="mt-2" :messages="$errors->get('grupo')" />
                            </div>
                        </div>

                        <!-- Curso / Año Escolar -->
                        <div>
                            <x-input-label for="curso" :value="__('Año Académico')" />
                            <x-text-input id="curso" name="curso" type="text" class="mt-1 block w-full text-sm" :value="old('curso', $alumno->curso)" placeholder="24/25" required />
                            <x-input-error class="mt-2" :messages="$errors->get('curso')" />
                        </div>

                        <!-- Estudios Anteriores -->
                        <div class="md:col-span-2">
                            <x-input-label for="estudios_anteriores" :value="__('Estudios Anteriores')" />
                            <textarea id="estudios_anteriores" name="estudios_anteriores" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">{{ old('estudios_anteriores', $alumno->estudios_anteriores) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('estudios_anteriores')" />
                        </div>

                        <!-- Block spacer -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 border-b pb-2 mb-4 uppercase tracking-wider">🔄 Situación FCT / Otros</h4>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="ha_realizado_fct_anterior" value="0">
                            <input id="ha_realizado_fct_anterior" name="ha_realizado_fct_anterior" type="checkbox" value="1" {{ old('ha_realizado_fct_anterior', $alumno->ha_realizado_fct_anterior) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500" onchange="document.getElementById('fct_anterior_fields').style.display = this.checked ? 'grid' : 'none'">
                            <label for="ha_realizado_fct_anterior" class="ml-2 text-sm text-gray-600">¿Ha realizado FCT anteriormente?</label>
                        </div>

                        <div id="fct_anterior_fields" class="md:col-span-2 grid grid-cols-2 gap-4" style="display: {{ old('ha_realizado_fct_anterior', $alumno->ha_realizado_fct_anterior) ? 'grid' : 'none' }}">
                            <div>
                                <x-input-label for="empresa_fct_anterior" :value="__('Empresa FCT Anterior')" />
                                <x-text-input id="empresa_fct_anterior" name="empresa_fct_anterior" type="text" class="mt-1 block w-full text-sm" :value="old('empresa_fct_anterior', $alumno->empresa_fct_anterior)" />
                                <x-input-error class="mt-2" :messages="$errors->get('empresa_fct_anterior')" />
                            </div>
                            <div>
                                <x-input-label for="localidad_fct_anterior" :value="__('Localidad FCT Anterior')" />
                                <x-text-input id="localidad_fct_anterior" name="localidad_fct_anterior" type="text" class="mt-1 block w-full text-sm" :value="old('localidad_fct_anterior', $alumno->localidad_fct_anterior)" />
                                <x-input-error class="mt-2" :messages="$errors->get('localidad_fct_anterior')" />
                            </div>
                        </div>

                        <!-- Carnet Conducir -->
                        <div class="flex items-center">
                            <input type="hidden" name="carnet_conducir" value="0">
                            <input id="carnet_conducir" name="carnet_conducir" type="checkbox" value="1" {{ old('carnet_conducir', $alumno->carnet_conducir) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="carnet_conducir" class="ml-2 text-sm text-gray-600">Tiene carnet de conducir (B)</label>
                        </div>

                        <!-- Coche Propio -->
                        <div class="flex items-center">
                            <input type="hidden" name="coche_propio" value="0">
                            <input id="coche_propio" name="coche_propio" type="checkbox" value="1" {{ old('coche_propio', $alumno->coche_propio) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500">
                            <label for="coche_propio" class="ml-2 text-sm text-gray-600">Tiene coche propio</label>
                        </div>

                        <!-- Apto FFEOE -->
                        <div class="flex items-center">
                            <input type="hidden" name="apto_ffoe" value="0">
                            <input id="apto_ffoe" name="apto_ffoe" type="checkbox" value="1" {{ old('apto_ffoe', $alumno->apto_ffoe ?? 1) ? 'checked' : '' }} class="rounded border-gray-300 text-ies-blue-600 shadow-sm focus:ring-ies-blue-500" onchange="document.getElementById('motivo_exclusion_container').style.display = this.checked ? 'none' : 'block'">
                            <label for="apto_ffoe" class="ml-2 text-sm font-medium text-gray-700">Apto para FFEOE / Dual</label>
                            <x-input-error class="mt-2" :messages="$errors->get('apto_ffoe')" />
                        </div>

                        <!-- Motivo Exclusión -->
                        <div id="motivo_exclusion_container" style="display: {{ old('apto_ffoe', $alumno->apto_ffoe ?? 1) ? 'none' : 'block' }}">
                            <x-input-label for="motivo_exclusion" :value="__('Motivo de Exclusión')" />
                            <select id="motivo_exclusion" name="motivo_exclusion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                <option value="">Seleccione un motivo...</option>
                                <option value="Matrícula incompleta" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'Matrícula incompleta' ? 'selected' : '' }}>Matrícula incompleta</option>
                                <option value="No supera RRLL IPE I" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'No supera RRLL IPE I' ? 'selected' : '' }}>No supera RRLL IPE I</option>
                                <option value="No supera RRLL Redes" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'No supera RRLL Redes' ? 'selected' : '' }}>No supera RRLL Redes</option>
                                <option value="No supera RRLL Montaje" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'No supera RRLL Montaje' ? 'selected' : '' }}>No supera RRLL Montaje</option>
                                <option value="Ya cursada" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'Ya cursada' ? 'selected' : '' }}>Ya cursada</option>
                                <option value="Baja" {{ old('motivo_exclusion', $alumno->motivo_exclusion) == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('motivo_exclusion')" />
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones Generales')" />
                            <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm" placeholder="Otras informaciones relevantes...">{{ old('observaciones', $alumno->observaciones) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observaciones')" />
                        </div>

                        <!-- Historial de Matrículas -->
                        <div class="md:col-span-2 bg-ies-blue-50/30 p-6 rounded-xl border border-ies-blue-100/50 mt-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-base font-black text-gray-800 uppercase tracking-widest flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.246 18.477 16.5 18s-3.332.477-4.5 1.253" />
                                    </svg>
                                    Historial de Matrículas (Anteriores)
                                </h3>
                                <button type="button" onclick="document.getElementById('new_matricula_form').classList.toggle('hidden')" class="text-xs bg-ies-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-ies-blue-700 flex items-center font-bold shadow-md transition">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Añadir Matrícula
                                </button>
                            </div>

                            <!-- Formulario inline para nueva matrícula (oculto por defecto) -->
                            <div id="new_matricula_form" class="hidden mb-6 p-4 bg-white rounded-xl border border-ies-blue-200 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <input type="hidden" id="m_alumno_id" value="{{ $alumno->id }}">
                                    <div>
                                        <x-input-label for="m_ciclo" :value="__('Ciclo')" />
                                        <select id="m_ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                            <option value="ASIR">ASIR</option>
                                            <option value="DAM">DAM</option>
                                            <option value="SMR">SMR</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="m_curso" :value="__('Curso')" />
                                        <select id="m_curso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                                            <option value="1º">1º</option>
                                            <option value="2º">2º</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="m_grupo" :value="__('Grupo')" />
                                        <x-text-input id="m_grupo" type="text" class="mt-1 block w-full text-sm" placeholder="Ej: A" />
                                    </div>
                                    <div>
                                        <x-input-label for="m_anio" :value="__('Año Académico')" />
                                        <x-text-input id="m_anio" type="text" class="mt-1 block w-full text-sm" placeholder="Ej: 2023/24" />
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button type="button" onclick="submitMatricula()" class="bg-ies-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-ies-blue-700 transition">Guardar Matrícula</button>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Año</th>
                                            <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Ciclo</th>
                                            <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Curso/Grupo</th>
                                            <th class="px-4 py-2 text-center text-[10px] font-bold text-gray-500 uppercase tracking-widest">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($alumno->matriculas->sortByDesc('anio_academico') as $matricula)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-900">{{ $matricula->anio_academico }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 font-medium">{{ $matricula->ciclo }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 font-medium">{{ $matricula->curso }} - {{ $matricula->grupo }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                                    <button type="button" onclick="deleteMatricula({{ $matricula->id }})" class="text-red-500 hover:text-red-700 font-bold text-[10px] uppercase">Eliminar</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-8 text-center text-xs text-gray-400 italic">No hay registros de matrículas anteriores.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-end space-x-3">
                        <x-secondary-button type="button" onclick="window.location='{{ route('alumnos.index') }}'">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden helper forms for Matriculas (Must be outside the main form) -->
    <form id="store_matricula_form" action="{{ route('matriculas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="alumno_id" id="hidden_m_alumno_id">
        <input type="hidden" name="ciclo" id="hidden_m_ciclo">
        <input type="hidden" name="curso" id="hidden_m_curso">
        <input type="hidden" name="grupo" id="hidden_m_grupo">
        <input type="hidden" name="anio_academico" id="hidden_m_anio">
    </form>

    <form id="delete_matricula_form" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function submitMatricula() {
            document.getElementById('hidden_m_alumno_id').value = document.getElementById('m_alumno_id').value;
            document.getElementById('hidden_m_ciclo').value = document.getElementById('m_ciclo').value;
            document.getElementById('hidden_m_curso').value = document.getElementById('m_curso').value;
            document.getElementById('hidden_m_grupo').value = document.getElementById('m_grupo').value;
            document.getElementById('hidden_m_anio').value = document.getElementById('m_anio').value;
            document.getElementById('store_matricula_form').submit();
        }

        function deleteMatricula(id) {
            if (confirm('¿Eliminar esta matrícula del historial?')) {
                const form = document.getElementById('delete_matricula_form');
                form.action = "{{ route('matriculas.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>
</x-app-layout>
