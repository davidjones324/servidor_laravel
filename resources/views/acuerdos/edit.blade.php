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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Alumno -->
                        <div class="relative">
                            <x-input-label for="alumno_id" class="flex justify-between">
                                <span>{{ __('Alumno') }}</span>
                                <button type="button" onclick="toggleSearch('search_alumno')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            <input type="text" id="search_alumno" onkeyup="filterSelect('search_alumno', 'alumno_id')" placeholder="Buscar alumno..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select id="alumno_id" name="alumno_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->id }}" {{ old('alumno_id', $acuerdo->alumno_id) == $alumno->id ? 'selected' : '' }}>
                                        {{ $alumno->nombre }} {{ $alumno->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('alumno_id')" />
                        </div>

                        <!-- Empresa -->
                        <div class="relative">
                            <x-input-label for="empresa_id" class="flex justify-between">
                                <span>{{ __('Empresa') }}</span>
                                <button type="button" onclick="toggleSearch('search_empresa')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            <input type="text" id="search_empresa" onkeyup="filterSelect('search_empresa', 'empresa_id')" placeholder="Buscar empresa..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select id="empresa_id" name="empresa_id" onchange="updateContacts(this.value)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $acuerdo->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('empresa_id')" />
                        </div>

                        <!-- Persona de Contacto -->
                        <div class="relative md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Persona de Contacto (Empresa)</label>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="toggleSearch('search_contacto')" class="text-xs bg-white border border-gray-300 px-2 py-1 rounded hover:bg-gray-50 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        Buscar
                                    </button>
                                    <a id="link_nuevo_contacto" href="{{ route('contactos.create') }}" target="_blank" class="text-xs bg-ies-blue-600 text-white px-2 py-1 rounded hover:bg-ies-blue-700 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Añadir Nuevo
                                    </a>
                                </div>
                            </div>
                            
                            <input type="text" id="search_contacto" onkeyup="filterSelect('search_contacto', 'contacto_empresa_id')" placeholder="Buscar contacto por nombre..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-2">
                            
                                <div class="flex items-center space-x-4 mb-4 bg-white p-2 rounded border border-gray-100">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="contact_mode" value="existing" checked onclick="toggleContactMode('existing')" class="text-ies-blue-600 focus:ring-ies-blue-500">
                                        <span class="ml-2 text-xs font-bold text-gray-600 uppercase">Contacto Existente</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="contact_mode" value="new" onclick="toggleContactMode('new')" class="text-ies-blue-600 focus:ring-ies-blue-500">
                                        <span class="ml-2 text-xs font-bold text-gray-600 uppercase">Ver detalles / Nuevo</span>
                                    </label>
                                </div>

                                <div id="existing_contact_section">
                                    <select name="contacto_empresa_id" id="contacto_empresa_id" onchange="autoFillContact(this)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Selecciona un contacto</option>
                                        @foreach($empresas as $empresa)
                                            @foreach($empresa->contactos as $contacto)
                                                <option value="{{ $contacto->id }}" 
                                                    data-empresa="{{ $empresa->id }}" 
                                                    data-telefono="{{ $contacto->telefono }}"
                                                    data-dni="{{ $contacto->dni }}"
                                                    data-puesto="{{ $contacto->puesto }}"
                                                    {{ old('contacto_empresa_id', $acuerdo->contacto_empresa_id) == $contacto->id ? 'selected' : '' }} 
                                                    class="hidden">
                                                    {{ $contacto->nombre }} {{ $contacto->apellidos }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div id="contact_details_section" class="hidden md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Teléfono</label>
                                        <input type="text" id="contacto_telefono" placeholder="Selecciona un contacto..." readonly class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-md shadow-sm text-sm text-gray-600">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">DNI/CIF Persona</label>
                                        <input type="text" id="contacto_dni" placeholder="Selecciona un contacto..." readonly class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-md shadow-sm text-sm text-gray-600">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-medium text-gray-500">Puesto en la Empresa</label>
                                        <input type="text" id="contacto_puesto" placeholder="Selecciona un contacto..." readonly class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-md shadow-sm text-sm text-gray-600">
                                    </div>
                                </div>
                            </div>
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
                                    <option value="{{ $tutor->id }}" {{ old('tutor_dual_id', $acuerdo->tutor_dual_id) == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->nombre }} {{ $tutor->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tutor_dual_id')" />
                        </div>

                        <!-- Responsable -->
                        <div class="relative">
                            <x-input-label for="responsable_id" class="flex justify-between">
                                <span>{{ __('Responsable') }}</span>
                                <button type="button" onclick="toggleSearch('search_responsable')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </x-input-label>
                            <input type="text" id="search_responsable" onkeyup="filterSelect('search_responsable', 'responsable_id')" placeholder="Buscar responsable..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select id="responsable_id" name="responsable_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @foreach($responsables as $responsable)
                                    <option value="{{ $responsable->id }}" {{ old('responsable_id', $acuerdo->responsable_id) == $responsable->id ? 'selected' : '' }}>
                                        {{ $responsable->nombre }} {{ $responsable->apellidos }} @if($responsable->cargo) ({{ $responsable->cargo }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('responsable_id')" />
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

                        <!-- Estado Convenio -->
                        <div>
                            <x-input-label for="estado_convenio" :value="__('Estado del Convenio')" />
                            <select id="estado_convenio" name="estado_convenio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="pendiente" {{ old('estado_convenio', $acuerdo->estado_convenio) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="hecho_pendiente_firma" {{ old('estado_convenio', $acuerdo->estado_convenio) == 'hecho_pendiente_firma' ? 'selected' : '' }}>Realizado</option>
                                <option value="firmado" {{ old('estado_convenio', $acuerdo->estado_convenio) == 'firmado' ? 'selected' : '' }}>Firmado</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado_convenio')" />
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

                        <!-- Grupo -->
                        <div>
                            <x-input-label for="grupo" :value="__('Grupo')" />
                            <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full" :value="old('grupo', $acuerdo->grupo)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('grupo')" />
                        </div>

                        <!-- Curso -->
                        <div>
                            <x-input-label for="curso" :value="__('Curso')" />
                            <x-text-input id="curso" name="curso" type="text" class="mt-1 block w-full" :value="old('curso', $acuerdo->curso)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('curso')" />
                        </div>

                        <!-- Año -->
                        <div>
                            <x-input-label for="ano" :value="__('Año')" />
                            <x-text-input id="ano" name="ano" type="number" class="mt-1 block w-full" :value="old('ano', $acuerdo->ano)" required min="2000" />
                            <x-input-error class="mt-2" :messages="$errors->get('ano')" />
                        </div>

                        <!-- Avisado -->
                        <div class="flex items-center mt-4">
                            <input id="avisado" name="avisado" type="checkbox" value="1" {{ old('avisado', $acuerdo->avisado) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="avisado" class="ml-2 text-sm text-gray-600">Avisado</label>
                            <x-input-error class="mt-2" :messages="$errors->get('avisado')" />
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
            const select = document.getElementById('contacto_empresa_id');
            const options = select.options;
            const linkNuevo = document.getElementById('link_nuevo_contacto');
            const currentValue = select.value;
            
            // Update "Añadir Nuevo" link
            if (empresaId) {
                linkNuevo.href = "{{ route('contactos.create') }}?empresa_id=" + empresaId;
            } else {
                linkNuevo.href = "{{ route('contactos.create') }}";
            }

            let found = false;
            for (let i = 1; i < options.length; i++) {
                const opt = options[i];
                if (opt.getAttribute('data-empresa') == empresaId || empresaId == "") {
                    opt.classList.remove('hidden');
                    opt.style.display = "";
                    if (opt.value == currentValue) found = true;
                } else {
                    opt.classList.add('hidden');
                    opt.style.display = "none";
                }
            }
            if (!found && empresaId != "") {
                select.value = "";
                autoFillContact(select);
            }
        }

        function autoFillContact(select) {
            const selectedOption = select.options[select.selectedIndex];
            const telefonoInput = document.getElementById('contacto_telefono');
            const dniInput = document.getElementById('contacto_dni');
            const puestoInput = document.getElementById('contacto_puesto');

            if (selectedOption && selectedOption.value) {
                telefonoInput.value = selectedOption.getAttribute('data-telefono') || "";
                dniInput.value = selectedOption.getAttribute('data-dni') || "";
                puestoInput.value = selectedOption.getAttribute('data-puesto') || "";
            } else {
                telefonoInput.value = "";
                dniInput.value = "";
                puestoInput.value = "";
            }
        }

        function toggleContactMode(mode) {
            const sectionExisting = document.getElementById('existing_contact_section');
            const sectionDetails = document.getElementById('contact_details_section');
            const searchInput = document.getElementById('search_contacto');

            if (mode === 'existing') {
                sectionExisting.classList.remove('hidden');
                sectionDetails.classList.add('hidden');
            } else {
                sectionExisting.classList.add('hidden');
                sectionDetails.classList.remove('hidden');
                searchInput.classList.add('hidden'); // Hide search when viewing details
            }
        }

        // Initialize contacts
        window.onload = function() {
            const empresaId = document.getElementById('empresa_id').value;
            if (empresaId) {
                updateContacts(empresaId);
                autoFillContact(document.getElementById('contacto_empresa_id'));
            }
        };
    </script>
</x-app-layout>
