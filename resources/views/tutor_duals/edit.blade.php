<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-ies-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Editar Tutor Dual') }}: {{ $tutor->nombre }} {{ $tutor->apellidos }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 card-ies border-t-4 border-ies-green-500">
                <form action="{{ route('tutores.update', $tutor) }}" method="POST" x-data='{ 
                        selectedCursos: @json(old('cursos', $tutor->cursos ?? [])),
                        grupos: @json(old('grupos', is_array($tutor->grupos) ? $tutor->grupos : [])),
                        
                        init() {
                            this.selectedCursos.forEach(curso => {
                                if (!this.grupos[curso]) this.grupos[curso] = [""];
                                if (!Array.isArray(this.grupos[curso])) {
                                    this.grupos[curso] = [this.grupos[curso]];
                                }
                            });
                        },
                        addGrupo(curso) {
                            if (!this.grupos[curso]) this.grupos[curso] = [];
                            this.grupos[curso].push("");
                        },
                        removeGrupo(curso, index) {
                            this.grupos[curso].splice(index, 1);
                            if (this.grupos[curso].length === 0) {
                                this.grupos[curso] = [""];
                            }
                        }
                    }' x-init="init()">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- DNI -->
                        <div>
                            <label for="dni" class="block text-sm font-bold text-gray-700 mb-1">DNI</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni', $tutor->dni) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                            @error('dni') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-bold text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $tutor->nombre) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                            @error('nombre') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="apellidos" class="block text-sm font-bold text-gray-700 mb-1">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $tutor->apellidos) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                            @error('apellidos') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $tutor->email) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                            @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Ciclos -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Ciclos en los que imparte</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @foreach(['ASIR', 'DAM', 'SMR'] as $ciclo)
                                    <label class="relative flex items-center p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                        <input type="checkbox" name="ciclos[]" value="{{ $ciclo }}" 
                                            {{ (is_array(old('ciclos', $tutor->ciclos)) && in_array($ciclo, old('ciclos', $tutor->ciclos))) ? 'checked' : '' }}
                                            class="w-5 h-5 text-ies-green-600 border-gray-300 rounded focus:ring-ies-green-500">
                                        <span class="ml-3 text-sm font-bold text-gray-700">{{ $ciclo }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('ciclos') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Cursos y Grupos Dinámicos -->
                        <div class="md:col-span-2 mt-4">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Cursos y Grupos específicos</label>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach([
                                    '1º ASIR', '2º ASIR',
                                    '1º DAM', '2º DAM',
                                    '1º SMR', '2º SMR'
                                ] as $curso)
                                    <div class="flex items-start space-x-4 p-3 rounded-lg hover:bg-gray-50 transition border border-transparent hover:border-gray-200">
                                        <div class="flex-shrink-0 pt-1">
                                            <label class="flex items-center cursor-pointer min-w-[120px]">
                                                <input type="checkbox" name="cursos[]" value="{{ $curso }}" 
                                                    x-model="selectedCursos"
                                                    class="w-5 h-5 text-ies-green-600 border-gray-300 rounded focus:ring-ies-green-500">
                                                <span class="ml-3 text-sm font-bold text-gray-700">{{ $curso }}</span>
                                            </label>
                                        </div>

                                        <div x-show="selectedCursos.includes('{{ $curso }}')" 
                                             class="flex-1 space-y-2 border-l-2 border-ies-green-200 pl-4">
                                            
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <template x-for="(grupo, index) in (grupos['{{ $curso }}'] || [''])" :key="index">
                                                    <div class="flex items-center space-x-2 bg-white p-1 rounded border border-gray-100 shadow-sm">
                                                        <input type="text" 
                                                            :name="'grupos[' + '{{ $curso }}' + '][]'" 
                                                            x-model="grupos['{{ $curso }}'][index]"
                                                            placeholder="Grupo (A, B...)"
                                                            class="flex-1 text-[10px] border-none focus:ring-0 bg-transparent h-6 p-0 px-1">
                                                        
                                                        <button type="button" @click="removeGrupo('{{ $curso }}', index)" 
                                                            class="text-red-300 hover:text-red-500 transition">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 2 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            <button type="button" @click="addGrupo('{{ $curso }}')" 
                                                class="inline-flex items-center text-[9px] font-bold text-ies-green-600 hover:text-ies-green-700 bg-ies-green-50 px-2 py-0.5 rounded border border-ies-green-100 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                AÑADIR GRUPO
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('cursos') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="md:col-span-2">
                            <label for="telefono" class="block text-sm font-bold text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $tutor->telefono) }}" 
                                class="mt-1 block h-10 w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                            @error('telefono') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('tutores.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancelar</a>
                        <button type="submit" class="btn-secondary">
                            Actualizar Tutor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
