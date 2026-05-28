<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-700 to-blue-800 border-b border-blue-900 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/dashboard') }}">
                        <img src="{{ asset('logo.png') }}" alt="WorkSync" class="h-10 w-auto drop-shadow-md">
                    </a>
                </div>

                <!-- Navigation Links - Solo para usuarios logueados -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                        @if(Auth::user()->role === 'empresa')
                            <x-nav-link :href="url('/company/employees')" :active="request()->routeIs('company.employees')" class="text-white hover:text-blue-200 font-medium">
                                {{ __('Mis empleados') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('cv.index')" :active="request()->routeIs('cv.index')" class="text-white hover:text-blue-200 font-medium">
                                {{ __('Mi CV') }}
                            </x-nav-link>
                        @endif

                        <x-nav-link :href="url('/calendar')" :active="request()->routeIs('calendar.*')" class="text-white hover:text-blue-200 font-medium">
                            {{ __('Calendario') }}
                        </x-nav-link>

                        <x-nav-link :href="url('/documents')" :active="request()->routeIs('documents.*')" class="text-white hover:text-blue-200 font-medium">
                            {{ __('Portafolio') }}
                        </x-nav-link>

                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown - Solo para usuarios logueados -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 border border-transparent text-sm leading-4 font-medium rounded-lg text-white focus:outline-none transition ease-in-out duration-150 backdrop-blur-sm">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 focus:outline-none focus:bg-white focus:bg-opacity-10 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @else
                <!-- Botones para visitantes no logueados -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-200 font-medium">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-blue-200 font-medium">Registrarse</a>
                </div>

                <!-- Hamburger para visitantes -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 focus:outline-none focus:bg-white focus:bg-opacity-10 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-800">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="url('/dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-200">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'empresa')
                    <x-responsive-nav-link :href="url('/company/employees')" :active="request()->routeIs('company.employees')" class="text-white hover:text-blue-200">
                        {{ __('Mis empleados') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('cv.index')" :active="request()->routeIs('cv.index')" class="text-white hover:text-blue-200">
                        {{ __('Mi CV') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="url('/calendar')" :active="request()->routeIs('calendar.*')" class="text-white hover:text-blue-200">
                    {{ __('Calendario') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/documents')" :active="request()->routeIs('documents.*')" class="text-white hover:text-blue-200">
                    {{ __('Portafolio') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-4 pb-1 border-t border-blue-700">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-blue-200">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:text-blue-200">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')" class="text-white hover:text-blue-200">
                    {{ __('Iniciar sesión') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-white hover:text-blue-200">
                    {{ __('Registrarse') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
