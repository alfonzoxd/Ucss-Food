{{-- resources/views/checkout/partials/payment-methods.blade.php --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">

    <h2 class="text-lg sm:text-xl font-bold text-slate-700 mb-4 sm:mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Método de Pago
    </h2>

    <!-- Tabs de métodos de pago -->
    <div class="flex gap-2 sm:gap-3 mb-6 border-b border-slate-200 overflow-x-auto">
        <button @click="paymentMethod = 'card'"
                :class="paymentMethod === 'card' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-3 border-b-2 font-bold text-xs sm:text-sm transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span>Tarjeta</span>
        </button>

        <button @click="paymentMethod = 'yape'"
                :class="paymentMethod === 'yape' ? 'border-purple-600 text-purple-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-3 border-b-2 font-bold text-xs sm:text-sm transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span>Yape</span>
        </button>

        <button @click="paymentMethod = 'plin'"
                :class="paymentMethod === 'plin' ? 'border-teal-600 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-3 border-b-2 font-bold text-xs sm:text-sm transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span>Plin</span>
        </button>
    </div>

    <!-- Contenido de cada método -->
    <div x-show="paymentMethod === 'card'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
        @include('checkout.partials.payment-card')
    </div>

    <div x-show="paymentMethod === 'yape'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
        @include('checkout.partials.payment-yape')
    </div>

    <div x-show="paymentMethod === 'plin'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
        @include('checkout.partials.payment-plin')
    </div>

</div>
