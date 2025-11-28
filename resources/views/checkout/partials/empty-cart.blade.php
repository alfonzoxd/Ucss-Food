{{-- resources/views/checkout/partials/empty-cart.blade.php --}}
<div x-show="cart.length === 0"
     style="display: none;"
     class="text-center py-12 sm:py-16 bg-white rounded-2xl shadow-sm border border-slate-200">

    <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-slate-100 mb-4 sm:mb-6 text-slate-400">
        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
    </div>

    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-2 px-4">Tu carrito está vacío</h2>
    <p class="text-sm sm:text-base text-slate-500 mb-6 px-4">Agrega platillos antes de pagar.</p>

    <a href="{{ url('/') }}"
       class="inline-block bg-sky-600 text-white font-bold py-3 px-6 sm:px-8 rounded-xl hover:bg-sky-700 transition-all shadow-lg text-sm sm:text-base">
        Ir al Menú
    </a>
</div>
