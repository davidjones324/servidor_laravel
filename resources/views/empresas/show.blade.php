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
                    <!-- Ubicación -->
                    <div class="w-fit min-w-[380px]">
                        <h3 class="text-sm font-black text-[#007BFF] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                             <span class="flex items-center justify-center w-8 h-8 bg-blue-50 text-[#007BFF] rounded-lg border border-blue-100 shadow-sm text-base">📍</span> 
                             Ubicación y Sede
                        </h3>
                        <div class="bg-white rounded-xl p-6 shadow-sm border-[#007BFF] border-2" style="border: 2px solid #007BFF !important;">
                            <div class="divide-y divide-slate-100">
                                <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Dirección:</span>
                                    <span class="text-xs font-black text-slate-900 uppercase">{{ $empresa->direccion }}</span>
                                </div>
                                <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 bg-slate-50/30">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Población:</span>
                                    <span class="text-xs font-black text-blue-900 uppercase">{{ $empresa->poblacion }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identidad Fiscal -->
                    <div class="w-fit min-w-[380px]">
                        <h3 class="text-sm font-black text-[#6366F1] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                             <span class="flex items-center justify-center w-8 h-8 bg-indigo-50 text-[#6366F1] rounded-lg border border-indigo-100 shadow-sm text-base">🧾</span> 
                             Identidad Fiscal
                        </h3>
                        <div class="bg-white rounded-xl p-6 shadow-sm border-[#6366F1] border-2" style="border: 2px solid #6366F1 !important;">
                            <div class="divide-y divide-slate-100">
                                <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Teléfono:</span>
                                    <span class="text-xs font-black font-mono text-slate-900">{{ $empresa->telefono ?? 'No indicado' }}</span>
                                </div>
                                <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 bg-slate-50/30">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Horario:</span>
                                    <span class="text-xs font-bold text-indigo-800 uppercase italic">{{ $empresa->horario ?? 'No indicado' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ciclos Formativos -->
                    <div class="col-span-1 md:col-span-2 w-fit min-w-[380px]">
                        <h3 class="text-sm font-black text-[#10B981] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                             <span class="flex items-center justify-center w-8 h-8 bg-green-50 text-[#10B981] rounded-lg border border-green-100 shadow-sm text-base">📚</span> 
                             Ciclos Formativos Vinculados
                        </h3>
                        <div class="bg-white rounded-xl p-6 shadow-sm border-[#10B981] border-2" style="border: 2px solid #10B981 !important;">
                            <div class="flex flex-wrap gap-2">
                                @forelse($empresa->ciclos as $ciclo)
                                    <div class="bg-white border-2 border-slate-100 p-2.5 shadow-sm flex items-center gap-3 border-l-4 border-l-green-600 rounded-r-md hover:bg-green-50/30 transition-all cursor-default">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">{{ $ciclo }}</span>
                                    </div>
                                @empty
                                    <div class="w-full bg-slate-50 p-6 border-2 border-dashed border-slate-200 text-center rounded-lg">
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Sin ciclos vinculados directamente.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
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
