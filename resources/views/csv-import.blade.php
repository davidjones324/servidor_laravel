<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-5-8l-5-5m0 0l-5 5m5-5v12"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Importar Datos (CSV)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Importar Alumnos -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies p-6 border-l-4 border-ies-blue-600">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-ies-blue-50 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Alumnos</h3>
                    </div>
                    <form action="{{ route('import.alumnos') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="relative">
                            <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ies-blue-50 file:text-ies-blue-700 hover:file:bg-ies-blue-100 transition cursor-pointer" required>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center shadow-lg shadow-ies-blue-600/20">Procesar CSV Alumnos</button>
                    </form>
                </div>

                <!-- Importar Empresas -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies p-6 border-l-4 border-ies-green-500">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-ies-green-50 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-ies-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Empresas</h3>
                    </div>
                    <form action="{{ route('import.empresas') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ies-green-50 file:text-ies-green-700 hover:file:bg-ies-green-100 transition cursor-pointer" required>
                        <button type="submit" class="btn-secondary w-full justify-center shadow-lg shadow-ies-green-600/20">Procesar CSV Empresas</button>
                    </form>
                </div>

                <!-- Importar Tutores Duales -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies p-6 border-l-4 border-ies-green-600">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-gray-50 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><path d="M20 8v6M23 11h-6"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Tutores Duales</h3>
                    </div>
                    <form action="{{ route('import.tutores') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition cursor-pointer" required>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150">Procesar CSV Tutores</button>
                    </form>
                </div>

                <!-- Importar Responsables -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl card-ies p-6 border-l-4 border-ies-blue-700">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-gray-50 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Responsables</h3>
                    </div>
                    <form action="{{ route('import.responsables') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition cursor-pointer" required>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 transition duration-150">Procesar CSV Responsables</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
