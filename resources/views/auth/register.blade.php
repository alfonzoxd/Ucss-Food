<x-guest-layout>
    <div x-data="{
            first_name: '{{ old('first_name') }}',
            last_name: '{{ old('last_name') }}',
            email: '{{ old('email') }}',
            password: '',
            password_confirmation: '',
            touched: { first_name: false, last_name: false, email: false, password: false, confirmation: false },

            // Validaciones
            get validEmail() {
                return this.email.includes('@') && this.email.endsWith('@ucss.pe');
            },
            get validPassword() {
                return this.password.length >= 8;
            },
            get passwordsMatch() {
                return this.password === this.password_confirmation;
            },
            get canSubmit() {
                return this.first_name.length > 1 &&
                       this.last_name.length > 1 &&
                       this.validEmail &&
                       this.validPassword &&
                       this.passwordsMatch;
            }
         }"
         class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative px-4"
         style="background-image: url('{{ asset('images/fondo.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <div class="absolute inset-0 bg-sky-900/30 backdrop-blur-[2px] z-0"></div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 sm:px-8 sm:py-10 bg-white/70 backdrop-blur-lg shadow-[0_20px_50px_rgb(0,0,0,0.2)] overflow-hidden rounded-2xl sm:rounded-2xl border border-white/40 relative z-10">

            <div class="absolute top-0 left-0 -mt-8 -ml-8 w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-white/40 blur-xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 -mb-8 -mr-8 w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-white/40 blur-xl pointer-events-none"></div>

            <div class="flex flex-col items-center mb-6 sm:mb-8 relative z-10">
                <a href="/" class="transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('images/ucss.png') }}" alt="Logo UCSS" class="h-20 sm:h-24 w-auto object-contain drop-shadow-sm">
                </a>
                <h2 class="mt-4 sm:mt-6 text-xl sm:text-2xl font-extrabold text-gray-800 tracking-tight text-center drop-shadow-sm">
                    Crea tu cuenta
                </h2>
                <p class="text-sm text-gray-600 mt-2 text-center font-bold leading-tight">
                    Únete a <span class="text-sky-700">UCSS FOOD</span> hoy mismo
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5 relative z-10">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="relative group">
                        <input x-model="first_name"
                               @blur="touched.first_name = true"
                               :class="{'border-red-500 ring-red-200': touched.first_name && first_name.length < 2}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                               type="text" name="first_name" required autofocus placeholder="Nombres" />

                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.first_name && first_name.length < 2}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                            </svg>
                        </div>
                        <p x-show="touched.first_name && first_name.length < 2" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Ingresa tu nombre</p>
                    </div>

                    <div class="relative group">
                        <input x-model="last_name"
                               @blur="touched.last_name = true"
                               :class="{'border-red-500 ring-red-200': touched.last_name && last_name.length < 2}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                               type="text" name="last_name" required placeholder="Apellidos" />

                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.last_name && last_name.length < 2}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <p x-show="touched.last_name && last_name.length < 2" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Ingresa tus apellidos</p>
                    </div>
                </div>

                <div class="relative group">
                    <input x-model="email"
                           @blur="touched.email = true"
                           :class="{'border-red-500 ring-red-200': touched.email && !validEmail, 'border-green-400': touched.email && validEmail}"
                           class="block w-full pl-11 pr-4 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                           type="email" name="email" required autocomplete="username" placeholder="correo@ucss.pe" />

                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.email && !validEmail, 'text-green-600': touched.email && validEmail}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>

                    <p x-show="touched.email && !email.includes('@')" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Falta el signo @</p>
                    <p x-show="touched.email && email.includes('@') && !validEmail" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Debe terminar en @ucss.pe</p>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600 font-bold ml-1" />
                </div>

                <div class="relative group" x-data="{ show: false }">
                    <input x-model="password"
                           @blur="touched.password = true"
                           :class="{'border-red-500': touched.password && !validPassword}"
                           :type="show ? 'text' : 'password'"
                           class="block w-full pl-11 pr-11 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                           name="password" required autocomplete="new-password" placeholder="Contraseña" />

                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.password && !validPassword}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-sky-700 cursor-pointer focus:outline-none">
                         <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                         <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.732 5.732A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.056 10.056 0 01-2.07 3.407M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                    </button>

                    <p x-show="touched.password && !validPassword" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Mínimo 8 caracteres</p>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600 font-bold ml-1" />
                </div>

                <div class="relative group" x-data="{ show: false }">
                    <input x-model="password_confirmation"
                           @blur="touched.confirmation = true"
                           :class="{'border-red-500': touched.confirmation && !passwordsMatch, 'border-green-400': touched.confirmation && passwordsMatch && validPassword}"
                           :type="show ? 'text' : 'password'"
                           class="block w-full pl-11 pr-11 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                           name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña" />

                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.confirmation && !passwordsMatch, 'text-green-600': touched.confirmation && passwordsMatch && validPassword}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-sky-700 cursor-pointer focus:outline-none">
                         <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                         <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.732 5.732A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.056 10.056 0 01-2.07 3.407M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                    </button>

                    <p x-show="touched.confirmation && !passwordsMatch" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">Las contraseñas no coinciden</p>
                </div>

                <button type="submit"
                        :class="{'opacity-50 cursor-not-allowed': !canSubmit, 'hover:bg-sky-800': canSubmit}"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-extrabold text-white bg-sky-700/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-200 ease-in-out transform active:scale-[0.98] backdrop-blur-sm">
                    CREAR CUENTA
                </button>

                <div class="text-center mt-6 sm:mt-8 pt-6 border-t border-gray-300/50">
                    <p class="text-sm text-gray-700 font-medium">
                        ¿Ya estás registrado?
                        <a href="{{ route('login') }}" class="font-bold text-sky-700 hover:text-sky-900 transition duration-150 ease-in-out ml-1">
                            Inicia Sesión
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <div class="mt-8 pb-4 sm:pb-0 text-center text-xs text-white font-semibold shadow-black/50 drop-shadow-md relative z-10">
            &copy; {{ date('Y') }} UCSS FOOD. Sistema de Cafetería Universitario.
        </div>
    </div>
</x-guest-layout>
