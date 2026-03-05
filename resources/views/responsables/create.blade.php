<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Responsable') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 card-ies border-t-4 border-ies-blue-600">
                <form action="{{ route('responsables.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- DNI -->
                        <div>
                            <label for="dni" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">DNI / Identificación</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni') }}" 
                                placeholder="Ej: 12345678X"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('dni') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('nombre') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="apellidos" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('apellidos') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                placeholder="coordinador@instituto.com"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('telefono') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Cargo -->
                        <div>
                            <label for="cargo" class="block text-sm font-bold text-gray-700 mb-1 italic tracking-wide">Cargo en el Centro</label>
                            <input type="text" name="cargo" id="cargo" value="{{ old('cargo') }}" 
                                placeholder="Ej: Jefe de Estudios, Director..."
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm transition duration-200">
                            @error('cargo') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('responsables.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="btn-primary shadow-lg shadow-ies-blue-600/20">
                            {{ __('Registrar Responsable') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
