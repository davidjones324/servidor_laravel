<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-ies-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">📄</span>
                </div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Gestión de Acuerdos') }}
                </h2>
            </div>
            <a href="{{ route('acuerdos.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Acuerdo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body">
                    <!-- Quick Creation Bar (DataGrid) -->
                    <div x-data="quickAcuerdo()" x-init="init()" class="mb-8 p-6 bg-ies-blue-50 rounded-xl border border-ies-blue-100 shadow-sm">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-8 h-8 bg-ies-blue-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                +
                            </div>
                            <h3 class="font-bold text-gray-800 uppercase tracking-wider text-sm">Creación Rápida de Acuerdo</h3>
                            <div class="ml-auto flex items-center space-x-2">
                                <template x-if="loadStatus === 'Cargando datos...'">
                                    <span class="text-[10px] text-ies-blue-600 animate-pulse font-bold">CARGANDO...</span>
                                </template>
                                <template x-if="loadStatus === 'Error'">
                                    <span class="text-[10px] text-red-600 font-bold" x-text="'ERROR: ' + errorMessage"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Bloque de Filtros -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 p-4 bg-white/50 rounded-lg border border-ies-blue-100/50">
                            <div>
                                <label class="block text-[10px] font-bold text-ies-blue-600 uppercase mb-1">Filtrar por Ciclo</label>
                                <select x-model="filterCiclo" @change="resetSelection()" class="w-full text-xs border-gray-200 rounded-lg focus:ring-ies-blue-500 focus:border-ies-blue-500 bg-white">
                                    <option value="">Todos los ciclos</option>
                                    <template x-for="ciclo in ['DAM', 'ASIR', 'SMR']" :key="ciclo">
                                        <option :value="ciclo" x-text="ciclo"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-ies-blue-600 uppercase mb-1">Filtrar por Curso</label>
                                <select x-model="filterCurso" @change="resetSelection()" class="w-full text-xs border-gray-200 rounded-lg focus:ring-ies-blue-500 focus:border-ies-blue-500 bg-white">
                                    <option value="">Todos los cursos</option>
                                    <template x-for="curso in ['1º', '2º']" :key="curso">
                                        <option :value="curso" x-text="curso"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-ies-blue-600 uppercase mb-1">Filtrar por Grupo</label>
                                <div class="flex space-x-2 relative">
                                    <input type="text" x-model="filterGrupo" @input="resetSelection()" 
                                        :placeholder="hasGroups ? 'Ej: A, B...' : 'No hay grupos'" 
                                        :readonly="!hasGroups && filterCiclo && filterCurso"
                                        class="w-full text-xs border-gray-200 rounded-lg focus:ring-ies-blue-500 focus:border-ies-blue-500 bg-white"
                                        :class="!hasGroups && filterCiclo && filterCurso ? 'bg-gray-100 italic text-gray-400' : ''">
                                </div>
                                <template x-if="!hasGroups && filterCiclo && filterCurso">
                                    <p class="text-[9px] text-amber-600 font-bold mt-1">⚠️ No se han detectado subgrupos para este curso.</p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-ies-blue-600 uppercase mb-1">Filtrar por Año Académico</label>
                                <div class="flex space-x-2 relative">
                                    <input type="text" x-model="filterAno" @input="resetSelection()" 
                                        placeholder="Ej: 2023/24" 
                                        class="w-full text-xs border-gray-200 rounded-lg focus:ring-ies-blue-500 focus:border-ies-blue-500 bg-white">
                                    <button @click="init()" class="bg-ies-blue-600 hover:bg-ies-blue-700 text-white p-2 rounded-lg transition-colors shadow-sm" title="Actualizar Datos">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-4 items-end">
                            <!-- Alumno -->
                            <div class="relative">
                                <label class="block text-[10px] font-black text-blue-700 uppercase mb-1 tracking-wider">Filtrar por Alumno (<span x-text="filteredAlumnos.length"></span>)</label>
                                <select x-model="selectedAlumnoId" @change="onAlumnoChange()" 
                                    class="w-full text-xs font-bold border-gray-200 rounded-lg focus:ring-2 focus:ring-ies-blue-500/20 focus:border-ies-blue-500 py-2.5 shadow-sm"
                                    :class="getAlumnoClass()">
                                    <option value="">Seleccionar alumno...</option>
                                    <template x-for="alumno in filteredAlumnos" :key="alumno.id">
                                        <option :value="alumno.id" 
                                            :class="alumno.has_agreement ? 'text-green-600' : 'text-slate-800'"
                                            x-text="alumno.nombre + (alumno.incompleto ? ' (⚠️)' : '')">
                                        </option>
                                    </template>
                                </select>
                            </div>

                            <!-- Empresa -->
                            <div>
                                <label class="block text-[10px] font-black text-blue-700 uppercase mb-1 tracking-wider">2. Empresa Sugerida</label>
                                <select x-model="selectedEmpresaId" @change="onSelectionChange()"
                                    class="w-full text-xs font-semibold border-gray-200 rounded-lg focus:ring-2 focus:ring-ies-blue-500/20 focus:border-ies-blue-500 py-2.5 shadow-sm">
                                    <option value="">Empresa...</option>
                                    <template x-for="empresa in filteredEmpresas" :key="empresa.id">
                                        <option :value="empresa.id" x-text="empresa.razon_social"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Tutor Dual -->
                            <div>
                                <label class="block text-[10px] font-black text-blue-700 uppercase mb-1 tracking-wider">3. Tutor Dual</label>
                                <select x-model="selectedTutorId" @change="onSelectionChange()"
                                    class="w-full text-xs font-semibold border-gray-200 rounded-lg focus:ring-2 focus:ring-ies-blue-500/20 focus:border-ies-blue-500 py-2.5 shadow-sm">
                                    <option value="">Tutor Dual...</option>
                                    <template x-for="tutor in filteredTutores" :key="tutor.id">
                                        <option :value="tutor.id" x-text="tutor.nombre"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Acción Individual -->
                            <div>
                                <button @click="submit()" 
                                    :disabled="isSubmitting || !canSubmit"
                                    class="w-full py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all transform active:scale-95 shadow-lg border-2"
                                    :class="{
                                        'bg-blue-600 hover:bg-blue-700 text-white border-blue-700 shadow-blue-100': canSubmit && !isSubmitting,
                                        'bg-slate-200 text-slate-600 border-slate-300 cursor-not-allowed opacity-75': !canSubmit || isSubmitting
                                    }">
                                    <span x-text="isSubmitting ? 'GUARDANDO...' : (canSubmit ? 'CREAR ACUERDO' : 'FALTAN DATOS')"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Rejilla de Datos (Excel-like) -->
                        <div x-show="filterCiclo || filterCurso || filterGrupo" class="mt-8 pt-10 border-t-2 border-ies-blue-50 w-full" x-cloak>
                                <!-- CABECERA DE RESULTADOS (CLEAN TABLE BAR) -->
                                <div class="w-full bg-ies-blue-600 rounded-2xl shadow-lg mb-6 overflow-hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 items-center py-5">
                                                <div class="text-[11px] font-black text-white uppercase tracking-widest">Alumnos (<span x-text="filteredAlumnos.length"></span>)</div>
                                                <div class="text-[11px] font-black text-white uppercase tracking-widest">Empresa Destino</div>
                                                <div class="text-[11px] font-black text-white uppercase tracking-widest">Tutor Dual</div>
                                                <div class="text-[11px] font-black text-white uppercase tracking-widest text-center">Acción</div>
                                            </div>
                                        </div>

                                        <!-- FILA DE CREACIÓN MASIVA (1 FILA POR ALUMNO) -->
                                        <div class="w-full space-y-2">
                                            <template x-for="alumno in filteredAlumnos" :key="alumno.id">
                                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 md:hover:border-ies-blue-200 transition-all duration-300 w-full group relative overflow-visible">
                                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 items-center py-2.5 min-h-[60px]">
                                                        
                                                        <!-- 1. Alumno -->
                                                        <div class="flex items-center h-full">
                                                            <div class="flex flex-col">
                                                                <span class="text-[11px] font-bold text-slate-700 leading-tight" x-text="alumno.nombre + ' ' + alumno.apellidos"></span>
                                                                <template x-if="alumno.incompleto">
                                                                    <div class="flex items-center space-x-1 mt-0.5">
                                                                        <span class="text-[8px] text-red-500 font-extrabold uppercase tracking-tighter italic">NSS/Seguro Pendiente</span>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>

                                                        <!-- 2. Empresa -->
                                                        <div class="h-full flex items-center">
                                                            <select x-model="alumno.form_empresa" :disabled="alumno.has_agreement"
                                                                class="w-full text-[11px] font-semibold border-gray-100 bg-slate-50 rounded-lg py-2 focus:ring-2 focus:ring-ies-blue-500/20 focus:border-ies-blue-500 transition-all disabled:opacity-50">
                                                                <option value="">Empresa...</option>
                                                                <template x-for="emp in filteredEmpresas" :key="emp.id">
                                                                    <option :value="emp.id" x-text="emp.razon_social"></option>
                                                                </template>
                                                            </select>
                                                        </div>

                                                        <!-- 3. Tutor -->
                                                        <div class="h-full flex items-center">
                                                            <select x-model="alumno.form_tutor" :disabled="alumno.has_agreement"
                                                                class="w-full text-[11px] font-semibold border-gray-100 bg-slate-50 rounded-lg py-2 focus:ring-2 focus:ring-ies-blue-500/20 focus:border-ies-blue-500 transition-all disabled:opacity-50">
                                                                <option value="">Tutor...</option>
                                                                <template x-for="tut in filteredTutores" :key="tut.id">
                                                                    <option :value="tut.id" x-text="tut.nombre"></option>
                                                                </template>
                                                            </select>
                                                        </div>

                                                        <!-- 4. Acción (Status / Crear) -->
                                                        <div class="flex items-center justify-center h-full">
                                                            <button 
                                                                @click="createIndividualBulk(alumno)"
                                                                x-show="!alumno.has_agreement"
                                                                :disabled="!alumno.form_empresa || !alumno.form_tutor || isSubmitting"
                                                                class="w-full py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all shadow-md border-2"
                                                                :class="{
                                                                    'bg-blue-600 hover:bg-blue-700 text-white border-blue-700 shadow-blue-100': alumno.form_empresa && alumno.form_tutor && !isSubmitting,
                                                                    'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed': !alumno.form_empresa || !alumno.form_tutor || isSubmitting
                                                                }">
                                                                <span class="drop-shadow-sm" x-text="(!alumno.form_empresa || !alumno.form_tutor) ? 'Faltan Datos' : 'Crear Acuerdo'"></span>
                                                            </button>
                                                            <div x-show="alumno.has_agreement" class="w-full flex items-center justify-center">
                                                                <span class="text-[9px] font-black text-green-700 bg-green-100 px-4 py-1.5 rounded-full border-2 border-green-300 uppercase tracking-widest shadow-sm">CREADO</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>
                                            
                                            <template x-if="filteredAlumnos.length === 0">
                                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 py-8 text-center text-sm font-semibold text-gray-400">
                                                    No hay alumnos que coincidan con los filtros seleccionados.
                                                </div>
                                            </template>
                                        </div>

                                        <!-- BOTÓN GUARDAR ACUERDOS MASIVO -->
                                        <div class="mt-8 flex justify-end">
                                            <button @click="createAllBulk()"
                                                :disabled="isSubmitting || filteredAlumnos.filter(a => !a.has_agreement && a.form_empresa && a.form_tutor).length === 0"
                                                class="py-4 px-12 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-2xl transform active:scale-95 flex items-center justify-center space-x-3 border-4"
                                                :class="{
                                                    'bg-blue-600 hover:bg-blue-700 text-white border-blue-700 shadow-blue-200': !isSubmitting && filteredAlumnos.filter(a => !a.has_agreement && a.form_empresa && a.form_tutor).length > 0,
                                                    'bg-slate-300 text-slate-600 border-slate-400 cursor-not-allowed': isSubmitting || filteredAlumnos.filter(a => !a.has_agreement && a.form_empresa && a.form_tutor).length === 0
                                                }">
                                                <template x-if="isSubmitting">
                                                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                </template>
                                                <svg x-show="!isSubmitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                                <span x-text="isSubmitting ? 'GUARDANDO...' : 'GUARDAR TODOS LOS ACUERDOS'"></span>
                                            </button>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>

                <script>
                        function quickAcuerdo() {
                            return {
                                options: { ciclos: [], cursos: [], grupos: [] },
                                filterCiclo: '',
                                filterCurso: '',
                                filterAno: '',
                                globalEmpresa: '',
                                globalTutor: '',
                                alumnos: [],
                                empresas: [],
                                tutores: [],
                                selectedAlumnoId: '',
                                selectedEmpresaId: '',
                                selectedTutorId: '',
                                selectedAlumno: null,
                                selectedEmpresa: null,
                                isSubmitting: false,
                                loadStatus: 'Iniciando...',
                                errorMessage: '',

                                init() {
                                    this.loadData();
                                },

                                async loadData() {
                                    try {
                                        this.loadStatus = 'Cargando datos...';
                                        this.errorMessage = '';
                                        const url = "{{ route('acuerdos.quick.data', [], false) }}";
                                        console.log('Fetching from URL:', url);
                                        const response = await fetch(url);
                                        
                                        if (!response.ok) {
                                            throw new Error('Error HTTP: ' + response.status + ' ' + response.statusText);
                                        }

                                        const data = await response.json();
                                        console.log('Data received:', data);
                                        this.empresas = data.empresas || [];
                                        this.tutores = data.tutores || [];
                                        this.options = data.options || { ciclos: [], cursos: [], grupos: [] };

                                        this.alumnos = (data.alumnos || []).map(a => {
                                            let temp_empresa = '';
                                            
                                            // Pre-asignar empresa sugerida
                                            if (!a.acuerdos_count) {
                                                // 1. Por interés en el formulario
                                                if (a.empresa_deseada) {
                                                    const desired = (data.empresas || []).find(e => 
                                                        e.razon_social.toLowerCase().includes(a.empresa_deseada.toLowerCase())
                                                    );
                                                    if (desired) temp_empresa = desired.id;
                                                }
                                                
                                                // 2. Por localidad si no hay match anterior
                                                if (!temp_empresa) {
                                                    const locs = [a.localidad, a.residencia, a.segunda_residencia].filter(l => l);
                                                    const nearby = (data.empresas || []).find(e => 
                                                        locs.some(l => e.localidad && e.localidad.toLowerCase().includes(l.toLowerCase()))
                                                    );
                                                    if (nearby) temp_empresa = nearby.id;
                                                }
                                            }

                                            return {
                                                ...a,
                                                nombre: a.nombre || '',
                                                apellidos: a.apellidos || '',
                                                form_empresa: temp_empresa,
                                                form_tutor: '',
                                                seguro_escolar: a.seguro_escolar || false,
                                                numero_ss: a.numero_ss || '',
                                                has_agreement: a.acuerdos_count > 0
                                            };
                                        });

                                        this.loadStatus = 'Listo';
                                        console.log('State updated. Alumnos:', this.alumnos.length);
                                    } catch (error) {
                                        console.error('Error loading quick agreement data:', error);
                                        this.loadStatus = 'Error';
                                        this.errorMessage = error.message;
                                    }
                                },

                                get filteredAlumnos() {
                                    if (!this.alumnos) return [];
                                    return this.alumnos.filter(a => {
                                        const matchCiclo = !this.filterCiclo || (a.ciclo && a.ciclo.toUpperCase().includes(this.filterCiclo.toUpperCase()));
                                        
                                        const targetYear = this.filterCurso === '1º' ? 1 : (this.filterCurso === '2º' ? 2 : null);
                                        const matchCurso = !this.filterCurso || (a.anio_ciclo == targetYear);
                                        
                                        const matchGrupo = !this.filterGrupo || (a.grupo && a.grupo.toLowerCase().includes(this.filterGrupo.toLowerCase()));
                                        
                                        const matchAno = !this.filterAno || (a.curso && a.curso.toLowerCase().includes(this.filterAno.toLowerCase()));
                                        
                                        return matchCiclo && matchCurso && matchGrupo && matchAno;
                                    });
                                },

                                get filteredEmpresas() {
                                    if (!this.empresas) return [];
                                    const search = this.filterCiclo ? this.filterCiclo.toUpperCase() : '';
                                    return this.empresas.filter(e => {
                                        if (!search) return true;
                                        if (!e.ciclos) return false;
                                        // Aceptamos si el ciclo está en el array de la empresa
                                        return e.ciclos.some(c => c && c.toUpperCase().includes(search));
                                    });
                                },

                                get filteredTutores() {
                                    if (!this.tutores) return [];
                                    return this.tutores.filter(t => {
                                        const matchCiclo = !this.filterCiclo || (t.ciclos && t.ciclos.some(c => c.toUpperCase().includes(this.filterCiclo.toUpperCase())));
                                        
                                        const matchCurso = !this.filterCurso || (t.cursos && t.cursos.some(c => c.toUpperCase().startsWith(this.filterCurso.toUpperCase())));
                                        
                                        let matchGrupo = true;
                                        if (this.filterGrupo) {
                                            const searchLower = this.filterGrupo.toLowerCase();
                                            const fullCourse = t.cursos ? t.cursos.find(c => 
                                                c.toUpperCase().startsWith(this.filterCurso.toUpperCase()) && 
                                                c.toUpperCase().includes(this.filterCiclo?.toUpperCase() || '')
                                            ) : null;
                                            
                                            const courseGroups = t.grupos ? t.grupos[fullCourse || ''] : null;
                                            if (courseGroups) {
                                                if (Array.isArray(courseGroups)) {
                                                    matchGrupo = courseGroups.some(g => g && g.toLowerCase().includes(searchLower));
                                                } else {
                                                    matchGrupo = courseGroups.toLowerCase().includes(searchLower);
                                                }
                                            } else {
                                                matchGrupo = false;
                                            }
                                        }
                                        
                                        return matchCiclo && matchCurso && matchGrupo;
                                    });
                                },

                                get hasGroups() {
                                    if (!this.filterCiclo || !this.filterCurso) return true;
                                    const targetYear = this.filterCurso === '1º' ? 1 : (this.filterCurso === '2º' ? 2 : null);
                                    const alumnosDelCurso = this.alumnos.filter(a => 
                                        (a.ciclo && a.ciclo.toUpperCase().includes(this.filterCiclo.toUpperCase())) &&
                                        (a.anio_ciclo == targetYear)
                                    );
                                    return alumnosDelCurso.some(a => a.grupo && a.grupo.trim() !== '');
                                },

                                calculateAcademicYear() {
                                    const now = new Date();
                                    const month = now.getMonth() + 1; // 1-12
                                    const year = now.getFullYear();
                                    if (month < 9) {
                                        return (year - 1) + '/' + String(year).slice(-2);
                                    }
                                    return year + '/' + String(year + 1).slice(-2);
                                },

                                resetSelection() {
                                    this.selectedAlumnoId = '';
                                    this.selectedEmpresaId = '';
                                    this.selectedTutorId = '';
                                    this.selectedAlumno = null;
                                    this.selectedEmpresa = null;
                                    
                                    // Reset de los campos en la rejilla de los alumnos filtrados
                                    this.alumnos.forEach(a => {
                                        a.form_empresa = '';
                                        a.form_tutor = '';
                                    });
                                },

                                get canSubmit() {
                                    return this.selectedAlumnoId && this.selectedEmpresaId && this.selectedTutorId;
                                },

                                onAlumnoChange() {
                                    this.selectedAlumno = this.alumnos.find(a => a.id == this.selectedAlumnoId);
                                    
                                    // Sugerir empresa si el alumno ya tiene acuerdos previos (opcional)
                                    // o si hay alguna lógica de asignación automática pendiente.
                                    
                                    this.onSelectionChange();
                                },

                                onSelectionChange() {
                                    this.selectedEmpresa = this.empresas.find(e => e.id == this.selectedEmpresaId);
                                    
                                    // Si la empresa tiene contactos, informar (la UI ya los usa en el backend store)
                                    if (this.selectedEmpresa && this.selectedEmpresa.contactos && this.selectedEmpresa.contactos.length > 0) {
                                        console.log('Contacto sugerido:', this.selectedEmpresa.contactos[0].nombre);
                                    }
                                },

                                getAlumnoClass() {
                                    if (!this.selectedAlumno) return 'border-gray-200';
                                    if (this.selectedAlumno.incompleto) return 'border-red-500 text-red-700 bg-red-50';
                                    return 'border-gray-200';
                                },

                                async submit() {
                                    if (!this.canSubmit) return;
                                    this.isSubmitting = true;
                                    try {
                                        const url = "{{ route('acuerdos.quick.store', [], false) }}";
                                        const response = await fetch(url, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                alumno_id: this.selectedAlumnoId,
                                                empresa_id: this.selectedEmpresaId,
                                                tutor_dual_id: this.selectedTutorId,
                                                ano_academico: this.filterAno || null
                                            })
                                        });
                                        const result = await response.json();
                                        if (result.success) {
                                            window.location.href = result.redirect;
                                        } else {
                                            alert(result.error || 'Error al crear el acuerdo');
                                            this.isSubmitting = false;
                                        }
                                    } catch (e) {
                                        console.error(e);
                                        this.isSubmitting = false;
                                    }
                                },

                                async updateStudentStatus(alumno) {
                                    try {
                                        const url = "{{ route('acuerdos.alumno.status', ':id') }}".replace(':id', alumno.id);
                                        await fetch(url, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                numero_ss: alumno.numero_ss,
                                                seguro_escolar: alumno.seguro_escolar ? 1 : 0
                                            })
                                        });
                                        // Actualizar en la lista principal para que la rejilla también lo vea
                                        const idx = this.alumnos.findIndex(a => a.id === alumno.id);
                                        if (idx !== -1) {
                                            this.alumnos[idx].incompleto = !alumno.numero_ss || !alumno.seguro_escolar;
                                        }
                                    } catch (e) {
                                        console.error('Error updating student:', e);
                                    }
                                },

                                toggleSeguro(alumno) {
                                    alumno.seguro_escolar = !alumno.seguro_escolar;
                                    this.updateStudentStatus(alumno);
                                },

                                async createAllBulk() {
                                    const payload = this.filteredAlumnos
                                        .filter(a => !a.has_agreement && a.form_empresa && a.form_tutor)
                                        .map(a => ({
                                            alumno_id: a.id,
                                            empresa_id: a.form_empresa,
                                            tutor_dual_id: a.form_tutor,
                                            ano_academico: this.filterAno || null
                                        }));

                                    if (payload.length === 0) {
                                        alert('No hay alumnos válidos con opciones seleccionadas.');
                                        return;
                                    }

                                    this.isSubmitting = true;
                                    try {
                                        const response = await fetch("{{ route('acuerdos.quick.bulk', [], false) }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({ acuerdos: payload })
                                        });
                                        const result = await response.json();
                                        if (result.success) {
                                            alert(result.message);
                                            window.location.reload();
                                        } else {
                                            alert(result.error || 'Error en creación masiva');
                                        }
                                    } catch (e) {
                                        console.error(e);
                                    } finally {
                                        this.isSubmitting = false;
                                    }
                                },

                                async createIndividualBulk(alumno) {
                                    if (!alumno.form_empresa || !alumno.form_tutor) return;
                                    this.isSubmitting = true;
                                    try {
                                        const response = await fetch("{{ route('acuerdos.quick.store', [], false) }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                alumno_id: alumno.id,
                                                empresa_id: alumno.form_empresa,
                                                tutor_dual_id: alumno.form_tutor,
                                                ano_academico: this.filterAno || null
                                            })
                                        });
                                        const result = await response.json();
                                        if (result.success) {
                                            alumno.has_agreement = true;
                                            alert('Acuerdo creado correctamente');
                                        } else {
                                            alert(result.error || 'Error al crear el acuerdo');
                                        }
                                    } catch (e) {
                                        console.error(e);
                                    } finally {
                                        this.isSubmitting = false;
                                    }
                                }
                            }
                        }
                    </script>


                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <button onclick="document.getElementById('filter-bar').classList.toggle('hidden')" class="p-2 text-gray-400 hover:text-ies-blue-600 transition-colors" title="Filtrar">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>

                        <div id="filter-bar" class="{{ request()->anyFilled(['search', 'ciclo', 'estado_id', 'ano_academico', 'curso', 'grupo']) ? '' : 'hidden' }} bg-gray-50 p-4 rounded-lg border border-gray-100 mb-4">
                            <form action="{{ route('acuerdos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                <div>
                                    <x-input-label for="search" :value="__('Nombre del Acuerdo')" />
                                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Empieza por..." />
                                </div>
                                <div>
                                    <x-input-label for="ciclo" :value="__('Ciclo')" />
                                    <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="ASIR" {{ request('ciclo') == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                        <option value="DAM" {{ request('ciclo') == 'DAM' ? 'selected' : '' }}>DAM</option>
                                        <option value="SMR" {{ request('ciclo') == 'SMR' ? 'selected' : '' }}>SMR</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="estado_id" :value="__('Estado')" />
                                    <select id="estado_id" name="estado_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id }}" {{ request('estado_id') == $estado->id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="ano_academico" :value="__('Año Académico')" />
                                    <x-text-input id="ano_academico" name="ano_academico" type="text" class="mt-1 block w-full" :value="request('ano_academico')" placeholder="Ej: 2023/24" />
                                </div>
                                <div>
                                    <x-input-label for="curso" :value="__('Curso')" />
                                    <select id="curso" name="curso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Todos</option>
                                        <option value="1º" {{ request('curso') == '1º' ? 'selected' : '' }}>1º</option>
                                        <option value="2º" {{ request('curso') == '2º' ? 'selected' : '' }}>2º</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="grupo" :value="__('Grupo')" />
                                    <x-text-input id="grupo" name="grupo" type="text" class="mt-1 block w-full" :value="request('grupo')" placeholder="Ej: A" />
                                </div>
                                <div class="md:col-span-6 flex justify-end space-x-2">
                                    <x-primary-button type="submit">
                                        {{ __('Aplicar Filtros') }}
                                    </x-primary-button>
                                    @if(request()->anyFilled(['search', 'estado_id', 'ano_academico', 'curso', 'grupo']))
                                        <a href="{{ route('acuerdos.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('Limpiar') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="table-header">
                                <tr>
                                    <th>Acuerdo</th>
                                    <th>Alumno</th>
                                    <th>Empresa</th>
                                    <th>Curso / Grupo</th>
                                    <th>Año Académico</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($acuerdos as $acuerdo)
                                    <tr class="hover:bg-ies-blue-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $acuerdo->nombre_acuerdo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div class="font-medium">{{ $acuerdo->alumno->nombre }} {{ $acuerdo->alumno->apellidos }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $acuerdo->ciclo }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acuerdo->empresa->razon_social }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div><span class="font-bold">{{ $acuerdo->curso }}</span> - <span class="text-gray-400">{{ $acuerdo->grupo }}</span></div>
                                            @if($acuerdo->ciclo)
                                                <div class="text-[10px] text-ies-blue-500 font-semibold uppercase">{{ $acuerdo->ciclo }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acuerdo->ano_academico }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $estadoName = $acuerdo->estado?->nombre ?? 'Pendiente';
                                                $estadoClasses = match(strtolower($estadoName)) {
                                                    'firmado' => 'bg-ies-green-100 text-ies-green-700',
                                                    'realizado' => 'bg-ies-blue-100 text-ies-blue-700',
                                                    default => 'bg-amber-100 text-amber-700',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoClasses }}">
                                                {{ $estadoName }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                            <div class="flex justify-end space-x-3">
                                                <a href="{{ route('acuerdos.show', $acuerdo) }}" class="text-ies-blue-600 hover:text-ies-blue-800 font-medium">Ver</a>
                                                <a href="{{ route('acuerdos.edit', $acuerdo) }}" class="text-ies-green-600 hover:text-ies-green-800 font-medium">Editar</a>
                                                <form action="{{ route('acuerdos.destroy', $acuerdo) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este acuerdo?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">
                                            <div class="flex flex-col items-center">
                                                <span class="text-3xl mb-2">📋</span>
                                                <span>No hay acuerdos registrados.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $acuerdos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
