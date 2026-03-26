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
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 bg-ies-blue-50 p-6 rounded-xl border border-ies-blue-100">
                        <p class="md:col-span-4 text-xs text-ies-blue-600 font-semibold uppercase tracking-widest">🔍 Filtros para alumnos, tutores y empresas</p>
                        <!-- Ciclo -->
                        <div>
                            <x-input-label for="ciclo" :value="__('Ciclo')" />
                            <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="filterDependents()">
                                <option value="">Cualquiera</option>
                                <option value="ASIR" {{ old('ciclo') == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                <option value="DAM" {{ old('ciclo') == 'DAM' ? 'selected' : '' }}>DAM</option>
                                <option value="SMR" {{ old('ciclo') == 'SMR' ? 'selected' : '' }}>SMR</option>
                            </select>
                            @error('ciclo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Curso -->
                        <div>
                            <x-input-label for="curso" :value="__('Curso')" />
                            <select id="curso" name="curso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="filterDependents()">
                                <option value="">Cualquiera</option>
                                <option value="1º" {{ old('curso') == '1º' ? 'selected' : '' }}>1º</option>
                                <option value="2º" {{ old('curso') == '2º' ? 'selected' : '' }}>2º</option>
                            </select>
                            @error('curso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Grupo -->
                        <div>
                            <x-input-label for="grupo" :value="__('Grupo')" />
                            <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full" :value="old('grupo')" placeholder="Ej: A" oninput="filterDependents()" />
                            @error('grupo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Año Académico -->
                        <div>
                            @php
                                $month = date('n');
                                $year = date('Y');
                                if ($month < 9) {
                                    $defaultAno = ($year - 1) . '/' . substr($year, -2);
                                } else {
                                    $defaultAno = $year . '/' . substr($year + 1, -2);
                                }
                            @endphp
                            <x-input-label for="ano_academico" :value="__('Año Académico')" />
                            <x-text-input id="ano_academico" name="ano_academico" type="text" class="mt-1 block w-full" :value="old('ano_academico', $defaultAno)" placeholder="Ej: 2024/2025" oninput="filterDependents()" />
                            @error('ano_academico') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

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
                            <select name="alumno_id" id="alumno_id" onchange="updateAlumnoNSS(this)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona un alumno</option>
                                @foreach($alumnos as $alumno)
                                    @php
                                        $latestMatricula = $alumno->matriculas->sortByDesc('anio_academico')->first();
                                    @endphp
                                    <option value="{{ $alumno->id }}" 
                                        data-nss="{{ $alumno->numero_ss }}"
                                        data-ciclo="{{ $latestMatricula ? $latestMatricula->ciclo : '' }}"
                                        data-curso-nivel="{{ $latestMatricula ? $latestMatricula->curso : '' }}"
                                        data-grupo="{{ $latestMatricula ? $latestMatricula->grupo : '' }}"
                                        data-anio-academico="{{ $latestMatricula ? $latestMatricula->anio_academico : '' }}"
                                        {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                        {{ $alumno->nombre }} {{ $alumno->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('alumno_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- NSS del Alumno (Editable si falta) -->
                        <div class="flex flex-col space-y-4">
                            <div>
                                <label for="numero_ss" class="block text-sm font-medium text-gray-700">Número Seguridad Social Alumno</label>
                                <input type="text" name="numero_ss" id="numero_ss" value="{{ old('numero_ss') }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Selecciona un alumno para ver su NSS...">
                                <p id="nss_warning" class="hidden text-[10px] text-red-500 font-bold uppercase mt-1">⚠️ El alumno no tiene NSS. Puedes añadirlo ahora.</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="tiene_seguro" id="tiene_seguro" value="1" {{ old('tiene_seguro') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="tiene_seguro" class="text-sm font-medium text-gray-700">Tiene seguro escolar (snapshot para este acuerdo)</label>
                            </div>
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
                                    <option value="{{ $empresa->id }}" 
                                        data-ciclos="{{ implode(',', $empresa->ciclos ?? []) }}"
                                        {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empresa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tutor Laboral -->
                        <div class="relative md:col-span-2">
                            <label for="contacto_empresa_id" class="block text-sm font-medium text-gray-700 flex justify-between">
                                <span>Tutor Laboral</span>
                                <button type="button" onclick="toggleSearch('search_contacto')" class="text-gray-400 hover:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </label>
                            <input type="text" id="search_contacto" onkeyup="filterSelect('search_contacto', 'contacto_empresa_id')" placeholder="Buscar tutor laboral..." class="hidden mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm mb-1">
                            <select name="contacto_empresa_id" id="contacto_empresa_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona un tutor laboral</option>
                                @foreach($empresas as $empresa)
                                    @foreach($empresa->contactos as $contacto)
                                        <option value="{{ $contacto->id }}" 
                                            data-empresa="{{ $empresa->id }}" 
                                            {{ old('contacto_empresa_id') == $contacto->id ? 'selected' : '' }} 
                                            class="hidden">
                                            {{ $contacto->nombre }} {{ $contacto->apellidos }} - {{ $contacto->telefono }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
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
                                    <option value="{{ $tutor->id }}" 
                                        data-ciclos="{{ json_encode($tutor->ciclos) }}"
                                        data-cursos="{{ json_encode($tutor->cursos) }}"
                                        data-grupos="{{ json_encode($tutor->grupos) }}"
                                        {{ old('tutor_dual_id') == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->nombre }} {{ $tutor->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tutor_dual_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

                        <!-- Estado -->
                        <div>
                            <x-input-label for="estado_id" :value="__('Estado')" />
                            <select name="estado_id" id="estado_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
            const selectContacto = document.getElementById('contacto_empresa_id');
            
            selectContacto.value = "";
            
            Array.from(selectContacto.options).forEach((opt, i) => {
                if (i === 0) return;
                if (opt.getAttribute('data-empresa') == empresaId || empresaId == "") {
                    opt.classList.remove('hidden');
                    opt.style.display = "";
                } else {
                    opt.classList.add('hidden');
                    opt.style.display = "none";
                }
            });
        }

        function updateAlumnoNSS(select) {
            const selectedOption = select.options[select.selectedIndex];
            const nssInput = document.getElementById('numero_ss');
            const nssWarning = document.getElementById('nss_warning');
            
            if (selectedOption && selectedOption.value) {
                const nss = selectedOption.getAttribute('data-nss');
                nssInput.value = nss || "";
                
                if (nss) {
                    nssInput.readOnly = true;
                    nssInput.classList.add('bg-gray-50');
                    nssWarning.classList.add('hidden');
                } else {
                    nssInput.readOnly = false;
                    nssInput.classList.remove('bg-gray-50');
                    nssWarning.classList.remove('hidden');
                }
            } else {
                nssInput.value = "";
                nssInput.readOnly = false;
                nssInput.classList.remove('bg-gray-50');
                nssWarning.classList.add('hidden');
            }
        }


        function filterDependents(resetSelections = true) {
            const cycle = document.getElementById('ciclo').value.toLowerCase();
            const course = document.getElementById('curso').value;
            const group = document.getElementById('grupo').value.toLowerCase();
            const anio = document.getElementById('ano_academico').value.toLowerCase();

            if (resetSelections) {
                document.getElementById('alumno_id').value = "";
                document.getElementById('empresa_id').value = "";
                document.getElementById('contacto_empresa_id').value = "";
                document.getElementById('tutor_dual_id').value = "";
                document.getElementById('numero_ss').value = "";
                document.getElementById('nss_warning').classList.add('hidden');
            }

            // Filter Alumnos by ciclo, curso, grupo, anio_academico
            const selectAlumno = document.getElementById('alumno_id');
            Array.from(selectAlumno.options).forEach((opt, i) => {
                if (i === 0) return;
                const optCycle = (opt.getAttribute('data-ciclo') || "").toLowerCase();
                const optCourseNivel = opt.getAttribute('data-curso-nivel') || "";
                const optGroup = (opt.getAttribute('data-grupo') || "").toLowerCase();
                const optAnioAA = (opt.getAttribute('data-anio-academico') || "").toLowerCase();

                const matchCycle = !cycle || optCycle.includes(cycle);
                // Normaliza "1º" o "2º" para comparar con "1" o "2"
                const normalizedCourse = course.replace('º', '');
                const matchCourse = !course || optCourseNivel.toString() === normalizedCourse;
                
                const matchGroup = !group || optGroup.includes(group);
                const matchAnio = !anio || optAnioAA.includes(anio);

                opt.style.display = (matchCycle && matchCourse && matchGroup && matchAnio) ? "" : "none";
            });

            // Filter Tutores by ciclo, curso, grupo
            const selectTutor = document.getElementById('tutor_dual_id');
            Array.from(selectTutor.options).forEach((opt, i) => {
                if (i === 0) return;
                let matches = true;

                if (cycle) {
                    const optCiclos = JSON.parse(opt.getAttribute('data-ciclos') || "[]");
                    matches = matches && optCiclos.some(c => c.toLowerCase().includes(cycle));
                }
                if (course) {
                    const optCursos = JSON.parse(opt.getAttribute('data-cursos') || "[]");
                    matches = matches && optCursos.includes(course);
                }
                if (group) {
                    const optGrupos = JSON.parse(opt.getAttribute('data-grupos') || "[]");
                    matches = matches && optGrupos.some(g => g.toLowerCase().includes(group));
                }

                opt.style.display = matches ? "" : "none";
            });

            // Filter Empresas by ciclo
            const selectEmpresa = document.getElementById('empresa_id');
            Array.from(selectEmpresa.options).forEach((opt, i) => {
                if (i === 0) return;
                if (!cycle) {
                    opt.style.display = "";
                    return;
                }
                const optCiclos = (opt.getAttribute('data-ciclos') || "").toLowerCase();
                opt.style.display = optCiclos.includes(cycle) ? "" : "none";
            });
        }

        window.onload = function() {
            const empresaId = document.getElementById('empresa_id').value;
            if (empresaId) {
                updateContacts(empresaId);
            }
            filterDependents(false);
        };
    </script>
</x-app-layout>
