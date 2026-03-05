<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empresa') }}: {{ $empresa->razon_social }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('empresas.update', $empresa) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Razón Social -->
                        <div>
                            <x-input-label for="razon_social" :value="__('Razón Social')" />
                            <x-text-input id="razon_social" name="razon_social" type="text" class="mt-1 block w-full" :value="old('razon_social', $empresa->razon_social)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('razon_social')" />
                        </div>

                        <!-- CIF -->
                        <div>
                            <x-input-label for="cif" :value="__('CIF')" />
                            <x-text-input id="cif" name="cif" type="text" class="mt-1 block w-full" :value="old('cif', $empresa->cif)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cif')" />
                        </div>

                        <!-- Dirección -->
                        <div>
                            <x-input-label for="direccion" :value="__('Dirección')" />
                            <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $empresa->direccion)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                        </div>

                        <!-- Población -->
                        <div>
                            <x-input-label for="poblacion" :value="__('Población')" />
                            <x-text-input id="poblacion" name="poblacion" type="text" class="mt-1 block w-full" :value="old('poblacion', $empresa->poblacion)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('poblacion')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $empresa->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $empresa->telefono)" />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <!-- Responsable -->
                        <div>
                            <x-input-label for="responsable" :value="__('Responsable')" />
                            <x-text-input id="responsable" name="responsable" type="text" class="mt-1 block w-full" :value="old('responsable', $empresa->responsable)" />
                            <x-input-error class="mt-2" :messages="$errors->get('responsable')" />
                        </div>

                        <!-- Horario -->
                        <div>
                            <x-input-label for="horario" :value="__('Horario')" />
                            <x-text-input id="horario" name="horario" type="text" class="mt-1 block w-full" :value="old('horario', $empresa->horario)" />
                            <x-input-error class="mt-2" :messages="$errors->get('horario')" />
                        </div>

                        <!-- Campo Laboral -->
                        <div>
                            <x-input-label for="campo_laboral" :value="__('Campo Laboral')" />
                            <x-text-input id="campo_laboral" name="campo_laboral" type="text" class="mt-1 block w-full" :value="old('campo_laboral', $empresa->campo_laboral)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('campo_laboral')" />
                        </div>

                        <!-- Ciclos -->
                        <div class="md:col-span-2">
                            <x-input-label for="ciclos" :value="__('Ciclos Relacionados')" />
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach(['ASIR', 'SMR', 'DAM'] as $ciclo)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="ciclos[]" value="{{ $ciclo }}" {{ in_array($ciclo, old('ciclos', $empresa->ciclos ?? [])) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">{{ $ciclo }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('ciclos')" />
                        </div>

                        <!-- Personas de Contacto (Replicando lógica de Acuerdo) -->
                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-gray-100 mt-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wider flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Personas de Contacto
                                </h3>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="toggleSearch('search_contacto')" class="text-xs bg-white border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-50 flex items-center font-bold shadow-sm transition">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        Buscar
                                    </button>
                                    <a href="{{ route('contactos.create', ['empresa_id' => $empresa->id]) }}" target="_blank" class="text-xs bg-ies-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-ies-blue-700 flex items-center font-bold shadow-md transition">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Añadir Nueva
                                    </a>
                                </div>
                            </div>

                            <input type="text" id="search_contacto" onkeyup="filterContacts()" placeholder="Buscar por nombre o cargo..." class="hidden mb-4 block w-full border-gray-300 rounded-lg shadow-sm focus:border-ies-blue-500 focus:ring-ies-blue-500 sm:text-sm">

                            <div class="flex items-center space-x-4 mb-4 bg-white/50 p-2 rounded-lg border border-gray-100">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="contact_view_mode" value="list" checked onclick="toggleContactView('list')" class="text-ies-blue-600 focus:ring-ies-blue-500 border-gray-300">
                                    <span class="ml-2 text-xs font-bold text-gray-600 uppercase group-hover:text-ies-blue-600 transition">Lista de Contactos</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="radio" name="contact_view_mode" value="details" onclick="toggleContactView('details')" class="text-ies-blue-600 focus:ring-ies-blue-500 border-gray-300">
                                    <span class="ml-2 text-xs font-bold text-gray-600 uppercase group-hover:text-ies-blue-600 transition">Detalles Seleccionado</span>
                                </label>
                            </div>

                            <div id="contact_list_section">
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nombre</th>
                                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Cargo</th>
                                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-widest">Teléfono</th>
                                                <th class="px-4 py-2 text-center text-[10px] font-bold text-gray-500 uppercase tracking-widest">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contacts_table_body" class="bg-white divide-y divide-gray-100">
                                            @forelse($empresa->contactos as $contacto)
                                                <tr class="hover:bg-gray-50 transition contact-row" data-name="{{ $contacto->nombre }} {{ $contacto->apellidos }}" data-puesto="{{ $contacto->puesto }}">
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $contacto->nombre }} {{ $contacto->apellidos }}</div>
                                                        <div class="text-[10px] text-gray-400 font-medium">{{ $contacto->correo ?? 'Sin email' }}</div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 font-medium">
                                                        {{ $contacto->puesto ?? '-' }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 font-medium">
                                                        {{ $contacto->telefono ?? '-' }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                                        <button type="button" 
                                                                onclick="selectContact({{ json_encode($contacto) }})" 
                                                                class="text-ies-blue-600 hover:text-ies-blue-900 font-bold text-xs uppercase tracking-tight">
                                                            Ver Info
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-400 italic">
                                                        No hay personas de contacto registradas para esta empresa.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="contact_details_section" class="hidden animate-in fade-in duration-300">
                                <div class="bg-white p-6 rounded-xl border-2 border-ies-blue-100 shadow-sm relative">
                                    <button type="button" onclick="toggleContactView('list')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    
                                    <h4 id="detail_name" class="text-xl font-black text-gray-900 mb-1">Nombre del Contacto</h4>
                                    <p id="detail_puesto" class="text-xs font-bold text-ies-blue-600 uppercase tracking-widest mb-6">Cargo en la empresa</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Teléfono de Contacto</p>
                                            <p id="detail_telefono" class="text-sm font-bold text-gray-800 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                -
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Documento (DNI/NIE)</p>
                                            <p id="detail_dni" class="text-sm font-bold text-gray-800 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                                -
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <a id="detail_edit_link" href="#" class="text-[10px] font-bold text-ies-blue-600 hover:text-ies-blue-800 uppercase tracking-widest border-b border-ies-blue-100 hover:border-ies-blue-600 transition">Editar datos de esta persona</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones')" />
                            <textarea id="observaciones" name="observaciones" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('observaciones', $empresa->observaciones) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observaciones')" />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-button onclick="window.location='{{ route('empresas.index') }}'">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Actualizar Empresa') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleSearch(id) {
            const input = document.getElementById(id);
            input.classList.toggle('hidden');
            if (!input.classList.contains('hidden')) {
                input.focus();
            }
        }

        function filterContacts() {
            const input = document.getElementById('search_contacto');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.contact-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const puesto = row.getAttribute('data-puesto').toLowerCase();
                if (name.includes(filter) || puesto.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function toggleContactView(view) {
            const sectionList = document.getElementById('contact_list_section');
            const sectionDetails = document.getElementById('contact_details_section');
            const radios = document.getElementsByName('contact_view_mode');

            if (view === 'list') {
                sectionList.classList.remove('hidden');
                sectionDetails.classList.add('hidden');
                radios[0].checked = true;
            } else {
                sectionList.classList.add('hidden');
                sectionDetails.classList.remove('hidden');
                radios[1].checked = true;
            }
        }

        function selectContact(contacto) {
            document.getElementById('detail_name').innerText = contacto.nombre + ' ' + (contacto.apellidos || '');
            document.getElementById('detail_puesto').innerText = contacto.puesto || 'Sin cargo especificado';
            document.getElementById('detail_telefono').innerHTML = '<svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>' + (contacto.telefono || '-');
            document.getElementById('detail_dni').innerHTML = '<svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>' + (contacto.dni || '-');
            
            // Set edit link (assuming route exists)
            const editUrl = "{{ route('contactos.edit', ':id') }}".replace(':id', contacto.id);
            document.getElementById('detail_edit_link').href = editUrl;
            
            toggleContactView('details');
        }
    </script>
</x-app-layout>
