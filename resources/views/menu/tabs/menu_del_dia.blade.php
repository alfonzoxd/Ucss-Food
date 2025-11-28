<div class="mt-6 pb-32 relative">

    <div class="relative bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-10 shadow-sm overflow-hidden group">
        <div class="relative z-10">
            <span class="inline-block px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-bold mb-2 tracking-wide">MENÚ EJECUTIVO</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800">Arma tu Almuerzo</h2>
            <div class="flex flex-col xs:flex-row xs:items-center gap-1 xs:gap-2 mt-1">
                <p class="text-slate-500 font-medium text-sm sm:text-base">Entrada + Segundo + Refresco por:</p>
                <span class="text-xl sm:text-2xl font-black text-sky-600">S/ <span x-text="totalMenuDelDia"></span></span>
            </div>
        </div>
    </div>

    <div class="mb-8 sm:mb-12 scroll-mt-24">
        <h3 class="text-xl sm:text-2xl font-black text-slate-800 mb-4 sm:mb-6">Entradas</h3>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 items-start">
            @forelse($entradas as $entrada)
                <label class="block cursor-pointer group relative h-full">
                    <input type="radio"
                           name="entrada"
                           x-model="selectedEntrada"
                           value="{{ $entrada['label'] }}"
                           @change="selectedEntradaPrice = {{ $entrada['price'] }}"
                           class="peer hidden">

                    <div class="bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl overflow-hidden transition-all duration-300 h-full flex flex-col hover:border-sky-400 hover:shadow-xl peer-checked:border-sky-600 peer-checked:ring-2 sm:peer-checked:ring-4 peer-checked:ring-sky-200 peer-checked:shadow-2xl peer-checked:shadow-sky-200/50 peer-checked:scale-105">

                         <div class="absolute top-2 right-2 sm:top-3 sm:right-3 z-20 bg-sky-600 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center shadow-lg opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>

                        <div class="h-32 sm:h-40 md:h-44 w-full relative bg-gray-50 overflow-hidden">
                            <img src="{{ route('product.image', $entrada['ref']) }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110 peer-checked:scale-105">
                            <div class="absolute inset-0 bg-sky-600/10 opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <div class="p-2 sm:p-3 md:p-4 text-center flex-1 flex flex-col items-center justify-center transition-all duration-300 peer-checked:bg-sky-50">
                            <h4 class="font-bold text-slate-700 text-xs sm:text-sm leading-tight group-hover:text-sky-700 transition-colors peer-checked:text-sky-800">{{ $entrada['label'] }}</h4>
                            <span class="text-[10px] sm:text-xs text-sky-600 font-bold mt-1 peer-checked:text-sky-700">+ S/ {{ number_format($entrada['price'], 2) }}</span>
                        </div>
                    </div>
                </label>
            @empty
            @endforelse
        </div>
    </div>

    <div class="mb-8 sm:mb-12 transition-all duration-500" :class="selectedEntrada ? 'opacity-100' : 'opacity-40 grayscale pointer-events-none'">
        <h3 class="text-xl sm:text-2xl font-black text-slate-800 mb-4 sm:mb-6">Fondos</h3>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 items-start">
            @forelse($fondos as $fondo)
                <label class="block cursor-pointer group relative h-full">
                    <input type="radio"
                           name="fondo"
                           x-model="selectedFondo"
                           value="{{ $fondo['label'] }}"
                           @change="selectedFondoPrice = {{ $fondo['price'] }}"
                           class="peer hidden"
                           :disabled="!selectedEntrada">

                    <div class="bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl overflow-hidden transition-all duration-300 h-full flex flex-col hover:border-sky-400 hover:shadow-xl peer-checked:border-sky-600 peer-checked:ring-2 sm:peer-checked:ring-4 peer-checked:ring-sky-200 peer-checked:shadow-2xl peer-checked:shadow-sky-200/50 peer-checked:scale-105">

                        <div class="absolute top-2 right-2 sm:top-3 sm:right-3 z-20 bg-sky-600 text-white rounded-full w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center shadow-lg opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>

                        <div class="h-32 sm:h-40 md:h-44 w-full relative bg-gray-50 overflow-hidden">
                            <img src="{{ route('product.image', $fondo['ref']) }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110 peer-checked:scale-105">
                            <div class="absolute inset-0 bg-sky-600/10 opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <div class="p-2 sm:p-3 md:p-4 text-center flex-1 flex flex-col items-center justify-center transition-all duration-300 peer-checked:bg-sky-50">
                            <h4 class="font-bold text-slate-700 text-xs sm:text-sm leading-tight group-hover:text-sky-700 transition-colors peer-checked:text-sky-800">{{ $fondo['label'] }}</h4>
                            <span class="text-[10px] sm:text-xs text-sky-600 font-bold mt-1 peer-checked:text-sky-700">+ S/ {{ number_format($fondo['price'], 2) }}</span>
                        </div>
                    </div>
                </label>
            @empty
            @endforelse
        </div>
    </div>

    <div class="mb-8 sm:mb-12 transition-all duration-500" :class="selectedFondo ? 'opacity-100' : 'opacity-40 grayscale pointer-events-none'">
        <h3 class="text-xl sm:text-2xl font-black text-slate-800 mb-4 sm:mb-6">Refrescos</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 items-start">
            @forelse($refrescos as $refresco)
                <label class="block cursor-pointer group relative h-full">
                    <input type="radio"
                           name="refresco"
                           x-model="selectedRefresco"
                           value="{{ $refresco['label'] }}"
                           @change="selectedRefrescoPrice = {{ $refresco['price'] }}"
                           class="peer hidden"
                           :disabled="!selectedFondo">

                    <div class="bg-white border-2 border-slate-100 rounded-xl sm:rounded-2xl overflow-hidden transition-all duration-300 h-full flex flex-col hover:border-sky-400 hover:shadow-xl peer-checked:border-sky-600 peer-checked:ring-2 sm:peer-checked:ring-4 peer-checked:ring-sky-200 peer-checked:shadow-2xl peer-checked:shadow-sky-200/50 peer-checked:scale-105">

                         <div class="absolute top-2 right-2 z-20 bg-sky-600 text-white rounded-full w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center shadow-lg opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>

                        <div class="h-28 sm:h-32 md:h-36 w-full relative bg-sky-50/30 p-2 overflow-hidden flex items-center justify-center">
                            <img src="{{ route('product.image', $refresco['ref']) }}" class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-110 peer-checked:scale-105">
                            <div class="absolute inset-0 bg-sky-600/10 opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        <div class="p-2 sm:p-3 text-center flex-1 flex flex-col items-center justify-center bg-white transition-all duration-300 peer-checked:bg-sky-50">
                            <h4 class="font-bold text-slate-700 text-xs sm:text-sm leading-tight group-hover:text-sky-700 transition-colors peer-checked:text-sky-800">{{ $refresco['label'] }}</h4>
                            <span class="text-[10px] text-sky-600 font-bold mt-1 peer-checked:text-sky-700">+ S/ {{ number_format($refresco['price'], 2) }}</span>
                        </div>
                    </div>
                </label>
            @empty
            @endforelse
        </div>
    </div>

