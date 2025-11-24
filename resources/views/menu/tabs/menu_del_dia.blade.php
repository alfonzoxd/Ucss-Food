<div class="mt-8">
    <div class="bg-gradient-to-r from-sky-600 to-blue-800 rounded-3xl p-8 mb-12 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform origin-bottom-left"></div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left">
            <div class="bg-white/20 p-4 rounded-full backdrop-blur-sm shadow-inner">
                <span class="text-4xl">🔥</span>
            </div>
            <div>
                <h3 class="text-3xl font-black tracking-tight">Arma tu Menú</h3>
                <p class="text-sky-100 font-medium text-lg mt-1">Entrada + Fondo + Refresco por <span class="bg-white text-sky-800 px-3 py-1 rounded-lg font-black shadow-sm">S/ 12.00</span></p>
            </div>
        </div>
    </div>

    <div class="mb-16">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-lg shadow-sky-200">1</span>
            <h3 class="text-xl font-bold text-slate-800">Elige tu Entrada</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($entradas as $entrada)
                <label class="cursor-pointer relative group h-full">
                    <input type="radio" name="entrada" x-model="selectedEntrada" value="{{ $entrada['label'] }}" class="hidden">

                    <div class="bg-white rounded-3xl transition-all duration-300 h-full flex flex-col overflow-hidden relative group-hover:-translate-y-1"
                         :class="selectedEntrada === '{{ $entrada['label'] }}'
                            ? 'ring-4 ring-sky-500 shadow-xl shadow-sky-100'
                            : 'ring-1 ring-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg'">

                        <div class="h-40 overflow-hidden relative">
                            <img src="{{ route('product.image', $entrada['ref']) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">

                            <div x-show="selectedEntrada === '{{ $entrada['label'] }}'"
                                 x-transition.scale
                                 class="absolute inset-0 bg-sky-600/30 backdrop-blur-[1px] flex items-center justify-center">
                                <div class="bg-white text-sky-600 rounded-full p-2 shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 text-center flex-1 flex items-center justify-center bg-gradient-to-b from-white to-slate-50">
                            <h4 class="font-bold text-slate-700 text-sm leading-tight">{{ $entrada['label'] }}</h4>
                        </div>
                    </div>
                </label>
            @empty
                <p class="col-span-full text-center text-slate-400">No hay entradas disponibles.</p>
            @endforelse
        </div>
    </div>

    <div class="mb-16 opacity-50 transition-opacity duration-300" :class="{'opacity-100': selectedEntrada}">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-lg shadow-sky-200">2</span>
            <h3 class="text-xl font-bold text-slate-800">Elige tu Fondo</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($fondos as $fondo)
                <label class="cursor-pointer relative group h-full">
                    <input type="radio" name="fondo" x-model="selectedFondo" value="{{ $fondo['label'] }}" class="hidden" :disabled="!selectedEntrada">

                    <div class="bg-white rounded-3xl transition-all duration-300 h-full flex flex-col overflow-hidden relative group-hover:-translate-y-1"
                         :class="selectedFondo === '{{ $fondo['label'] }}'
                            ? 'ring-4 ring-sky-500 shadow-xl shadow-sky-100'
                            : 'ring-1 ring-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg'">

                        <div class="h-40 overflow-hidden relative">
                            <img src="{{ route('product.image', $fondo['ref']) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">

                            <div x-show="selectedFondo === '{{ $fondo['label'] }}'"
                                 x-transition.scale
                                 class="absolute inset-0 bg-sky-600/30 backdrop-blur-[1px] flex items-center justify-center">
                                <div class="bg-white text-sky-600 rounded-full p-2 shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 text-center flex-1 flex items-center justify-center bg-gradient-to-b from-white to-slate-50">
                            <h4 class="font-bold text-slate-700 text-sm leading-tight">{{ $fondo['label'] }}</h4>
                        </div>
                    </div>
                </label>
            @empty
                <p class="col-span-full text-center text-slate-400">No hay fondos disponibles.</p>
            @endforelse
        </div>
    </div>

    <div class="mb-32 opacity-50 transition-opacity duration-300" :class="{'opacity-100': selectedFondo}">
        <div class="flex items-center gap-3 mb-6">
            <span class="bg-sky-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold shadow-lg shadow-sky-200">3</span>
            <h3 class="text-xl font-bold text-slate-800">Elige tu Refresco (Cortesía)</h3>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($refrescos as $refresco)
                <label class="cursor-pointer relative group h-full">
                    <input type="radio" name="refresco" x-model="selectedRefresco" value="{{ $refresco['label'] }}" class="hidden" :disabled="!selectedFondo">

                    <div class="bg-white rounded-2xl transition-all duration-300 h-full flex flex-col overflow-hidden relative group-hover:-translate-y-1"
                         :class="selectedRefresco === '{{ $refresco['label'] }}'
                            ? 'ring-4 ring-sky-500 shadow-xl shadow-sky-100'
                            : 'ring-1 ring-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg'">

                        <div class="h-24 sm:h-32 overflow-hidden relative bg-sky-50 flex items-center justify-center p-2">
                             <img src="{{ route('product.image', $refresco['ref']) }}" class="h-full w-full object-contain group-hover:scale-110 transition-transform duration-500">

                            <div x-show="selectedRefresco === '{{ $refresco['label'] }}'"
                                 x-transition.scale
                                 class="absolute inset-0 bg-sky-600/30 backdrop-blur-[1px] flex items-center justify-center">
                                <div class="bg-white text-sky-600 rounded-full p-1.5 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 text-center flex-1 flex items-center justify-center bg-white">
                            <h4 class="font-bold text-slate-700 text-xs sm:text-sm leading-tight">{{ $refresco['label'] }}</h4>
                        </div>
                    </div>
                </label>
            @empty
                <p class="col-span-full text-center text-slate-400">No hay refrescos disponibles.</p>
            @endforelse
        </div>
    </div>

    <div x-show="selectedEntrada && selectedFondo && selectedRefresco"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-6 left-0 right-0 z-40 flex justify-center px-4 pointer-events-none">

        <button @click="addToCart('Menú: ' + selectedEntrada + ' + ' + selectedFondo + ' + ' + selectedRefresco, 12.00)"
                class="pointer-events-auto bg-sky-700 text-white px-8 py-4 rounded-full font-bold shadow-2xl shadow-sky-900/20 hover:bg-sky-800 hover:scale-105 transition-all flex items-center gap-4 border-4 border-white ring-1 ring-slate-200 group">

            <div class="flex flex-col items-start leading-none">
                <span class="text-[10px] text-sky-200 font-medium tracking-wider">TODO LISTO</span>
                <span class="text-base">AGREGAR MENÚ COMPLETO</span>
            </div>

            <div class="bg-white text-sky-800 px-3 py-1.5 rounded-lg font-black text-lg shadow-sm group-hover:bg-sky-50 transition-colors">
                S/ 12.00
            </div>
        </button>
    </div>
</div>
