<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <span class="text-2xl">👨‍🎓</span> {{ __('Expediente del Alumno') }}
            </h2>
            <div class="flex gap-2">
                @if($alumno->respuestaFormulario)
                    <a href="{{ route('alumnos.respuestas', $alumno) }}" class="btn-primary flex items-center gap-2">
                        <span>📝</span> Ver Respuestas Formulario
                    </a>
                @endif
                <a href="{{ route('alumnos.edit', $alumno) }}" class="btn-secondary">Editar</a>
                <a href="{{ route('alumnos.index') }}" class="btn-outline">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="card p-8">
                <h1 class="text-4xl font-extrabold text-ies-blue-700 mb-8 border-b-4 border-ies-blue-100 pb-4">
                    {{ $alumno->nombre }} {{ $alumno->apellidos }}
                </h1>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Datos Personales -->
                    <div class="w-fit min-w-[380px]">
                        <h3 class="text-sm font-black text-[#007BFF] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                             <span class="flex items-center justify-center w-8 h-8 bg-blue-50 text-[#007BFF] rounded-lg border border-blue-100 shadow-sm text-base">👤</span> 
                             Datos Personales
                        </h3>
                        <div class="bg-white rounded-xl p-6 shadow-sm border-[#007BFF] border-2" style="border: 2px solid #007BFF !important;">
                            <div class="divide-y divide-slate-100 text-left">
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">DNI / NIE:</span>
                                    <span class="text-xs font-black text-slate-900 uppercase">{{ $alumno->dni ?? 'No especificado' }}</span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 bg-slate-50/30">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Nº Seg. Social:</span>
                                    <span class="text-xs font-black {{ empty($alumno->numero_ss) ? 'text-red-500 italic' : 'text-blue-900' }}">
                                        {{ $alumno->numero_ss ?? 'PENDIENTE' }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Fecha Nacimiento:</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 bg-slate-50/30">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Teléfono:</span>
                                    <span class="text-xs font-black font-mono text-blue-800">{{ $alumno->telefono }}</span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Email:</span>
                                    <span class="text-[11px] font-black text-[#007BFF] break-all">{{ $alumno->email }}</span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 bg-slate-50/30">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Domicilio:</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $alumno->domicilio ?? $alumno->direccion ?? '-' }}</span>
                                </div>
                                <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Localidad:</span>
                                    <span class="text-xs font-black text-slate-900 uppercase">{{ $alumno->localidad ?? '-' }} ({{ $alumno->codigo_postal ?? '-' }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Datos Académicos -->
                        <div class="w-fit min-w-[380px]">
                            <h3 class="text-sm font-black text-[#10B981] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                                 <span class="flex items-center justify-center w-8 h-8 bg-green-50 text-[#10B981] rounded-lg border border-green-100 shadow-sm text-base">📚</span> 
                                 Datos Académicos
                            </h3>
                            <div class="bg-white rounded-xl p-6 shadow-sm border-[#10B981] border-2" style="border: 2px solid #10B981 !important;">
                                <div class="divide-y divide-slate-100">
                                    <div class="flex items-center justify-between py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">Estado FFEOE:</span>
                                        @if($alumno->apto_ffoe)
                                            <span class="text-[10px] font-black text-green-700 bg-green-50 px-2 py-0.5 border border-green-200 uppercase">APTO</span>
                                        @else
                                            <span class="text-[10px] font-black text-red-700 bg-red-50 px-2 py-0.5 border border-red-200 uppercase">NO APTO</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between py-2.5 px-2 bg-slate-50/30">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">Seguro Escolar:</span>
                                        @if($alumno->seguro_escolar)
                                            <span class="text-green-700 font-bold text-[11px] bg-white px-2 py-0.5 border border-green-100 text-center shadow-sm uppercase">✅ CUBIERTO</span>
                                        @else
                                            <span class="text-red-500 font-black text-[11px] bg-white px-2 py-0.5 border border-red-100 text-center shadow-sm uppercase italic">❌ PENDIENTE</span>
                                        @endif
                                    </div>
                                    <div class="py-3 px-2 text-center">
                                        <span class="text-[9px] font-bold text-slate-400 block mb-2 uppercase tracking-widest">Estudios Anteriores</span>
                                        <p class="text-[11px] font-bold text-slate-700 bg-slate-50 p-3 border-l-4 border-green-500 rounded-r shadow-inner uppercase leading-relaxed italic">
                                            {{ $alumno->estudios_anteriores ?: 'Sin registros detallados.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FCT Anterior -->
                        <div class="w-fit min-w-[380px]">
                            <h3 class="text-sm font-black text-[#6366F1] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                                 <span class="flex items-center justify-center w-8 h-8 bg-indigo-50 text-[#6366F1] rounded-lg border border-indigo-100 shadow-sm text-base">🔄</span> 
                                 FCT Anterior
                            </h3>
                            <div class="bg-white rounded-xl p-6 shadow-sm border-[#6366F1] border-2" style="border: 2px solid #6366F1 !important;">
                                <div class="divide-y divide-slate-100">
                                    <div class="flex items-center justify-between py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">¿Realizada anteriormente?</span>
                                        <span class="font-black text-xs {{ $alumno->ha_realizado_fct_anterior ? 'text-green-600 bg-green-50' : 'text-slate-400 bg-slate-50' }} px-3 py-0.5 border border-slate-200">
                                            {{ $alumno->ha_realizado_fct_anterior ? 'SÍ' : 'NO' }}
                                        </span>
                                    </div>
                                    @if($alumno->ha_realizado_fct_anterior)
                                        <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 bg-slate-50/30">
                                            <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Empresa FCT:</span>
                                            <span class="text-xs font-black text-indigo-900 uppercase">{{ $alumno->empresa_fct_anterior ?? '-' }}</span>
                                        </div>
                                        <div class="grid grid-cols-[160px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                            <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Localidad:</span>
                                            <span class="text-xs font-bold text-slate-800 uppercase">{{ $alumno->localidad_fct_anterior ?? '-' }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Logística -->
                        <div class="w-fit min-w-[380px]">
                            <h3 class="text-sm font-black text-[#F59E0B] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                                <span class="flex items-center justify-center w-8 h-8 bg-orange-50 text-[#F59E0B] rounded-lg border border-orange-100 shadow-sm text-base">🚗</span> 
                                Logística y Movilidad
                            </h3>
                            <div class="bg-white rounded-xl p-6 shadow-sm border-[#F59E0B] border-2" style="border: 2px solid #F59E0B !important;">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="py-2.5 px-3 bg-slate-50/50 border border-slate-100 rounded-lg text-center shadow-inner">
                                        <span class="text-[9px] font-bold text-slate-400 block mb-1 uppercase tracking-tighter">Permiso B</span>
                                        <span class="text-[11px] font-black {{ $alumno->carnet_conducir ? 'text-green-700 bg-white border border-green-100' : 'text-orange-700 bg-white border border-orange-100' }} px-2 py-0.5 block w-full text-center">
                                            {{ $alumno->carnet_conducir ? '✅ SÍ' : '❌ NO' }}
                                        </span>
                                    </div>
                                    <div class="py-2.5 px-3 bg-slate-50/50 border border-slate-100 rounded-lg text-center shadow-inner">
                                        <span class="text-[9px] font-bold text-slate-400 block mb-1 uppercase tracking-tighter">Vehículo Propio</span>
                                        <span class="text-[11px] font-black {{ $alumno->coche_propio ? 'text-green-700 bg-white border border-green-100' : 'text-orange-700 bg-white border border-orange-100' }} px-2 py-0.5 block w-full text-center">
                                            {{ $alumno->coche_propio ? '✅ SÍ' : '❌ NO' }}
                                        </span>
                                    </div>
                                    <div class="col-span-2 py-3 px-3 bg-white border-2 border-slate-50 rounded-lg mt-2 shadow-sm italic">
                                        <span class="text-[9px] font-bold text-slate-400 block mb-1.5 uppercase tracking-widest text-center">Transporte Habitual</span>
                                        <p class="text-xs font-black text-amber-900 bg-amber-50/30 p-2.5 text-center uppercase border border-amber-100 shadow-inner rounded">
                                            {{ $alumno->transporte ?? 'No especificado.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Acuerdos -->
            <div class="card overflow-hidden">
                <div class="bg-ies-blue-50 border-b border-ies-blue-100 p-6 flex justify-between items-center">
                    <h4 class="text-xl font-bold text-ies-blue-800 flex items-center gap-2">
                        <span>🤝</span> Acuerdos de Prácticas
                    </h4>
                    <span class="badge-ies-blue px-3 py-1">{{ $alumno->acuerdos->count() }} Trámites</span>
                </div>
                
                <div class="p-0">
                    @if($alumno->acuerdos->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-200">
                                        <th class="p-4 font-semibold">Curso Académico</th>
                                        <th class="p-4 font-semibold">Empresa</th>
                                        <th class="p-4 font-semibold">Estado</th>
                                        <th class="p-4 font-semibold text-right">Horas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($alumno->acuerdos->sortBy('curso') as $acuerdo)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="p-4 font-medium text-gray-900">
                                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-bold mr-2">{{ $acuerdo->curso }}</span>
                                            </td>
                                            <td class="p-4">
                                                <a href="{{ route('empresas.show', $acuerdo->empresa_id) }}" class="text-ies-blue-600 hover:text-ies-blue-800 font-medium">
                                                    {{ $acuerdo->empresa->razon_social }}
                                                </a>
                                            </td>
                                            <td class="p-4">
                                                <span class="badge-ies-green uppercase shadow-sm">
                                                    {{ $acuerdo->estado_convenio }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-right font-medium text-gray-700">
                                                {{ $acuerdo->horas_totales }}h
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center flex flex-col items-center bg-slate-50/20 border-t border-slate-100">
                            <span class="text-4xl text-slate-200 mb-4 opacity-75">📄</span>
                            <p class="text-[11px] text-slate-500 font-black uppercase tracking-widest italic">Este alumno no tiene acuerdos vinculados actualmente.</p>
                            <p class="text-[9px] text-slate-400 mt-2 uppercase font-bold tracking-tighter">Asigne el alumno desde el gestor de acuerdos.</p>
                        </div>
                    @endif
                </div>
            <!-- Panel de Historial de Matrículas -->
            <div class="card overflow-hidden">
                <div class="bg-amber-50 border-b border-amber-100 p-6 flex justify-between items-center">
                    <h4 class="text-xl font-bold text-amber-800 flex items-center gap-2">
                        <span>🎓</span> Historial de Matrículas Anteriores
                    </h4>
                    <span class="badge-ies-blue bg-amber-100 text-amber-700 px-3 py-1 border-amber-200">{{ $alumno->matriculas->count() }} Registros</span>
                </div>
                
                <div class="p-0">
                    @if($alumno->matriculas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-200">
                                        <th class="p-4 font-semibold">Año Académico</th>
                                        <th class="p-4 font-semibold">Ciclo</th>
                                        <th class="p-4 font-semibold">Curso</th>
                                        <th class="p-4 font-semibold">Grupo</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($alumno->matriculas->sortByDesc('anio_academico') as $matricula)
                                        <tr class="hover:bg-amber-50/30 transition-colors">
                                            <td class="p-4 font-bold text-gray-900">
                                                {{ $matricula->anio_academico }}
                                            </td>
                                            <td class="p-4 text-gray-700 font-medium">
                                                {{ $matricula->ciclo }}
                                            </td>
                                            <td class="p-4">
                                                <span class="px-2 py-0.5 bg-gray-100 rounded text-gray-600 font-bold">{{ $matricula->curso }}º</span>
                                            </td>
                                            <td class="p-4 text-gray-600">
                                                {{ $matricula->grupo }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-10 text-center flex flex-col items-center">
                            <span class="text-4xl text-amber-200 mb-3">🎓</span>
                            <p class="text-gray-500 font-medium text-lg">No hay registros de matrículas anteriores para este alumno.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
