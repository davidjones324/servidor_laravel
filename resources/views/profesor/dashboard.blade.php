<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-ies-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-ies-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Control — Profesor') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Green accent banner -->
            <div class="bg-gradient-to-r from-ies-green-500 to-ies-green-600 rounded-xl shadow-sm p-5 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold">Bienvenido al Sistema de Gestión FCT</h3>
                        <p class="text-ies-green-100 text-sm mt-1">IES Delgado Hernández — Curso {{ date('Y') . '/' . (date('Y') + 1) }}</p>
                    </div>
                    <div class="hidden sm:block text-4xl">🎓</div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card group hover:shadow-md transition-shadow duration-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Alumnos Registrados</p>
                                <p class="mt-2 text-3xl font-bold text-ies-blue-600">{{ \App\Models\Alumno::count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-ies-blue-100 rounded-xl flex items-center justify-center group-hover:bg-ies-blue-200 transition-colors">
                                <span class="text-2xl">👨‍🎓</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group hover:shadow-md transition-shadow duration-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Empresas Colaboradoras</p>
                                <p class="mt-2 text-3xl font-bold text-ies-green-600">{{ \App\Models\Empresa::count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-ies-green-100 rounded-xl flex items-center justify-center group-hover:bg-ies-green-200 transition-colors">
                                <span class="text-2xl">🏢</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card group hover:shadow-md transition-shadow duration-200">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Acuerdos Activos</p>
                                <p class="mt-2 text-3xl font-bold text-ies-blue-700">{{ \App\Models\Acuerdo::count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-ies-blue-100 rounded-xl flex items-center justify-center group-hover:bg-ies-blue-200 transition-colors">
                                <span class="text-2xl">📄</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-bold text-gray-800 mb-5">Accesos Directos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('alumnos.index') }}" class="group p-5 border border-gray-100 rounded-xl hover:border-ies-blue-300 hover:bg-ies-blue-50 transition-all duration-200 text-center">
                            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🎓</div>
                            <div class="font-semibold text-gray-700 group-hover:text-ies-blue-700">Gestionar Alumnos</div>
                        </a>
                        <a href="{{ route('empresas.index') }}" class="group p-5 border border-gray-100 rounded-xl hover:border-ies-green-300 hover:bg-ies-green-50 transition-all duration-200 text-center">
                            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🏢</div>
                            <div class="font-semibold text-gray-700 group-hover:text-ies-green-700">Gestionar Empresas</div>
                        </a>
                        <a href="{{ route('acuerdos.index') }}" class="group p-5 border border-gray-100 rounded-xl hover:border-ies-blue-300 hover:bg-ies-blue-50 transition-all duration-200 text-center">
                            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📄</div>
                            <div class="font-semibold text-gray-700 group-hover:text-ies-blue-700">Gestionar Acuerdos</div>
                        </a>
                        <a href="{{ route('import.form') }}" class="group p-5 border border-gray-100 rounded-xl hover:border-ies-green-300 hover:bg-ies-green-50 transition-all duration-200 text-center">
                            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📥</div>
                            <div class="font-semibold text-gray-700 group-hover:text-ies-green-700">Importar Datos</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
