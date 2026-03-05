<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-ies-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Gestión de Contactos de Empresa') }}
                </h2>
            </div>
            <a href="{{ route('contactos.create') }}" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Contacto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-0 card-ies">
                @if (session('success'))
                    <div class="m-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-100 flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-header">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-white/90">Nombre Completo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-white/90">Empresa</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-white/90">Puesto</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-white/90">Email/Teléfono</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-white/90 italic">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($contactos as $contacto)
                                <tr class="hover:bg-ies-blue-50/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-ies-blue-100 flex items-center justify-center text-ies-blue-700 font-bold border-2 border-white shadow-sm mr-3">
                                                {{ substr($contacto->nombre, 0, 1) }}{{ substr($contacto->apellidos, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $contacto->nombre }} {{ $contacto->apellidos }}</div>
                                                <div class="text-xs text-gray-400 capitalize">{{ $contacto->dni }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ $contacto->empresa->razon_social }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contacto->puesto }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="text-gray-900">{{ $contacto->correo }}</div>
                                        <div class="text-xs text-gray-500">{{ $contacto->telefono }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('contactos.edit', $contacto) }}" class="text-ies-green-600 hover:text-ies-green-900 transition font-bold" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar a este contacto?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition font-bold" title="Eliminar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <p class="text-gray-500 italic text-lg font-medium">No hay contactos registrados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $contactos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
