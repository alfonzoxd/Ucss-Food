<x-app-layout>
    <div class="min-h-screen bg-sky-50 py-12 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-64 h-64 rounded-full bg-white blur-3xl opacity-40 pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-white blur-3xl opacity-40 pointer-events-none translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            <div class="flex justify-between items-end px-4 sm:px-0">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                        Mi <span class="text-sky-600">Perfil</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Gestión de cuenta UCSS FOOD</p>
                </div>

                <a href="{{ route('menu.index') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition duration-200 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al Menú
                </a>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-sky-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-sky-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-sky-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
