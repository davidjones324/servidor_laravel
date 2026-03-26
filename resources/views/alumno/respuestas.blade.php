<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                <span class="text-3xl">📝</span> Respuestas del Formulario - {{ $alumno->nombre }} {{ $alumno->apellidos }}
            </h2>
            <a href="{{ route('alumnos.show', $alumno) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Volver al Expediente
            </a>
        </div>
    </x-slot>

    <style>
        body { background: #f1f3f4; }
        .google-container { max-width: 760px; margin: 40px auto; padding: 0 20px; }
        .google-card { background: #fff; border-radius: 12px; padding: 32px; margin-bottom: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); border-top: 8px solid #41B3A3; }
        .google-question { background: #fff; border-radius: 12px; padding: 28px; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border: 1px solid #e0e0e0; }
        .google-title { font-size: 32px; font-weight: 600; color: #202124; margin-bottom: 12px; }
        .google-description { font-size: 16px; color: #5f6368; margin-bottom: 20px; }
        .google-label { font-size: 16px; font-weight: 500; color: #202124; margin-bottom: 8px; display: block; border-bottom: 1px solid #eeeeee; padding-bottom: 4px; }
        .google-answer { font-size: 18px; color: #1a73e8; font-weight: 600; margin-bottom: 20px; background-color: #f8fbff; padding: 12px; rounded: 8px; border-left: 4px solid #1a73e8; }
        .google-sub-answer { font-size: 16px; color: #3c4043; margin-top: 8px; background: #fdfdfd; padding: 10px; border-radius: 8px; border: 1px dashed #dadce0; }
        .google-section-title { font-size: 20px; font-weight: 600; color: #41B3A3; margin-top: 24px; margin-bottom: 16px; display: flex; items-center gap: 2; }
    </style>

    <div class="google-container">
        {{-- Header Card --}}
        <div class="google-card">
            <h1 class="google-title">Cuestionario de Prácticas</h1>
            <p class="google-description">
                Respuestas registradas por el alumno para la planificación de las prácticas FCT/Dual.
                <br><small class="text-gray-400">Fecha de respuesta: {{ $respuesta->updated_at->format('d/m/Y H:i') }}</small>
            </p>
        </div>

        {{-- 1. Desplazamiento --}}
        <div class="google-question">
            @php
                $opcionesDesplazamiento = [
                    'coche_y_carnet' => 'Sí, tengo coche y carnet',
                    'solo_coche' => 'Solo coche',
                    'solo_carnet' => 'Solo carnet',
                    'transporte_escolar' => 'Dispongo de transporte escolar',
                    'no_puedo' => 'No tengo posibilidad de desplazarme'
                ];
            @endphp
            <label class="google-label">Desplazamiento</label>
            <div class="google-answer">{{ $opcionesDesplazamiento[$respuesta->desplazamiento] ?? 'No especificado' }}</div>

            @if($respuesta->observaciones_desplazamiento)
                <label class="google-label">Observaciones sobre el desplazamiento</label>
                <div class="google-sub-answer">{{ $respuesta->observaciones_desplazamiento }}</div>
            @endif
        </div>

        {{-- 2. Segunda residencia --}}
        <div class="google-question">
            <label class="google-label">¿Segunda residencia?</label>
            <div class="google-answer">{{ $respuesta->segunda_residencia ?: 'No dispone o no especificado' }}</div>
        </div>

        {{-- 3. Ciclo distinto --}}
        <div class="google-question">
            @php
                $opcionesCiclo = [
                    'smr' => 'Sí, SMR',
                    'asir' => 'Sí, ASIR',
                    'dam' => 'Sí, DAM',
                    'otro_ciclo' => 'Sí, otro',
                    'primero' => 'No, es el primer ciclo formativo que estoy cursando'
                ];
            @endphp
            <label class="google-label">¿Ha realizado un ciclo formativo distinto?</label>
            <div class="google-answer">
                @if(array_key_exists($respuesta->ciclo_distinto, $opcionesCiclo))
                    {{ $opcionesCiclo[$respuesta->ciclo_distinto] }}
                @else
                    Sí, {{ $respuesta->ciclo_distinto }}
                @endif
            </div>
        </div>

        {{-- 4. FCT Anterior --}}
        <div class="google-question">
            <label class="google-label">¿Ha hecho la FCT o FFEOE anteriormente?</label>
            <div class="google-answer">{{ $respuesta->ha_hecho_fct_antes ? 'SÍ' : 'NO' }}</div>

            @if($respuesta->ha_hecho_fct_antes)
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="google-label !border-none !text-xs text-gray-400">Empresa anterior</label>
                        <div class="google-sub-answer font-semibold">{{ $respuesta->empresa_fct_anterior ?: 'No indicada' }}</div>
                    </div>
                    <div>
                        <label class="google-label !border-none !text-xs text-gray-400">Población</label>
                        <div class="google-sub-answer font-semibold">{{ $respuesta->poblacion_fct_anterior ?: 'No indicada' }}</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- 5. Autocrítica --}}
        <div class="google-question">
            <h3 class="google-section-title">📊 Autovaloración</h3>
            @php
                $preguntasAutocritica = [
                    'interes_practicas' => 'Interés en realizar las prácticas de empresa',
                    'interes_seguir_estudiando' => 'Interés en seguir estudiando a la finalización',
                    'interes_quedarse_empresa' => 'Interés en quedarse en la empresa a la finalización',
                    'interes_compartir_empresa' => 'Interés en compartir tus conocimientos con la empresa',
                    'miedo_practicas' => 'Miedo/respeto a las FCT/Dual',
                    'actitud_practicas' => 'Actitud con la que afronto esta actividad formativa'
                ];
                $opcionesCritica = ['mucho' => 'Mucho', 'normal' => 'Normal', 'poco' => 'Poco', 'muy_poco' => 'Muy poco'];
            @endphp

            <div class="space-y-4">
                @foreach($preguntasAutocritica as $campo => $enunciado)
                    <div class="border-b border-gray-50 pb-2">
                        <span class="text-sm text-gray-500 block">{{ $enunciado }}</span>
                        <span class="font-bold text-gray-800">{{ ucfirst($respuesta->$campo) ?: 'No valorado' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 6. Empresa Destino / Pensada --}}
        <div class="google-question">
            <h3 class="google-section-title">🏢 Preferencias de Empresa</h3>

            <label class="google-label">Empresa destino de Prácticas</label>
            <div class="google-answer">{{ $respuesta->empresa_destino_practicas ?: 'No especificada' }}</div>

            <div class="mt-6">
                <label class="google-label">¿Tiene alguna empresa pensada?</label>
                @php
                    $statusEmpresa = [
                        'si' => 'Sí, ha contactado con la empresa',
                        'si_sin_contacto' => 'Sí, pero sin contacto previo',
                        'no' => 'No ha pensado en ninguna'
                    ];
                @endphp
                <div class="google-answer">{{ $statusEmpresa[$respuesta->tiene_empresa_pensada] ?? 'No especificado' }}</div>

                @if($respuesta->tiene_empresa_pensada != 'no')
                    <div class="google-sub-answer mt-2">
                        <p><strong>Nombre:</strong> {{ $respuesta->empresa_pensada_nombre }}</p>
                        <p><strong>Localidad:</strong> {{ $respuesta->empresa_pensada_localidad }}</p>
                        <p><strong>Teléfono:</strong> {{ $respuesta->empresa_pensada_telefono }}</p>
                        <p><strong>Contacto:</strong> {{ $respuesta->empresa_pensada_contacto }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <label class="google-label">Otras empresas de interés</label>
                <div class="google-sub-answer">{{ $respuesta->otras_empresas_interes ?: 'Ninguna indicada' }}</div>
            </div>

            <div class="mt-6">
                <label class="google-label">Observaciones finales</label>
                <div class="google-sub-answer text-amber-800 bg-amber-50 border-amber-100 italic">{{ $respuesta->observaciones_empresas ?: 'Sin observaciones' }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
