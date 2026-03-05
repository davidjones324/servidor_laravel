<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Contacto de Empresa') }}: {{ $contacto->nombre }} {{ $contacto->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('contactos.update', $contacto) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Empresa -->
                        <div>
                            <label for="empresa_id" class="block text-sm font-medium text-gray-700">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Selecciona una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $contacto->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empresa_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $contacto->nombre) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $contacto->apellidos) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('apellidos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- DNI/CIF -->
                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI/CIF</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni', $contacto->dni) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $contacto->correo) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $contacto->telefono) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Puesto -->
                        <div>
                            <label for="puesto" class="block text-sm font-medium text-gray-700">Puesto</label>
                            <input type="text" name="puesto" id="puesto" value="{{ old('puesto', $contacto->puesto) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('puesto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('contactos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition duration-150 ease-in-out">
                            Actualizar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
