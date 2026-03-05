<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Responsable') }}: {{ $responsable->nombre }} {{ $responsable->apellidos }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 card-ies">
                <form action="{{ route('responsables.update', $responsable) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- DNI -->
                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni', $responsable->dni) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $responsable->nombre) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $responsable->apellidos) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('apellidos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $responsable->email) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $responsable->telefono) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Cargo -->
                        <div>
                            <label for="cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo</label>
                            <input type="text" name="cargo" id="cargo" value="{{ old('cargo', $responsable->cargo) }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">
                            @error('cargo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('responsables.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150">
                            {{ __('Cancelar') }}
                        </a>
                        <button type="submit" class="btn-primary">
                            {{ __('Actualizar Responsable') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
