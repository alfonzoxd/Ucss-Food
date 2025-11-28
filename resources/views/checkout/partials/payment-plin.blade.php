{{-- resources/views/checkout/partials/payment-plin.blade.php --}}
<div class="space-y-4 sm:space-y-6">

    <!-- Header Plin -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl p-4 sm:p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h3 class="text-lg sm:text-xl font-black">Paga con Plin</h3>
                <p class="text-xs sm:text-sm text-teal-100">Escanea el QR o ingresa el número</p>
            </div>
            <div class="bg-white rounded-lg p-2">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
        </div>
        <div class="text-xl sm:text-2xl font-black">S/ <span x-text="total.toFixed(2)"></span></div>
    </div>

    <!-- QR Code -->
    <div class="bg-white border-2 border-teal-200 rounded-xl p-4 sm:p-6">
        <div class="text-center">
            <p class="text-xs sm:text-sm font-bold text-slate-600 mb-3 sm:mb-4">Escanea este código QR con tu app Plin</p>
            <div class="inline-block bg-white p-3 sm:p-4 rounded-xl border-2 border-slate-200 shadow-sm">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=plin://pay?number=987654321&amount={{ $total ?? '0' }}"
                     alt="QR Plin"
                     class="w-32 h-32 sm:w-48 sm:h-48">
            </div>
        </div>
    </div>

    <!-- O separador -->
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-xs sm:text-sm">
            <span class="px-2 bg-white text-slate-500 font-bold">O INGRESA EL NÚMERO</span>
        </div>
    </div>

    <!-- Número de Plin -->
    <div class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Número de Celular Plin</label>
            <input type="text"
                   x-model="payment.plinNumber"
                   @input="filterNumbers('plinNumber', 9)"
                   placeholder="987 654 321"
                   class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-teal-500 focus:ring-teal-500 text-sm sm:text-base"
                   :class="{'border-red-500 ring-1 ring-red-500': errors.plinNumber}">
            <p x-show="errors.plinNumber" x-text="errors.plinNumber" class="text-red-500 text-xs mt-1 font-bold"></p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Número de Operación (Opcional)</label>
            <input type="text"
                   x-model="payment.plinOperation"
                   placeholder="Ej: 123456789"
                   class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-teal-500 focus:ring-teal-500 text-sm sm:text-base">
            <p class="text-xs text-slate-400 mt-1">Ingresa el número después de realizar el pago</p>
        </div>
    </div>

    <button @click="processPayment"
            :disabled="processing"
            class="w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold py-3 sm:py-4 rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all shadow-lg flex justify-center items-center gap-3 text-sm sm:text-base disabled:opacity-50 disabled:cursor-not-allowed">
        <span x-show="!processing" class="text-base sm:text-lg">CONFIRMAR PAGO S/ <span x-text="total.toFixed(2)"></span></span>
        <span x-show="processing" class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            PROCESANDO...
        </span>
    </button>

    <div x-show="errorMessage"
         x-transition
         class="mt-4 p-3 bg-red-50 text-red-600 text-xs sm:text-sm font-bold text-center rounded-lg border border-red-100">
        <span x-text="errorMessage"></span>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ url('/') }}" class="text-xs sm:text-sm text-slate-400 hover:text-slate-600 underline">Cancelar y Volver al menú</a>
    </div>

</div>
