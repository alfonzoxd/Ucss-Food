{{-- resources/views/checkout/partials/header.blade.php --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 sm:mb-8 border-b border-gray-200 pb-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-800">Finalizar Compra</h1>
        <p class="text-sm sm:text-base text-slate-500 mt-1">
            Hola, <span class="font-bold text-slate-800">{{ Auth::user()->name ?? Auth::user()->first_name }}</span>.        </p>
    </div>

    <a href="{{ url('/') }}"
       class="inline-flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-700 font-bold py-2 px-4 sm:px-6 rounded-xl hover:border-sky-500 hover:text-sky-600 transition-all shadow-sm text-sm sm:text-base">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span class="hidden xs:inline">Volver al Menú</span>
        <span class="inline xs:hidden">Volver</span>
    </a>
</div>
