<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-ies-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Perfil del Tutor Dual') }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('tutores.edit', $tutor) }}" class="btn-secondary text-xs uppercase tracking-widest px-4 py-2">
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('tutores.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 transition">
                    {{ __('Volver') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies border-t-4 border-ies-green-500 p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Avatar y Ciclo -->
                    <!-- Avatar y Ciclo -->
                    <!-- Avatar y Ciclo -->
                    <div class="flex flex-col items-center p-8 bg-white rounded-none border-[4px] border-[#007BFF] shadow-sm self-start" style="border: 4px solid #007BFF !important;">
                        <div class="w-24 h-24 bg-blue-50 border-2 border-[#007BFF] rounded-xl flex items-center justify-center text-[#007BFF] text-3xl font-black mb-6 shadow-sm">
                            {{ substr($tutor->nombre, 0, 1) }}{{ substr($tutor->apellidos, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black text-slate-900 text-center leading-tight mb-5 uppercase tracking-tighter">{{ $tutor->nombre }} {{ $tutor->apellidos }}</h3>
                        <div class="flex flex-wrap justify-center gap-2">
                            @if(is_array($tutor->ciclos))
                                @foreach($tutor->ciclos as $ciclo)
                                    <span class="bg-[#007BFF] text-white text-[10px] font-black px-3 py-1 rounded-none shadow-sm uppercase tracking-widest">Tutor {{ $ciclo }}</span>
                                @endforeach
                            @else
                                <span class="bg-[#007BFF] text-white text-[10px] font-black px-3 py-1 rounded-none shadow-sm uppercase tracking-widest">Tutor {{ $tutor->ciclos }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Datos Detallados -->
                    <div class="md:col-span-2 space-y-8">
                        <!-- Datos de Contacto -->
                        <div class="w-fit min-w-[350px]">
                            <h3 class="text-sm font-black text-[#007BFF] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                                <span class="flex items-center justify-center w-8 h-8 bg-blue-50 text-[#007BFF] rounded-lg border border-blue-100 shadow-sm text-base">📋</span> 
                                Datos de Contacto
                            </h3>
                            <div class="bg-white rounded-xl p-6 shadow-sm border-[#007BFF] border-2" style="border: 2px solid #007BFF !important;">
                                <div class="divide-y divide-slate-100">
                                    <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">DNI / NIE:</span>
                                        <span class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $tutor->dni }}</span>
                                    </div>
                                    <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 bg-slate-50/30">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Teléfono:</span>
                                        <span class="text-xs font-black font-mono text-blue-900">{{ $tutor->telefono }}</span>
                                    </div>
                                    <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 hover:bg-slate-50/50 transition-colors">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Email:</span>
                                        <span class="text-[11px] font-black text-[#007BFF] break-all">{{ $tutor->email }}</span>
                                    </div>
                                    @if($tutor->grupo)
                                    <div class="grid grid-cols-[140px_1fr] py-2.5 px-2 bg-slate-50/30">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase self-center tracking-tight">Grupo Principal:</span>
                                        <span class="text-xs font-black text-slate-900 uppercase">{{ $tutor->grupo }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Área de Docencia -->
                        <div class="w-fit min-w-[450px]">
                            <h3 class="text-sm font-black text-[#10B981] mb-3 flex items-center gap-3 uppercase tracking-wider ml-1">
                                <span class="flex items-center justify-center w-8 h-8 bg-green-50 text-[#10B981] rounded-lg border border-green-100 shadow-sm text-base">🏫</span> 
                                Área de Docencia
                            </h3>
                            <div class="bg-white rounded-xl p-6 shadow-sm border-[#10B981] border-2" style="border: 2px solid #10B981 !important;">
                                <div class="flex flex-wrap gap-3">
                                    @php $hasAssignments = false; @endphp
                                    @foreach($tutor->cursos as $curso)
                                        @if(isset($tutor->grupos[$curso]) && is_array($tutor->grupos[$curso]) && count($tutor->grupos[$curso]) > 0)
                                            @foreach($tutor->grupos[$curso] as $g)
                                                @if($g)
                                                    @php $hasAssignments = true; @endphp
                                                    <div class="bg-white p-2.5 border-2 border-slate-100 shadow-sm border-l-4 border-l-green-600 rounded-r-md hover:bg-green-50/30 transition-all flex items-center gap-3">
                                                        <span class="text-xs font-black text-slate-800 uppercase tracking-tighter">{{ $curso }} {{ $g }}</span>
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            @php $hasAssignments = true; @endphp
                                            <div class="bg-white p-2.5 border-2 border-slate-100 shadow-sm border-l-4 border-l-green-600 rounded-r-md hover:bg-green-50/30 transition-all">
                                                <span class="text-xs font-black text-slate-800 uppercase tracking-tighter">{{ $curso }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                    
                                    @if(!$hasAssignments && count($tutor->cursos) == 0)
                                        <div class="bg-slate-50 p-8 border-2 border-dashed border-slate-200 w-full text-center rounded-lg">
                                            <span class="text-[10px] text-slate-400 italic font-black uppercase tracking-widest">Sin asignaciones registradas.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between text-gray-400 text-xs italic">
                            <span>Registrado el {{ $tutor->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
