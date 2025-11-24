<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative px-4"
         style="background-image: url('{{ asset('images/fondo.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <div class="absolute inset-0 bg-sky-900/30 backdrop-blur-[2px] z-0"></div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 sm:px-8 sm:py-10 bg-white/70 backdrop-blur-lg shadow-[0_20px_50px_rgb(0,0,0,0.2)] overflow-hidden rounded-2xl sm:rounded-2xl border border-white/40 relative z-10">

            <div class="absolute top-0 left-0 -mt-8 -ml-8 w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-white/40 blur-xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 -mb-8 -mr-8 w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-white/40 blur-xl pointer-events-none"></div>

            <div class="flex flex-col items-center mb-6 relative z-10">
                <a href="/" class="transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('images/ucss.png') }}" alt="Logo UCSS" class="h-20 sm:h-24 w-auto object-contain drop-shadow-sm">
                </a>
                <h2 class="mt-4 sm:mt-6 text-xl sm:text-2xl font-extrabold text-gray-800 tracking-tight text-center drop-shadow-sm">
                    Recuperar Contraseña
                </h2>
                <p class="text-sm text-gray-600 mt-2 text-center font-medium leading-relaxed px-2">
                    {{ __('¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo institucional y te enviaremos un enlace para restablecerla.') }}
                </p>
            </div>

            <x-auth-session-status class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm font-bold text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6 relative z-10"
                  x-data="{
                      email: '{{ old('email') }}',
                      touched: { email: false },
                      get validEmail() {
                          return this.email.endsWith('@ucss.pe');
                      },
                      get canSubmit() {
                          return this.validEmail && this.email.length > 0;
                      }
                  }">
                @csrf

                <div class="relative group">
                    <input x-model="email"
                           @blur="touched.email = true"
                           :class="{'border-red-500 ring-red-200': touched.email && !validEmail, 'border-green-400': touched.email && validEmail}"
                           class="block w-full pl-11 pr-4 py-3 border border-gray-200/80 rounded-xl text-sm leading-5 bg-white/60 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-white/90 focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition duration-200 ease-in-out backdrop-blur-sm"
                           type="email"
                           name="email"
                           required
                           autofocus
                           placeholder="correo@ucss.pe" />

                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-sky-600" :class="{'text-red-500': touched.email && !validEmail, 'text-green-600': touched.email && validEmail}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>

                    <p x-show="touched.email && !validEmail" x-cloak class="text-xs text-red-600 font-bold mt-1 ml-1">
                        Debe ser un correo @ucss.pe
                    </p>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600 font-bold ml-1" />
                </div>

                <button type="submit"
                        :class="{'opacity-50 cursor-not-allowed': !canSubmit, 'hover:bg-sky-800': canSubmit}"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-extrabold text-white bg-sky-700/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-200 ease-in-out transform active:scale-[0.98] backdrop-blur-sm">
                    {{ __('ENVIAR ENLACE') }}
                </button>

                <div class="text-center mt-6 pt-4 border-t border-gray-300/50">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-sky-700 hover:text-sky-900 transition duration-150 ease-in-out flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-8 pb-4 sm:pb-0 text-center text-xs text-white font-semibold shadow-black/50 drop-shadow-md relative z-10">
            &copy; {{ date('Y') }} UCSS FOOD. Sistema de Cafetería Universitario.
        </div>
    </div>
</x-guest-layout>
