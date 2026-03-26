<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Acuerdo') }}: {{ $acuerdo->nombre_acuerdo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('acuerdos.update', $acuerdo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Contexto Académico del Acuerdo (Solo Lectura en Edición) -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <p class="md:col-span-4 text-xs text-gray-500 font-semibold uppercase tracking-widest">📋 Contexto Académico (No editable)</p>
                        <!-- Ciclo -->
                        <div>
                            <x-input-label :value="__('Ciclo')" />
                            <div class="mt-1 block w-full py-2 px-3 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm font-bold text-gray-700">
                                {{ $acuerdo->ciclo }}
                            </div>
                            <input type="hidden" name="ciclo" value="{{ $acuerdo->ciclo }}">
                        </div>

                        <!-- Curso -->
                        <div>
                            <x-input-label :value="__('Curso')" />
                            <div class="mt-1 block w-full py-2 px-3 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm font-bold text-gray-700">
                                {{ $acuerdo->curso }}
                            </div>
                            <input type="hidden" name="curso" value="{{ $acuerdo->curso }}">
                        </div>

                        <!-- Grupo -->
                        <div>
                            <x-input-label :value="__('Grupo')" />
                            <div class="mt-1 block w-full py-2 px-3 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm font-bold text-gray-700">
                                {{ $acuerdo->grupo }}
                            </div>
                            <input type="hidden" name="grupo" value="{{ $acuerdo->grupo }}">
                        </div>

                        <!-- Año Académico -->
                        <div>
                            <x-input-label :value="__('Año Académico')" />
                            <div class="mt-1 block w-full py-2 px-3 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm font-bold text-gray-700">
                                {{ $acuerdo->ano_academico }}
                            </div>
                            <input type="hidden" name="ano_academico" value="{{ $acuerdo->ano_academico }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Alumno (Read Only) -->
                        <div class="relative">
                            <x-input-label for="alumno_id_display" :value="__('Alumno')" />
                            <div class="mt-1 block w-full py-2 px-3 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm font-bold text-gray-500">
                                {{ $acuerdo->alumno->nombre }} {{ $acuerdo->alumno->apellidos }}
                            </div>
                            <input type="hidden" name="alumno_id" value="{{ $acuerdo->alumno_id }}">
                        </div>


                        <!-- NSS del Alumno (Editable) -->
                        <div class="mb-6 bg-ies-blue-50/50 p-4 rounded-xl border border-ies-blue-100/50 shadow-sm transition-all hover:bg-ies-blue-50">
                            <label for="numero_ss" class="block text-xs font-black text-ies-blue-600 uppercase mb-2 tracking-widest">Número Seguridad Social Alumno</label>
                            <input type="text" name="numero_ss" id="numero_ss" value="{{ old('numero_ss', $acuerdo->alumno->numero_ss) }}" 
                                class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 text-sm font-medium"
                                placeholder="Introduce el NSS si falta o es incorrecto...">
                            @if(!$acuerdo->alumno->numero_ss)
                                <div class="mt-2 flex items-center space-x-1.5 animate-pulse">
                                    <span class="text-[10px] bg-red-100 text-red-700 font-black px-2 py-0.5 rounded-full border border-red-200 uppercase tracking-tighter">⚠️ NSS FALTANTE</span>
                                </div>
                            @endif
                        </div>

                        <!-- Seguro Escolar del Acuerdo -->
                        <div class="mb-8 flex items-center p-4 bg-white/50 rounded-xl border border-gray-100 transition-all hover:border-ies-green-200 group">
                            <div class="relative flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="tiene_seguro" name="tiene_seguro" type="checkbox" value="1"
                                        {{ old('tiene_seguro', $acuerdo->tiene_seguro) ? 'checked' : '' }} 
                                        class="h-5 w-5 rounded-md border-gray-300 text-ies-green-600 focus:ring-ies-green-500 transition-colors cursor-pointer">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="tiene_seguro" class="font-black text-gray-700 cursor-pointer select-none uppercase tracking-wide group-hover:text-ies-green-700 transition-colors">Seguro Escolar Acuerdo</label>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Estado del seguro escolar para este acuerdo específico</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <x-input-label for="empresa_id" class="flex justify-between">
                                <span>{{ __('Empresa') }}</span>
                                <button type="button" onclick="toggleSearch('search_empresa')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            <input type="text" id="search_empresa" onkeyup="filterSelect('search_empresa', 'empresa_id')" placeholder="Buscar empresa..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select id="empresa_id" name="empresa_id" onchange="updateContacts(this.value)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" 
                                        data-ciclos="{{ implode(',', $empresa->ciclos ?? []) }}"
                                        {{ old('empresa_id', $acuerdo->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('empresa_id')" />
                        </div>

                        <!-- Tutor Laboral -->
                        <div class="relative md:col-span-2">
                            <x-input-label for="contacto_empresa_id" class="flex justify-between">
                                <span>{{ __('Tutor Laboral') }}</span>
                                <button type="button" onclick="toggleSearch('search_contacto')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            
                            <input type="text" id="search_contacto" onkeyup="filterSelect('search_contacto', 'contacto_empresa_id')" placeholder="Buscar tutor laboral..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-2">
                            <select name="contacto_empresa_id" id="contacto_empresa_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecciona un tutor laboral</option>
                                @foreach($empresas as $empresa)
                                    @foreach($empresa->contactos as $contacto)
                                        <option value="{{ $contacto->id }}" 
                                            data-empresa="{{ $empresa->id }}" 
                                            {{ old('contacto_empresa_id', $acuerdo->contacto_empresa_id) == $contacto->id ? 'selected' : '' }} 
                                            class="hidden">
                                            {{ $contacto->nombre }} {{ $contacto->apellidos }} - {{ $contacto->telefono }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('contacto_empresa_id')" />
                        </div>

                        <!-- Tutor Dual -->
                        <div class="relative">
                            <x-input-label for="tutor_dual_id" class="flex justify-between">
                                <span>{{ __('Tutor Dual') }}</span>
                                <button type="button" onclick="toggleSearch('search_tutor')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            <input type="text" id="search_tutor" onkeyup="filterSelect('search_tutor', 'tutor_dual_id')" placeholder="Buscar tutor..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select id="tutor_dual_id" name="tutor_dual_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}" 
                                        data-ciclos="{{ json_encode($tutor->ciclos) }}"
                                        data-cursos="{{ json_encode($tutor->cursos) }}"
                                        data-grupos="{{ json_encode($tutor->grupos) }}"
                                        {{ old('tutor_dual_id', $acuerdo->tutor_dual_id) == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->nombre }} {{ $tutor->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tutor_dual_id')" />
                        </div>



                        <!-- Localidad -->
                        <div>
                            <x-input-label for="localidad" :value="__('Localidad')" />
                            <x-text-input id="localidad" name="localidad" type="text" class="mt-1 block w-full" :value="old('localidad', $acuerdo->localidad)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('localidad')" />
                        </div>

                        <!-- Nombre Acuerdo -->
                        <div>
                            <x-input-label for="nombre_acuerdo" :value="__('Nombre del Acuerdo')" />
                            <x-text-input id="nombre_acuerdo" name="nombre_acuerdo" type="text" class="mt-1 block w-full" :value="old('nombre_acuerdo', $acuerdo->nombre_acuerdo)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre_acuerdo')" />
                        </div>

                        <!-- Estado -->
                        <div>
                            <x-input-label for="estado_id" :value="__('Estado')" />
                            <select id="estado_id" name="estado_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_id', $acuerdo->estado_id) == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado_id')" />
                        </div>

                        <!-- Horario -->
                        <div>
                            <x-input-label for="horario" :value="__('Horario')" />
                            <x-text-input id="horario" name="horario" type="text" class="mt-1 block w-full" :value="old('horario', $acuerdo->horario)" />
                            <x-input-error class="mt-2" :messages="$errors->get('horario')" />
                        </div>

                        <!-- Horas Totales -->
                        <div>
                            <x-input-label for="horas_totales" :value="__('Horas Totales')" />
                            <x-text-input id="horas_totales" name="horas_totales" type="number" class="mt-1 block w-full" :value="old('horas_totales', $acuerdo->horas_totales)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('horas_totales')" />
                        </div>

                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-button onclick="window.location='{{ route('acuerdos.index') }}'">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Actualizar Acuerdo') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Formulario oculto para eliminar contacto (fuera del principal) --}}
    <form id="contact_delete_form" action="#" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function toggleSearch(id) {
            const input = document.getElementById(id);
            input.classList.toggle('hidden');
            if (!input.classList.contains('hidden')) {
                input.focus();
            }
        }

        function filterSelect(inputId, selectId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const select = document.getElementById(selectId);
            const options = select.options;

            for (let i = 0; i < options.length; i++) {
                const txtValue = options[i].text.toLowerCase();
                if (txtValue.startsWith(filter)) {
                    options[i].style.display = "";
                } else {
                    options[i].style.display = "none";
                }
            }
        }

        function updateContacts(empresaId) {
            const selectContacto = document.getElementById('contacto_empresa_id');
            const currentContacto = selectContacto.value;

            // Filter Tutor Laboral
            let contactoFound = false;
            Array.from(selectContacto.options).forEach((opt, i) => {
                if (i === 0) return;
                if (opt.getAttribute('data-empresa') == empresaId || empresaId == "") {
                    opt.classList.remove('hidden');
                    opt.style.display = "";
                    if (opt.value == currentContacto) contactoFound = true;
                } else {
                    opt.classList.add('hidden');
                    opt.style.display = "none";
                }
            });
            if (!contactoFound && empresaId != "") {
                selectContacto.value = "";
            }
        }

        function updateAlumnoNSS(select) {
            const selectedOption = select.options[select.selectedIndex];
            const nssInput = document.getElementById('numero_ss');
            const nssWarning = nssInput.nextElementSibling;
            
            if (selectedOption && selectedOption.value) {
                const nss = selectedOption.getAttribute('data-nss');
                nssInput.value = nss || "";
                
                if (nss) {
                    // nssInput.readOnly = true; // Remove to allow corrections
                    // nssInput.classList.add('bg-gray-50');
                    if (nssWarning && nssWarning.tagName === 'P') nssWarning.classList.add('hidden');
                } else {
                    nssInput.readOnly = false;
                    nssInput.classList.remove('bg-gray-50');
                    if (nssWarning && nssWarning.tagName === 'P') nssWarning.classList.remove('hidden');
                }
            }
        }


        function filterEmpresasByContext() {
            const cycle = document.getElementsByName('ciclo')[0].value.toLowerCase();

            // Filter Empresas by ciclo
            const selectEmpresa = document.getElementById('empresa_id');
            const currentEmpresa = selectEmpresa.value;
            let empresaStillValid = false;

            Array.from(selectEmpresa.options).forEach((opt, i) => {
                if (i === 0) return;
                if (!cycle) {
                    opt.style.display = "";
                    if (opt.value == currentEmpresa) empresaStillValid = true;
                    return;
                }
                const optCiclos = (opt.getAttribute('data-ciclos') || "").toLowerCase();
                if (optCiclos.includes(cycle)) {
                    opt.style.display = "";
                    if (opt.value == currentEmpresa) empresaStillValid = true;
                } else {
                    opt.style.display = "none";
                }
            });

            if (!empresaStillValid && currentEmpresa != "") {
                // We keep it if it was already selected but doesn't match the new cycle? 
                // In edit mode the cycle is fixed, so the current empresa SHOULD match or it was an old inconsistency.
                // selectEmpresa.value = ""; // Don't clear in edit mode unless we really want strictness
            }
        }

        // Initialize contacts
        window.onload = function() {
            const empresaId = document.getElementById('empresa_id').value;
            if (empresaId) {
                updateContacts(empresaId);
            }
            filterEmpresasByContext();
        };
    </script>
</x-app-layout>