</div>
<div x-show="selectedEntrada && selectedFondo && selectedRefresco"
     x-transition:enter="transition ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-500"
     x-transition:enter-start="opacity-0 translate-y-20 scale-90"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     class="fixed bottom-4 sm:bottom-6 left-0 right-0 z-50 flex justify-center px-3 sm:px-4 pointer-events-none">

    <button
        @click="addToCart(
            Date.now(),
            'Menú: ' + selectedEntrada + ' + ' + selectedFondo + ' + ' + selectedRefresco,
            totalMenuDelDia
        )"
        class="pointer-events-auto bg-slate-900 text-white rounded-full p-2 pr-4 sm:pr-8 shadow-2xl shadow-sky-900/50 hover:scale-105 transition-transform duration-300 flex items-center gap-2 sm:gap-4 border-2 sm:border-4 border-white ring-1 ring-slate-200">

        <div class="bg-sky-500 text-white w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center font-black text-lg sm:text-xl shadow-inner">
            S/<span x-text="totalMenuDelDia"></span>
        </div>

        <div class="flex flex-col items-start text-left">
            <span class="text-[10px] sm:text-[11px] text-sky-300 font-bold uppercase tracking-wider">¡Menú Listo!</span>
            <span class="text-base sm:text-lg font-bold text-white leading-none">AÑADIR AL CARRITO</span>
        </div>

        <div class="ml-1 sm:ml-2 animate-bounce-x">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </div>
    </button>
</div>
