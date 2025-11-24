<section>
    <header>
        <h2 class="text-lg font-bold text-gray-800">
            {{ __('Información Personal') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Actualiza tus nombres y verifica tu correo institucional.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-sky-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                    </svg>
                </div>
                <input id="first_name" name="first_name" type="text"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl text-sm leading-5 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out shadow-sm"
                    :value="old('first_name', $user->first_name)" required autofocus autocomplete="given-name" placeholder="Nombres" />
                <x-input-error class="mt-2 text-xs text-red-500 font-semibold" :messages="$errors->get('first_name')" />
            </div>

            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-sky-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
                <input id="last_name" name="last_name" type="text"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl text-sm leading-5 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out shadow-sm"
                    :value="old('last_name', $user->last_name)" required autocomplete="family-name" placeholder="Apellidos" />
                <x-input-error class="mt-2 text-xs text-red-500 font-semibold" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
            </div>
            <input id="email" name="email" type="email"
                class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm leading-5 bg-gray-100 text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-200"
                :value="old('email', $user->email)" required readonly />
            <p class="mt-1 ml-1 text-xs text-gray-400 font-medium">* El correo institucional no es editable.</p>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-sky-700 focus:bg-sky-700 active:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform active:scale-95">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold flex items-center bg-green-50 px-3 py-1 rounded-lg border border-green-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('¡Guardado!') }}
                </p>
            @endif
        </div>
    </form>
</section>
