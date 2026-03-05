<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de la Empresa') }}
            </h2>
            <a href="{{ route('empresas.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Volver al listado</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="border-b pb-4 mb-4 flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $empresa->razon_social }}</h3>
                        <p class="text-gray-600">CIF: {{ $empresa->cif }} | {{ $empresa->email }}</p>
                    </div>
                    <a href="{{ route('empresas.edit', $empresa) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar Empresa</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2 border-b">Ubicación y Sector</h4>
                        <p><strong>Población:</strong> {{ $empresa->poblacion }}</p>
                        <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>
                        <p><strong>Campo Laboral:</strong> {{ $empresa->campo_laboral }}</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2 border-b">Ciclos Relacionados</h4>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($empresa->ciclos as $ciclo)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded">{{ $ciclo }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4 border-b">
                        <h4 class="font-bold text-gray-700">Contactos de la Empresa</h4>
                        <a href="{{ route('contactos.create', ['empresa_id' => $empresa->id]) }}" class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded hover:bg-blue-100 transition">
                            + Añadir Contacto
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($empresa->contactos as $contacto)
                            <div class="border rounded-lg p-4 bg-gray-50 flex justify-between items-start">
                                <div>
                                    <p class="font-bold">{{ $contacto->nombre }}</p>
                                    <p class="text-xs text-gray-600">{{ $contacto->puesto ?? 'Personal' }}</p>
                                    <p class="text-sm mt-2">{{ $contacto->email }}</p>
                                    <p class="text-sm">{{ $contacto->telefono }}</p>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('contactos.edit', $contacto) }}" class="text-xs text-indigo-600 hover:underline">Editar</a>
                                    <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" onsubmit="return confirm('¿Eliminar contacto?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No hay contactos registrados.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
