<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Formulario de información personal --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Información personal</h3>
                    <p class="text-sm text-gray-600 mb-4">Actualiza tus datos personales y foto de perfil.</p>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="apellidos" :value="__('Apellidos')" />
                            <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full" :value="old('apellidos', $user->apellidos)" />
                            <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $user->telefono)" />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <div>
                            <x-input-label for="direccion" :value="__('Dirección')" />
                            <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $user->direccion)" />
                            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                        </div>

                        <div>
                            <x-input-label for="biografia" :value="__('Biografía')" />
                            <textarea id="biografia" name="biografia" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('biografia', $user->biografia) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('biografia')" />
                        </div>

                        <div>
                            <x-input-label for="foto_perfil" :value="__('Foto de perfil')" />
                            @if($user->foto_perfil)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($user->foto_perfil) }}" class="w-20 h-20 rounded-full object-cover">
                                </div>
                            @endif
                            <input type="file" id="foto_perfil" name="foto_perfil" class="mt-1 block w-full">
                            <p class="text-xs text-gray-500 mt-1">JPEG, PNG. Máx 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto_perfil')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Formulario de cambio de contraseña --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Cambiar contraseña</h3>
                    <p class="text-sm text-gray-600 mb-4">Asegúrate de usar una contraseña segura.</p>

                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="current_password" :value="__('Contraseña actual')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Nueva contraseña')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Formulario de eliminación de cuenta --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Eliminar cuenta</h3>
                    <p class="text-sm text-gray-600 mb-4">Una vez eliminada, no se puede recuperar.</p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('delete')

                        <div>
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Tu contraseña" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-danger-button>{{ __('Eliminar cuenta') }}</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
