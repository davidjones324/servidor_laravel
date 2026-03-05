<nav x-data="{ open: false }" class="bg-ies-blue-600 border-b border-ies-blue-700 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <span class="text-white font-bold text-xl tracking-tight">IES DH</span>
                        <span class="hidden sm:inline text-ies-blue-200 text-sm font-medium">| Gestión FCT</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->isProfesor())
                        <x-nav-link :href="route('alumnos.index')" :active="request()->routeIs('alumnos.*')">
                            {{ __('Alumnos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('empresas.index')" :active="request()->routeIs('empresas.*')">
                            {{ __('Empresas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tutores.index')" :active="request()->routeIs('tutores.*')">
                            {{ __('Tutores') }}
                        </x-nav-link>
                        <x-nav-link :href="route('responsables.index')" :active="request()->routeIs('responsables.*')">
                            {{ __('Responsables') }}
                        </x-nav-link>
                        <x-nav-link :href="route('acuerdos.index')" :active="request()->routeIs('acuerdos.*')">
                            {{ __('Acuerdos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('import.form')" :active="request()->routeIs('import.form')">
                            {{ __('Importar') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-ies-blue-400 text-sm leading-4 font-medium rounded-lg text-white bg-ies-blue-500 hover:bg-ies-blue-400 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-ies-blue-200 hover:text-white hover:bg-ies-blue-500 focus:outline-none focus:bg-ies-blue-500 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-ies-blue-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isProfesor())
                <x-responsive-nav-link :href="route('alumnos.index')" :active="request()->routeIs('alumnos.*')">
                    {{ __('Alumnos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('empresas.index')" :active="request()->routeIs('empresas.*')">
                    {{ __('Empresas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('acuerdos.index')" :active="request()->routeIs('acuerdos.*')">
                    {{ __('Acuerdos') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-ies-blue-500">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-ies-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
