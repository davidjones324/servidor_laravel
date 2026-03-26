@if(session('success'))
    <div style="background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<style>
    body {
        background: #f1f3f4;
    }

    .google-container {
        max-width: 760px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .google-card {
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        margin-bottom: 24px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        border-top: 8px solid #4285f4;
    }

    .google-question {
        background: #fff;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        border: 1px solid #e0e0e0;
    }

    .google-title {
        font-size: 32px;
        font-weight: 600;
        color: #202124;
        margin-bottom: 12px;
    }

    .google-description {
        font-size: 16px;
        color: #5f6368;
        margin-bottom: 20px;
    }

    .google-label {
        font-size: 18px;
        font-weight: 500;
        color: #202124;
        margin-bottom: 12px;
        display: block;
    }

    .google-input,
    .google-textarea {
        width: 100%;
        border: none;
        border-bottom: 2px solid #dadce0;
        padding: 6px 4px;
        font-size: 16px;
        background: transparent;
        transition: 0.2s;
    }

    .google-input:focus,
    .google-textarea:focus {
        outline: none;
        border-bottom-color: #4285f4;
    }

    .google-radio {
        transform: scale(1.2);
        margin-right: 10px;
        accent-color: #4285f4;
    }

    .google-submit {
        background: #4285f4;
        color: white;
        padding: 12px 28px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 20px;
    }

    .google-submit:hover {
        background: #3367d6;
    }

    .conditional-section {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .conditional-section.hidden {
        max-height: 0;
        opacity: 0;
        margin: 0;
        padding: 0;
    }

    .conditional-section.visible {
        max-height: 1000px;
        opacity: 1;
    }
</style>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Encuesta de Preferencias FCT/Dual
        </h2>
    </x-slot>

    <div class="google-container">

        {{-- Tarjeta de introducción --}}
        <div class="google-card">
            <h1 class="google-title">Cuestionario Inicial Prácticas</h1>
            <p class="google-description">
                Por favor, rellena el siguiente cuestionario con sinceridad. Esta información es crucial para poder buscarte la mejor empresa para FCT o Dual.
            </p>
        </div>

        <form action="{{ route('formulario.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 1. Desplazamiento --}}
            <div class="google-question">
                <label class="google-label">Desplazamiento *</label>

                @php
                    $opcionesDesplazamiento = [
                        'coche_y_carnet' => 'Sí, tengo coche y carnet',
                        'solo_coche' => 'Solo coche',
                        'solo_carnet' => 'Solo carnet',
                        'transporte_escolar' => 'Dispongo de transporte escolar',
                        'no_puedo' => 'No tengo posibilidad de desplazarme'
                    ];
                    $desplazamientoValue = old('desplazamiento', $respuesta->desplazamiento);
                @endphp

                @foreach($opcionesDesplazamiento as $val => $label)
                    <label style="display:flex; align-items:center; margin-bottom:8px;">
                        <input type="radio" class="google-radio" name="desplazamiento" value="{{ $val }}" {{ $desplazamientoValue == $val ? 'checked' : '' }} required>
                        {{ $label }}
                    </label>
                @endforeach

                <label class="google-label" style="margin-top:20px;">Observaciones</label>
                <textarea name="observaciones_desplazamiento" class="google-textarea" rows="2">{{ old('observaciones_desplazamiento', $respuesta->observaciones_desplazamiento) }}</textarea>
            </div>

            {{-- 2. Segunda residencia --}}
            <div class="google-question">
                <label class="google-label">¿Tienes segunda residencia o varias? Si es así, indica dónde</label>
                <textarea name="segunda_residencia" class="google-textarea" rows="2" placeholder="Indica la localidad/es si tienes otra residencia, o deja vacío si no">{{ old('segunda_residencia', $respuesta->segunda_residencia) }}</textarea>
            </div>

            {{-- 3. Ciclo distinto --}}
            <div class="google-question">
                <label class="google-label">¿Has realizado un ciclo formativo distinto al que estás cursando? *</label>

                @php
                    $opcionesCiclo = [
                        'smr' => 'Sí, SMR',
                        'asir' => 'Sí, ASIR',
                        'dam' => 'Sí, DAM',
                        'otro_ciclo' => 'Sí, otro',
                        'primero' => 'No, es el primer ciclo formativo que estoy cursando'
                    ];
                    $cicloValue = old('ciclo_distinto', $respuesta->ciclo_distinto);
                    $isOtro = $cicloValue && !array_key_exists($cicloValue, $opcionesCiclo);
                @endphp

                @foreach($opcionesCiclo as $val => $label)
                    <label style="display:flex; align-items:center; margin-bottom:8px;">
                        <input type="radio" class="google-radio" name="ciclo_distinto" value="{{ $val }}" {{ (!$isOtro && $cicloValue == $val) ? 'checked' : '' }} required>
                        {{ $label }}
                    </label>
                @endforeach

                <label style="display:flex; align-items:center; margin-top:10px;">
                    <input type="radio" class="google-radio" name="ciclo_distinto" value="otro_custom" {{ $isOtro ? 'checked' : '' }}>
                </label>
            </div>

            {{-- 4. FCT/FFEOE anterior --}}
            <div class="google-question">
                <label class="google-label">¿Has hecho la FCT o FFEOE anteriormente? *</label>

                @php
                    $fctValue = old('ha_hecho_fct_antes', $respuesta->ha_hecho_fct_antes);
                @endphp

                <label style="display:flex; align-items:center; margin-bottom:8px;">
                    <input type="radio" class="google-radio" name="ha_hecho_fct_antes" value="1"
                        {{ $fctValue == '1' ? 'checked' : '' }} required
                        onchange="toggleFctFields()">
                    Sí
                </label>

                <label style="display:flex; align-items:center;">
                    <input type="radio" class="google-radio" name="ha_hecho_fct_antes" value="0"
                        {{ $fctValue == '0' ? 'checked' : '' }} required
                        onchange="toggleFctFields()">
                    No, es la primera vez
                </label>

                {{-- Campos condicionales FCT --}}
                <div id="fctConditionalFields" class="conditional-section {{ $fctValue == '1' ? 'visible' : 'hidden' }}" style="margin-top:20px;">
                    <label class="google-label">Indica en qué empresa lo hiciste</label>
                    <input type="text" class="google-input" name="empresa_fct_anterior"
                        value="{{ old('empresa_fct_anterior', $respuesta->empresa_fct_anterior) }}"
                        placeholder="Nombre de la empresa">

                    <label class="google-label" style="margin-top:15px;">¿Dónde lo hiciste? (pueblo o ciudad)</label>
                    <input type="text" class="google-input" name="poblacion_fct_anterior"
                        value="{{ old('poblacion_fct_anterior', $respuesta->poblacion_fct_anterior) }}"
                        placeholder="Localidad">
                </div>
            </div>

            {{-- 5. Autocrítica --}}
            <div class="google-question">
                <label class="google-label">Responde de forma autocrítica sobre ti mismo/a *</label>

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

                @foreach($preguntasAutocritica as $campo => $enunciado)
                    <div style="margin-bottom:15px;">
                        <strong>{{ $enunciado }}</strong><br>
                        @foreach($opcionesCritica as $val => $label)
                            <label style="margin-right:15px;">
                                <input type="radio" class="google-radio" name="{{ $campo }}" value="{{ $val }}" {{ old($campo, $respuesta->$campo) == $val ? 'checked' : '' }} required>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- 6. Empresa destino --}}
            <div class="google-question">
                <label class="google-label">Empresa destino de Prácticas</label>
                <textarea name="empresa_destino_practicas" class="google-textarea" rows="2">{{ old('empresa_destino_practicas', $respuesta->empresa_destino_practicas) }}</textarea>
            </div>

            {{-- 7. Empresa pensada --}}
            <div class="google-question">
                <label class="google-label">¿Tienes alguna empresa pensada para realizar tus prácticas? *</label>

                @php
                    $empresaPensadaValue = old('tiene_empresa_pensada', $respuesta->tiene_empresa_pensada);
                @endphp

                <label style="display:flex; align-items:center; margin-bottom:8px;">
                    <input type="radio" class="google-radio" name="tiene_empresa_pensada" value="si"
                        {{ $empresaPensadaValue == 'si' ? 'checked' : '' }} required
                        onchange="toggleEmpresaFields()">
                    Sí, he contactado con la empresa
                </label>

                <label style="display:flex; align-items:center; margin-bottom:8px;">
                    <input type="radio" class="google-radio" name="tiene_empresa_pensada" value="si_sin_contacto"
                        {{ $empresaPensadaValue == 'si_sin_contacto' ? 'checked' : '' }} required
                        onchange="toggleEmpresaFields()">
                    Sí, no he realizado ningún contacto
                </label>

                <label style="display:flex; align-items:center;">
                    <input type="radio" class="google-radio" name="tiene_empresa_pensada" value="no"
                        {{ $empresaPensadaValue == 'no' ? 'checked' : '' }} required
                        onchange="toggleEmpresaFields()">
                    No, no he pensado en ello
                </label>

                {{-- Campos condicionales empresa --}}
                <div id="empresaConditionalFields" class="conditional-section {{ in_array($empresaPensadaValue, ['si', 'si_sin_contacto']) ? 'visible' : 'hidden' }}" style="margin-top:20px;">
                    <label class="google-label">Nombre de la empresa</label>
                    <input type="text" class="google-input" name="empresa_pensada_nombre" value="{{ old('empresa_pensada_nombre', $respuesta->empresa_pensada_nombre) }}">

                    <label class="google-label" style="margin-top:15px;">Localidad</label>
                    <input type="text" class="google-input" name="empresa_pensada_localidad" value="{{ old('empresa_pensada_localidad', $respuesta->empresa_pensada_localidad) }}">

                    <label class="google-label" style="margin-top:15px;">Teléfono</label>
                    <input type="text" class="google-input" name="empresa_pensada_telefono" value="{{ old('empresa_pensada_telefono', $respuesta->empresa_pensada_telefono) }}">

                    <label class="google-label" style="margin-top:15px;">Persona de contacto (si la tuvieras)</label>
                    <input type="text" class="google-input" name="empresa_pensada_contacto" value="{{ old('empresa_pensada_contacto', $respuesta->empresa_pensada_contacto) }}">
                </div>
            </div>

            {{-- 8. Otras empresas --}}
            <div class="google-question">
                <label class="google-label">Indica el nombre de otras empresas que conozcas en las que querrías/podrías hacer tus prácticas</label>
                <p style="color:#5f6368; font-size:14px; margin-bottom:10px;">Indica "ninguna" si no quieres poner nada.</p>
                <textarea name="otras_empresas_interes" class="google-textarea" rows="3">{{ old('otras_empresas_interes', $respuesta->otras_empresas_interes) }}</textarea>
            </div>

            {{-- 9. Observaciones finales --}}
            <div class="google-question">
                <label class="google-label">Observaciones finales</label>
                <textarea name="observaciones_empresas" class="google-textarea" rows="2">{{ old('observaciones_empresas', $respuesta->observaciones_empresas) }}</textarea>
            </div>

            <button type="submit" class="google-submit">Enviar</button>

        </form>

    </div>

    {{-- JavaScript para mostrar/ocultar campos condicionales --}}
    <script>
        function toggleFctFields() {
            const fctRadios = document.querySelectorAll('input[name="ha_hecho_fct_antes"]');
            const fctFields = document.getElementById('fctConditionalFields');
            let selectedValue = null;

            fctRadios.forEach(function(radio) {
                if (radio.checked) {
                    selectedValue = radio.value;
                }
            });

            if (selectedValue === '1') {
                fctFields.classList.remove('hidden');
                fctFields.classList.add('visible');
            } else {
                fctFields.classList.remove('visible');
                fctFields.classList.add('hidden');
            }
        }

        function toggleEmpresaFields() {
            const empresaRadios = document.querySelectorAll('input[name="tiene_empresa_pensada"]');
            const empresaFields = document.getElementById('empresaConditionalFields');
            let selectedValue = null;

            empresaRadios.forEach(function(radio) {
                if (radio.checked) {
                    selectedValue = radio.value;
                }
            });

            if (selectedValue === 'si' || selectedValue === 'si_sin_contacto') {
                empresaFields.classList.remove('hidden');
                empresaFields.classList.add('visible');
            } else {
                empresaFields.classList.remove('visible');
                empresaFields.classList.add('hidden');
            }
        }

        // Inicializar estado al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            toggleFctFields();
            toggleEmpresaFields();
        });
    </script>

</x-app-layout>
