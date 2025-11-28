<!-- Header de Platos Ejecutivos -->
<div class="relative bg-white border border-slate-200 rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm overflow-hidden group">
    <div class="absolute top-0 right-0 w-32 h-32 bg-sky-100 rounded-full blur-3xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
    <div class="relative z-10">
        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold mb-2 tracking-wide">PLATOS EJECUTIVOS</span>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-800">Selección Premium</h2>
        <p class="text-slate-600 font-medium text-sm sm:text-base mt-1">Platos completos listos para disfrutar. Calidad gourmet, precio justo.</p>
    </div>
</div>

<div class="mt-6 sm:mt-8 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
    @forelse($ejecutivos as $ejecutivo)
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-100 flex flex-col h-full group overflow-hidden relative hover:-translate-y-2">

            <div class="h-36 sm:h-44 md:h-48 bg-sky-50/50 p-4 sm:p-6 flex items-center justify-center relative overflow-hidden">
                <div class="absolute bg-sky-100 w-24 h-24 sm:w-32 sm:h-32 rounded-full blur-2xl opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>

                <img src="{{ route('product.image', $ejecutivo['ref']) }}"
                     class="relative z-10 w-full h-full object-cover rounded-lg shadow-sm group-hover:scale-110 group-hover:rotate-1 transition-transform duration-500 ease-out">
            </div>

            <div class="p-3 sm:p-4 md:p-5 flex flex-col flex-1">

                <div class="mb-3 sm:mb-4">
                    <div class="flex justify-between items-start gap-2">
                        <h4 class="font-bold text-slate-800 text-sm sm:text-base md:text-lg leading-tight group-hover:text-sky-600 transition-colors">
                            {{ $ejecutivo['label'] }}
                        </h4>
                        <span class="font-black text-sky-700 text-sm sm:text-base md:text-lg whitespace-nowrap">
                            S/ {{ number_format($ejecutivo['price'], 2) }}
                        </span>
                    </div>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-1 font-medium">Plato Ejecutivo</p>
                </div>

                <div class="mt-auto pt-3 sm:pt-4 border-t border-slate-50">
                    <button @click="addToCart({{ $ejecutivo['id'] }}, '{{ $ejecutivo['label'] }}', {{ $ejecutivo['price'] }}, 1)"
                            class="w-full bg-sky-600 text-white h-9 sm:h-10 rounded-full font-bold text-xs sm:text-sm shadow-lg shadow-sky-200 hover:bg-sky-700 hover:shadow-sky-300 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-1 sm:gap-2 group/btn">
                        <span class="hidden xs:inline">Agregar al Pedido</span>
                        <span class="inline xs:hidden">Agregar</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center py-8 sm:py-12 text-center opacity-60">
            <div class="bg-sky-50 p-3 sm:p-4 rounded-full mb-3">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-sky-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-sm sm:text-base text-slate-500 font-medium">No hay platos ejecutivos disponibles hoy.</p>
        </div>
    @endforelse
</div>
