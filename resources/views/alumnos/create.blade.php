<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Alumno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('alumnos.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('apellidos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- DNI -->
                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI / NIE</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div>
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Curso -->
                        <div>
                            <label for="curso" class="block text-sm font-medium text-gray-700">Curso</label>
                            <input type="text" name="curso" id="curso" value="{{ old('curso', '2025/2026') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('curso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Grupo -->
                        <div>
                            <label for="grupo" class="block text-sm font-medium text-gray-700">Grupo</label>
                            <input type="text" name="grupo" id="grupo" value="{{ old('grupo') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('grupo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Dirección -->
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('alumnos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition duration-150 ease-in-out">
                            Guardar Alumno
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
