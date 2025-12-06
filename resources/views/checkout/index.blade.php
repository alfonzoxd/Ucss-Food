{{-- resources/views/checkout/index.blade.php --}}
<x-app-layout>
    @section('title', 'Checkout - UCSS Food')

    <div class="w-full h-28 bg-gray-50"></div>

    <div class="bg-gray-50 pb-20" x-data="checkoutHandler()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @include('checkout.partials.header')

            @include('checkout.partials.empty-cart')

            <div x-show="cart.length > 0">
                <div class="flex flex-col lg:flex-row gap-6 sm:gap-8">

                    <div class="lg:w-2/3">
                        @include('checkout.partials.payment-methods')
                    </div>

                    <div class="lg:w-1/3">
                        @include('checkout.partials.order-summary')
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('checkout.scripts.checkout-js')
</x-app-layout>

{{-- Agregar este toast al final de checkout/index.blade.php, justo antes de @include('checkout.scripts.checkout-js') --}}

{{-- Notificación Flotante de Éxito --}}
<div x-show="showSuccessToast"
     x-transition:enter="transition ease-out duration-500 transform"
     x-transition:enter-start="translate-x-full opacity-0"
     x-transition:enter-end="translate-x-0 opacity-100"
     x-transition:leave="transition ease-in duration-300 transform"
     x-transition:leave-start="translate-x-0 opacity-100"
     x-transition:leave-end="translate-x-full opacity-0"
     class="fixed top-4 right-4 z-50 w-full max-w-md"
     style="display: none;">

    <div class="bg-white rounded-2xl shadow-2xl border-2 border-green-400 overflow-hidden mx-4 sm:mx-0">

        {{-- Barra de progreso animada --}}
        <div class="h-1.5 bg-gray-100 relative overflow-hidden">
            <div class="h-full bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 animate-progress-bar"
                 style="animation: progressBar 5s linear forwards;"></div>
        </div>

        {{-- Contenido principal --}}
        <div class="p-6">

            {{-- Header con ícono --}}
            <div class="flex items-start gap-4 mb-4">
                <div class="flex-shrink-0">
                    <div class="h-14 w-14 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-8 w-8 text-green-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-xl font-black text-gray-900 mb-1">
                        ¡Gracias por tu Compra!
                    </h3>
                    <p class="text-sm text-gray-600 font-medium">
                        Tu pedido ha sido registrado exitosamente
                    </p>
                </div>

                {{-- Botón cerrar --}}
                <button @click="showSuccessToast = false"
                        class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Información del pedido --}}
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 mb-4 border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600 font-medium">Total Pagado:</span>
                    <span class="text-2xl font-black text-green-600">
                        S/ <span x-text="total.toFixed(2)"></span>
                    </span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Procesando tu pedido...</span>
                </div>
            </div>

            {{-- Call to action --}}
            <button @click="redirectToOrders()"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3 group transform hover:scale-105">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span>Mira el Estado de tu Pedido Aquí</span>
                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>

            {{-- Contador --}}
            <p class="text-center text-xs text-gray-500 mt-3 font-medium">
                Redirigiendo automáticamente en <span class="font-bold text-blue-600" x-text="redirectCountdown"></span>s
            </p>
        </div>
    </div>
</div>

<style>
@keyframes progressBar {
    0% {
        width: 100%;
    }
    100% {
        width: 0%;
    }
}

.animate-progress-bar {
    transition: width 0.1s linear;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .8;
    }
}
</style>
