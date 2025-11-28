{{-- resources/views/checkout/partials/order-summary.blade.php --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 sticky top-24">
    <h3 class="font-bold text-slate-800 text-base sm:text-lg border-b pb-3 sm:pb-4 mb-3 sm:mb-4">Resumen del Pedido</h3>

    <div class="max-h-60 sm:max-h-80 overflow-y-auto space-y-3 sm:space-y-4 mb-4 sm:mb-6 pr-2">
        <template x-for="item in cart" :key="item.id">
            <div class="flex justify-between items-start gap-2">
                <div class="flex-1 min-w-0">
                    <p x-text="item.name" class="font-bold text-slate-700 text-xs sm:text-sm truncate"></p>
                    <p class="text-[10px] sm:text-xs text-slate-500">
                        Cant: <span x-text="item.quantity" class="font-bold"></span> ×
                        S/ <span x-text="item.price.toFixed(2)"></span>
                    </p>
                </div>
                <p class="font-black text-slate-800 text-xs sm:text-sm whitespace-nowrap">
                    S/ <span x-text="(item.price * item.quantity).toFixed(2)"></span>
                </p>
            </div>
        </template>
    </div>

    <div class="space-y-2 border-t border-slate-100 pt-3 sm:pt-4">
        <div class="flex justify-between text-xs sm:text-sm text-slate-600">
            <span class="font-medium">Subtotal</span>
            <span class="font-bold">S/ <span x-text="total.toFixed(2)"></span></span>
        </div>
        <div class="flex justify-between text-xs sm:text-sm text-slate-600">
            <span class="font-medium">Descuento</span>
            <span class="font-bold text-green-600">- S/ 0.00</span>
        </div>
    </div>

    <div class="border-t border-slate-200 pt-3 sm:pt-4 mt-3 sm:mt-4 flex justify-between items-center">
        <span class="text-base sm:text-xl font-black text-slate-900">Total</span>
        <span class="text-xl sm:text-2xl font-black text-sky-600">S/ <span x-text="total.toFixed(2)"></span></span>
    </div>

    <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-sky-50 rounded-lg border border-sky-100">
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-sky-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-[10px] sm:text-xs text-sky-700 font-medium">
                Tu pedido será procesado inmediatamente después de confirmar el pago.
            </p>
        </div>
    </div>
</div>
