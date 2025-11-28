{{-- resources/views/checkout/partials/payment-card.blade.php --}}
<div class="space-y-4 mb-6">
    <div>
        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Número de Tarjeta</label>
        <input type="text"
               x-model="payment.cardNumber"
               @input="filterNumbers('cardNumber', 16)"
               placeholder="0000 0000 0000 0000"
               class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500 text-sm sm:text-base"
               :class="{'border-red-500 ring-1 ring-red-500': errors.cardNumber}">
        <p x-show="errors.cardNumber" x-text="errors.cardNumber" class="text-red-500 text-xs mt-1 font-bold"></p>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Vencimiento (MM/YY)</label>
            <input type="text"
                   x-model="payment.expiry"
                   @input="formatExpiry()"
                   placeholder="MM/YY"
                   maxlength="5"
                   class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500 text-sm sm:text-base"
                   :class="{'border-red-500 ring-1 ring-red-500': errors.expiry}">
            <p x-show="errors.expiry" x-text="errors.expiry" class="text-red-500 text-xs mt-1 font-bold"></p>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">CVC</label>
            <input type="text"
                   x-model="payment.cvc"
                   @input="filterNumbers('cvc', 3)"
                   placeholder="123"
                   maxlength="3"
                   class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500 text-sm sm:text-base"
                   :class="{'border-red-500 ring-1 ring-red-500': errors.cvc}">
            <p x-show="errors.cvc" x-text="errors.cvc" class="text-red-500 text-xs mt-1 font-bold"></p>
        </div>
    </div>
</div>

<button @click="processPayment"
        :disabled="processing"
        class="w-full bg-slate-900 text-white font-bold py-3 sm:py-4 rounded-xl hover:bg-sky-600 transition-all shadow-lg flex justify-center items-center gap-3 text-sm sm:text-base disabled:opacity-50 disabled:cursor-not-allowed">
    <span x-show="!processing" class="text-base sm:text-lg">PAGAR S/ <span x-text="total.toFixed(2)"></span></span>
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
