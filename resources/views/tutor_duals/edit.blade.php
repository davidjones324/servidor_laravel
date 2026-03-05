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
                <form action="{{ route('tutores.update', $tutor) }}" method="POST">
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

                        <!-- Ciclo -->
                        <div>
                            <label for="ciclo" class="block text-sm font-bold text-gray-700 mb-1">Ciclo</label>
                            <select name="ciclo" id="ciclo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
                                <option value="ASIR" {{ old('ciclo', $tutor->ciclo) == 'ASIR' ? 'selected' : '' }}>ASIR</option>
                                <option value="SMR" {{ old('ciclo', $tutor->ciclo) == 'SMR' ? 'selected' : '' }}>SMR</option>
                                <option value="DAM" {{ old('ciclo', $tutor->ciclo) == 'DAM' ? 'selected' : '' }}>DAM</option>
                            </select>
                            @error('ciclo') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-bold text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $tutor->telefono) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-green-500 focus:ring-ies-green-500 sm:text-sm">
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
