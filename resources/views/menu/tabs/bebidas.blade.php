<!-- Header de Bebidas -->
<div class="relative bg-white border border-slate-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm overflow-hidden group">
    <div class="absolute top-0 right-0 w-32 h-32 bg-sky-100 rounded-full blur-3xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
    <div class="relative z-10">
        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold mb-2 tracking-wide">BEBIDAS</span>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-800">Refréscate</h2>
        <p class="text-slate-600 font-medium text-sm sm:text-base mt-1">Bebidas frías y calientes para acompañar tu comida perfectamente.</p>
    </div>
</div>

<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
    @forelse($bebidas as $bebida)
        <div x-data="{ qty: 1 }"
             class="bg-white rounded-xl sm:rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-100 flex flex-col h-full group overflow-hidden relative">

            <div class="h-36 sm:h-44 md:h-48 bg-sky-50/50 p-4 sm:p-6 flex items-center justify-center relative overflow-hidden">
                <div class="absolute bg-sky-100 w-24 h-24 sm:w-32 sm:h-32 rounded-full blur-2xl opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>

                <img src="{{ route('product.image', $bebida['ref']) }}"
                     class="relative z-10 w-full h-full object-contain drop-shadow-md group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 ease-out">
            </div>

            <div class="p-3 sm:p-4 md:p-5 flex flex-col flex-1">

                <div class="mb-3 sm:mb-4">
                    <div class="flex justify-between items-start gap-2">
                        <h4 class="font-bold text-slate-800 text-sm sm:text-base md:text-lg leading-tight group-hover:text-sky-600 transition-colors">
                            {{ $bebida['label'] }}
                        </h4>
                        <span class="font-black text-sky-700 text-sm sm:text-base md:text-lg whitespace-nowrap">
                            S/ {{ number_format($bebida['price'], 2) }}
                        </span>
                    </div>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-1 font-medium">Bebida refrescante</p>
                </div>

                <div class="mt-auto pt-3 sm:pt-4 border-t border-slate-50">
                    <div class="flex items-center justify-between gap-2 sm:gap-3">

                        <div class="flex items-center bg-slate-100 rounded-full px-1 py-1 shadow-inner">
                            <button @click="qty > 1 ? qty-- : null"
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full bg-white text-slate-600 shadow-sm hover:text-sky-600 hover:scale-105 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="qty <= 1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                            </button>

                            <span class="w-6 sm:w-8 text-center font-black text-slate-700 text-xs sm:text-sm" x-text="qty"></span>

                            <button @click="qty++"
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full bg-white text-sky-600 shadow-sm hover:bg-sky-600 hover:text-white hover:scale-105 transition">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>

                        <button @click="addToCart({{ $bebida['id'] }}, '{{ $bebida['label'] }}', {{ $bebida['price'] }}, qty); qty = 1"
                                class="flex-1 bg-sky-600 text-white h-9 sm:h-10 rounded-full font-bold text-xs sm:text-sm shadow-lg shadow-sky-200 hover:bg-sky-700 hover:shadow-sky-300 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-1 sm:gap-2 group/btn">
                            <span class="hidden xs:inline">Agregar</span>
                            <span class="inline xs:hidden">+</span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center py-8 sm:py-12 text-center opacity-60">
            <div class="bg-sky-50 p-3 sm:p-4 rounded-full mb-3">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-sky-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-sm sm:text-base text-slate-500 font-medium">No hay bebidas disponibles.</p>
        </div>
    @endforelse
</div>
