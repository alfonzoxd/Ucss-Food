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
            <div class="pointer-events-auto fixed inset-y-0 right-0 flex max-w-full pl-10">

                <div x-show="isCartOpen"
                     @click.away="isCartOpen = false"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md bg-white shadow-2xl flex flex-col h-full">

                    <div class="px-5 py-6 bg-white border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-900">Tu Pedido</h2>
                        <button @click="isCartOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 bg-white">
                        <ul class="space-y-6">
                            <template x-for="item in cart" :key="item.id">
                                <li class="flex items-start border-b border-slate-50 last:border-0 pb-4">
                                    <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-xl bg-slate-50 flex items-center justify-center text-xl border border-slate-100">🍽️</div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-sm font-bold text-slate-900 leading-tight" x-text="item.name"></h3>
                                            <p class="ml-2 text-sm font-bold text-sky-600 whitespace-nowrap" x-text="'S/ ' + (item.price * item.quantity).toFixed(2)"></p>
                                        </div>
                                        <div class="mt-2 flex items-center justify-between">
                                            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 bg-slate-50 px-2 py-1 rounded">
                                                <span>Cant:</span>
                                                <span x-text="item.quantity" class="font-bold text-slate-800"></span>
                                            </div>
                                            <button @click="removeFromCart(item.id)" class="text-xs font-bold text-red-400 hover:text-red-600 transition-colors underline decoration-red-200">Eliminar</button>
                                        </div>
                                    </div>
                                </li>
                            </template>

                            <li x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-center opacity-60">
                                <div class="bg-slate-50 p-6 rounded-full mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                </div>
                                <p class="text-base font-bold text-slate-700">Tu carrito está vacío</p>
                                <p class="text-sm text-slate-400 mt-1">¡Agrega productos del menú!</p>
                            </li>
                        </ul>
                    </div>

                    <div class="border-t border-slate-100 p-6 bg-white">
                        <div class="flex justify-between text-xl font-black text-slate-900 mb-4">
                            <p>Total</p>
                            <p x-text="'S/ ' + parseFloat(total).toFixed(2)"></p>
                        </div>
                        <div class="space-y-3">

                            <button
                                @click="
                                    localStorage.setItem('ucss_food_cart', JSON.stringify(cart));
                                    window.location.href = '{{ route('checkout.index') }}'
                                "
                                class="w-full rounded-xl bg-sky-600 px-6 py-4 text-base font-bold text-white shadow-lg hover:bg-sky-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="cart.length === 0">
                                PAGAR PEDIDO
                            </button>
                            <button @click="clearCart()" x-show="cart.length > 0" class="w-full text-center text-xs font-bold text-red-400 hover:text-red-600">VACIAR CARRITO</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
