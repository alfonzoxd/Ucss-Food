<div class="relative z-[100]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

    <div x-show="isCartOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
         @click="isCartOpen = false"></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none" x-show="isCartOpen">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-auto fixed inset-y-0 right-0 flex max-w-full pl-4 sm:pl-10">

                <div x-show="isCartOpen"
                     @click.away="isCartOpen = false"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md bg-white shadow-2xl flex flex-col h-full">

                    <!-- Header del carrito -->
                    <div class="px-4 sm:px-6 py-5 sm:py-6 bg-gradient-to-r from-sky-50 to-white border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-sky-600 rounded-full p-2 shadow-lg">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-lg sm:text-xl font-black text-slate-900">Tu Pedido</h2>
                                <p class="text-xs text-slate-500 font-medium" x-show="cart.length > 0">
                                    <span x-text="cart.length"></span> <span x-text="cart.length === 1 ? 'producto' : 'productos'"></span>
                                </p>
                            </div>
                        </div>
                        <button @click="isCartOpen = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-2 rounded-full transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Lista de productos -->
                    <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-50">
                        <ul class="space-y-4">
                            <template x-for="item in cart" :key="item.id">
                                <li class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow">
                                    <div class="flex items-center p-4">
                                        <!-- Imagen del producto -->
                                        <div class="h-20 w-20 sm:h-24 sm:w-24 flex-shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-sky-50 to-slate-50 flex items-center justify-center border-2 border-slate-100 relative">
                                            <template x-if="item.image">
                                                <img :src="item.image" :alt="item.name" class="h-full w-full object-cover">
                                            </template>
                                            <template x-if="!item.image">
                                                <span class="text-3xl sm:text-4xl">🍽️</span>
                                            </template>
                                            <!-- Badge de cantidad -->
                                            <div class="absolute -top-2 -right-2 bg-sky-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs font-bold shadow-lg border-2 border-white">
                                                <span x-text="item.quantity"></span>
                                            </div>
                                        </div>

                                        <!-- Detalles del producto -->
                                        <div class="ml-4 flex-1 min-w-0">
                                            <div class="flex justify-between items-start gap-2 mb-2">
                                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-tight line-clamp-2" x-text="item.name"></h3>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <!-- Precio unitario y total -->
                                                <div class="flex flex-col gap-1">
                                                    <p class="text-xs text-slate-500">
                                                        S/ <span x-text="item.price.toFixed(2)"></span> c/u
                                                    </p>
                                                    <p class="text-base sm:text-lg font-black text-sky-600">
                                                        S/ <span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                                    </p>
                                                </div>

                                                <!-- Controles de cantidad -->
                                                <div class="flex items-center gap-2">
                                                    <button @click="item.quantity > 1 ? item.quantity-- : removeFromCart(item.id)"
                                                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg w-8 h-8 flex items-center justify-center transition-colors font-bold">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                                                    </button>

                                                    <button @click="item.quantity++"
                                                            class="bg-sky-600 hover:bg-sky-700 text-white rounded-lg w-8 h-8 flex items-center justify-center transition-colors font-bold">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón eliminar -->
                                    <div class="px-4 pb-3 flex justify-end">
                                        <button @click="removeFromCart(item.id)"
                                                class="text-xs font-bold text-red-400 hover:text-red-600 transition-colors flex items-center gap-1 hover:gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </li>
                            </template>

                            <!-- Estado vacío -->
                            <li x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-center py-12">
                                <div class="bg-white p-8 rounded-full mb-6 shadow-sm border-4 border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                </div>
                                <p class="text-lg font-black text-slate-700 mb-2">Tu carrito está vacío</p>
                                <p class="text-sm text-slate-500">¡Agrega deliciosos productos del menú!</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Footer con resumen y botones -->
                    <div class="border-t border-slate-200 bg-white">
                        <!-- Resumen del pedido -->
                        <div x-show="cart.length > 0" class="px-4 sm:px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span class="font-medium">Subtotal</span>
                                    <span class="font-bold" x-text="'S/ ' + parseFloat(total).toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span class="font-medium">Descuento</span>
                                    <span class="font-bold text-green-600">- S/ 0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total y botones -->
                        <div class="px-4 sm:px-6 py-4 sm:py-6">
                            <div class="flex justify-between items-center mb-5">
                                <p class="text-lg sm:text-xl font-black text-slate-900">Total</p>
                                <p class="text-2xl sm:text-3xl font-black text-sky-600" x-text="'S/ ' + parseFloat(total).toFixed(2)"></p>
                            </div>

                            <div class="space-y-3">
                                <button
                                    @click="
                                        localStorage.setItem('ucss_food_cart', JSON.stringify(cart));
                                        window.location.href = '{{ route('checkout.index') }}'
                                    "
                                    class="w-full rounded-xl bg-sky-600 px-6 py-4 text-base font-bold text-white shadow-lg hover:bg-sky-700 hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-sky-600 disabled:hover:shadow-lg flex items-center justify-center gap-2"
                                    :disabled="cart.length === 0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    PAGAR PEDIDO
                                </button>

                                <button
                                    @click="isCartOpen = false"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all">
                                    SEGUIR COMPRANDO
                                </button>

                                <button
                                    @click="clearCart()"
                                    x-show="cart.length > 0"
                                    class="w-full text-center text-xs font-bold text-red-400 hover:text-red-600 py-2 flex items-center justify-center gap-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    VACIAR CARRITO
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
