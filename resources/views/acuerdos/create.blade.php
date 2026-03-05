<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Acuerdo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('acuerdos.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Alumno -->
                        <div class="relative">
                            <label for="alumno_id" class="block text-sm font-medium text-gray-700 flex justify-between">
                                <span>Alumno</span>
                                <button type="button" onclick="toggleSearch('search_alumno')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </label>
                            <input type="text" id="search_alumno" onkeyup="filterSelect('search_alumno', 'alumno_id')" placeholder="Buscar alumno..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select name="alumno_id" id="alumno_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona un alumno</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                        {{ $alumno->nombre }} {{ $alumno->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('alumno_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Empresa -->
                        <div class="relative">
                            <label for="empresa_id" class="block text-sm font-medium text-gray-700 flex justify-between">
                                <span>Empresa</span>
                                <button type="button" onclick="toggleSearch('search_empresa')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </label>
                            <input type="text" id="search_empresa" onkeyup="filterSelect('search_empresa', 'empresa_id')" placeholder="Buscar empresa..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select name="empresa_id" id="empresa_id" onchange="updateContacts(this.value)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empresa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                                                    {{ old('contacto_empresa_id') == $contacto->id ? 'selected' : '' }} 
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
                            @error('contacto_empresa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tutor Dual -->
                        <div class="relative md:col-span-1">
                            <label for="tutor_dual_id" class="block text-sm font-medium text-gray-700 flex justify-between">
                                <span>Tutor Dual</span>
                                <button type="button" onclick="toggleSearch('search_tutor')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </label>
                            <input type="text" id="search_tutor" onkeyup="filterSelect('search_tutor', 'tutor_dual_id')" placeholder="Buscar tutor..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select name="tutor_dual_id" id="tutor_dual_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona un tutor</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}" {{ old('tutor_dual_id') == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->nombre }} {{ $tutor->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tutor_dual_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Responsable -->
                        <div class="relative md:col-span-1">
                            <label for="responsable_id" class="block text-sm font-medium text-gray-700 flex justify-between">
                                <span>Responsable</span>
                                <button type="button" onclick="toggleSearch('search_responsable')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </label>
                            <input type="text" id="search_responsable" onkeyup="filterSelect('search_responsable', 'responsable_id')" placeholder="Buscar responsable..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select name="responsable_id" id="responsable_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona un responsable</option>
                                @foreach($responsables as $responsable)
                                    <option value="{{ $responsable->id }}" {{ old('responsable_id') == $responsable->id ? 'selected' : '' }}>
                                        {{ $responsable->nombre }} {{ $responsable->apellidos }} @if($responsable->cargo) ({{ $responsable->cargo }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Localidad -->
                        <div>
                            <label for="localidad" class="block text-sm font-medium text-gray-700">Localidad</label>
                            <input type="text" name="localidad" id="localidad" value="{{ old('localidad') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('localidad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre Acuerdo -->
                        <div>
                            <label for="nombre_acuerdo" class="block text-sm font-medium text-gray-700">Nombre del Acuerdo</label>
                            <input type="text" name="nombre_acuerdo" id="nombre_acuerdo" value="{{ old('nombre_acuerdo') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre_acuerdo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Estado Convenio -->
                        <div>
                            <label for="estado_convenio" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado_convenio" id="estado_convenio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="pendiente" {{ old('estado_convenio') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="hecho_pendiente_firma" {{ old('estado_convenio') == 'hecho_pendiente_firma' ? 'selected' : '' }}>Realizado</option>
                                <option value="firmado" {{ old('estado_convenio') == 'firmado' ? 'selected' : '' }}>Firmado</option>
                            </select>
                            @error('estado_convenio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Horas Totales -->
                        <div>
                            <label for="hours_totales" class="block text-sm font-medium text-gray-700">Horas Totales</label>
                            <input type="number" name="horas_totales" id="horas_totales" value="{{ old('horas_totales') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('horas_totales') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Horario -->
                        <div>
                            <label for="horario" class="block text-sm font-medium text-gray-700">Horario</label>
                            <input type="text" name="horario" id="horario" value="{{ old('horario') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('horario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Grupo -->
                        <div>
                            <label for="grupo" class="block text-sm font-medium text-gray-700">Grupo</label>
                            <input type="text" name="grupo" id="grupo" value="{{ old('grupo') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('grupo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Curso -->
                        <div>
                            <label for="curso" class="block text-sm font-medium text-gray-700">Curso</label>
                            <input type="text" name="curso" id="curso" value="{{ old('curso') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('curso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Año -->
                        <div>
                            <label for="ano" class="block text-sm font-medium text-gray-700">Año</label>
                            <input type="number" name="ano" id="ano" value="{{ old('ano', date('Y')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('ano') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('acuerdos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition duration-150 ease-in-out">
                            Guardar Acuerdo
                        </button>
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

            for (let i = 1; i < options.length; i++) {
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
            select.value = "";
            autoFillContact(select); // Clear auto-fill fields
            
            // Update "Añadir Nuevo" link with current company ID if needed
            if (empresaId) {
                linkNuevo.href = "{{ route('contactos.create') }}?empresa_id=" + empresaId;
            } else {
                linkNuevo.href = "{{ route('contactos.create') }}";
            }

            for (let i = 1; i < options.length; i++) {
                const opt = options[i];
                if (opt.getAttribute('data-empresa') == empresaId || empresaId == "") {
                    opt.classList.remove('hidden');
                    opt.style.display = "";
                } else {
                    opt.classList.add('hidden');
                    opt.style.display = "none";
                }
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

        // Initialize contacts if empresa is already selected (e.g. after validation error)
        window.onload = function() {
            const empresaId = document.getElementById('empresa_id').value;
            if (empresaId) {
                updateContacts(empresaId);
            }
        };
    </script>
</x-app-layout>
