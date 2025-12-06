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

        {{-- ============================================ --}}
        {{-- NOTIFICACIÓN DE PEDIDO PAGADO (CELESTE) --}}
        {{-- ============================================ --}}
        <div x-show="showSuccessToast"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black bg-opacity-50"
             style="display: none;"
             @click.self="showSuccessToast = false">

            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform">

                {{-- Header con gradiente celeste --}}
                <div class="bg-gradient-to-r from-sky-500 via-cyan-500 to-sky-600 p-6 text-center relative overflow-hidden">
                    {{-- Decoración de fondo --}}
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
                        <div class="absolute bottom-0 right-0 w-40 h-40 bg-white rounded-full translate-x-20 translate-y-20"></div>
                    </div>

                    {{-- Ícono de éxito --}}
                    <div class="relative mb-4 inline-block">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto animate-bounce shadow-lg">
                            <svg class="w-12 h-12 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Título --}}
                    <h2 class="text-3xl font-black text-white mb-2 relative">
                        ¡PEDIDO PAGADO!
                    </h2>
                    <p class="text-white text-sm font-medium relative">
                        Tu pedido ha sido procesado exitosamente
                    </p>
                </div>

                {{-- Contenido --}}
                <div class="p-6">
                    {{-- Monto pagado --}}
                    <div class="bg-gradient-to-br from-sky-50 to-cyan-50 rounded-2xl p-5 mb-6 text-center border-2 border-sky-200">
                        <p class="text-sm text-sky-700 font-medium mb-2">Total Pagado</p>
                        <p class="text-4xl font-black text-sky-600">
                            S/ <span x-text="total.toFixed(2)"></span>
                        </p>
                    </div>

                    {{-- Información adicional --}}
                    <div class="flex items-center justify-center gap-2 mb-6 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Pedido confirmado y en proceso</span>
                    </div>

                    {{-- Botón de acción celeste --}}
                    <button @click="redirectToOrders()"
                            class="w-full bg-gradient-to-r from-sky-600 to-cyan-600 text-white font-bold py-4 px-6 rounded-xl hover:from-sky-700 hover:to-cyan-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3 group mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Ver Estado del Pedido</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>

                    {{-- Contador de redirección --}}
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-3">
                            Redirigiendo automáticamente en
                            <span class="font-bold text-sky-600 text-lg" x-text="redirectCountdown"></span>
                            <span x-text="redirectCountdown === 1 ? 'segundo' : 'segundos'"></span>
                        </p>

                        {{-- Botón cerrar --}}
                        <button @click="showSuccessToast = false"
                                class="text-gray-400 hover:text-gray-600 text-sm font-medium underline transition-colors">
                            Cerrar notificación
                        </button>
                    </div>
                </div>

                {{-- Barra de progreso celeste en la parte inferior --}}
                <div class="h-2 bg-gray-100 relative overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-sky-500 via-cyan-500 to-sky-600 transition-all duration-100"
                         :style="`width: ${(redirectCountdown / 5) * 100}%`"></div>
                </div>
            </div>
        </div>
    </div>

    @include('checkout.scripts.checkout-js')
</x-app-layout>

<style>
/* Animación de rebote para el ícono */
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
