<x-app-layout>

    <div class="w-full h-28 bg-gray-50"></div>

    <div class="bg-gray-50 pb-20" x-data="checkoutHandler()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-4">

                <div>
                    <h1 class="text-3xl font-black text-slate-800">Finalizar Compra</h1>
                    <p class="text-slate-500 mt-1">
                        Hola, <span class="font-bold text-slate-800">{{ Auth::user()->name }}</span>.
                    </p>
                </div>

                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-700 font-bold py-2 px-6 rounded-xl hover:border-sky-500 hover:text-sky-600 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Volver al Menú
                </a>
            </div>

            <div x-show="cart.length === 0" style="display: none;" class="text-center py-16 bg-white rounded-2xl shadow-sm border border-slate-200">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6 text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Tu carrito está vacío</h2>
                <p class="text-slate-500 mb-6">Agrega platillos antes de pagar.</p>
                <a href="{{ url('/') }}" class="inline-block bg-sky-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-sky-700">
                    Ir al Menú
                </a>
            </div>

            <div x-show="cart.length > 0">
                <div class="flex flex-col lg:flex-row gap-8">

                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                            <h2 class="text-xl font-bold text-slate-700 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Método de Pago
                            </h2>

                            <div class="space-y-4 mb-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Número de Tarjeta</label>
                                    <input type="text" x-model="payment.cardNumber" @input="filterNumbers('cardNumber', 16)" placeholder="0000 0000 0000 0000"
                                           class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500"
                                           :class="{'border-red-500 ring-1 ring-red-500': errors.cardNumber}">
                                    <p x-show="errors.cardNumber" x-text="errors.cardNumber" class="text-red-500 text-xs mt-1 font-bold"></p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Vencimiento (MM/YY)</label>
                                        <input type="text" x-model="payment.expiry" @input="formatExpiry()" placeholder="MM/YY" maxlength="5"
                                               class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500"
                                               :class="{'border-red-500 ring-1 ring-red-500': errors.expiry}">
                                        <p x-show="errors.expiry" x-text="errors.expiry" class="text-red-500 text-xs mt-1 font-bold"></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">CVC</label>
                                        <input type="text" x-model="payment.cvc" @input="filterNumbers('cvc', 3)" placeholder="123" maxlength="3"
                                               class="w-full bg-slate-50 border-slate-200 rounded-lg focus:border-sky-500 focus:ring-sky-500"
                                               :class="{'border-red-500 ring-1 ring-red-500': errors.cvc}">
                                        <p x-show="errors.cvc" x-text="errors.cvc" class="text-red-500 text-xs mt-1 font-bold"></p>
                                    </div>
                                </div>
                            </div>

                            <button @click="processPayment" :disabled="processing"
                                    class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-sky-600 transition-all shadow-lg flex justify-center items-center gap-3">
                                <span x-show="!processing" class="text-lg">PAGAR S/ <span x-text="total.toFixed(2)"></span></span>
                                <span x-show="processing" class="flex items-center gap-2">PROCESANDO...</span>
                            </button>

                            <div x-show="errorMessage" class="mt-4 p-3 bg-red-50 text-red-600 text-sm font-bold text-center rounded-lg border border-red-100">
                                <span x-text="errorMessage"></span>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ url('/') }}" class="text-sm text-slate-400 hover:text-slate-600 underline">Cancelar y Volver al menú</a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-24">
                            <h3 class="font-bold text-slate-800 text-lg border-b pb-4 mb-4">Resumen del Pedido</h3>

                            <div class="max-h-80 overflow-y-auto space-y-4 mb-6 pr-2">
                                <template x-for="item in cart" :key="item.id">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p x-text="item.name" class="font-bold text-slate-700 text-sm"></p>
                                            <p class="text-xs text-slate-500">Cant: <span x-text="item.quantity"></span></p>
                                        </div>
                                        <p class="font-black text-slate-800 text-sm">S/ <span x-text="(item.price * item.quantity).toFixed(2)"></span></p>
                                    </div>
                                </template>
                            </div>

                            <div class="border-t border-slate-100 pt-4 flex justify-between items-center text-xl font-black text-slate-900">
                                <span>Total</span>
                                <span class="text-sky-600">S/ <span x-text="total.toFixed(2)"></span></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function checkoutHandler() {
            return {
                processing: false,
                errorMessage: '',
                cart: [],
                total: 0,
                payment: { cardNumber: '', expiry: '', cvc: '' },
                errors: { cardNumber: '', expiry: '', cvc: '' },

                init() {
                    const storedCart = localStorage.getItem('ucss_food_cart');
                    this.cart = storedCart ? JSON.parse(storedCart) : [];
                    this.calculateTotal();
                },

                calculateTotal() {
                    this.total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                // VALIDACIÓN INSTANTÁNEA (AL ESCRIBIR)
                filterNumbers(field, max) {
                    // 1. Eliminar cualquier cosa que no sea número
                    let val = this.payment[field].replace(/\D/g, '');
                    // 2. Recortar al máximo
                    this.payment[field] = val.slice(0, max);
                    // 3. Limpiar error visual
                    this.errors[field] = '';
                },

                formatExpiry() {
                    let val = this.payment.expiry.replace(/\D/g, '');
                    if (val.length >= 2) {
                        val = val.substring(0, 2) + '/' + val.substring(2, 4);
                    }
                    this.payment.expiry = val;
                    this.errors.expiry = '';
                },

                // VALIDACIÓN FINAL (AL DAR CLICK EN PAGAR)
                validateForm() {
                    let isValid = true;
                    this.errors = { cardNumber: '', expiry: '', cvc: '' }; // Resetear errores

                    // Validar Tarjeta
                    if (this.payment.cardNumber.length < 16) {
                        this.errors.cardNumber = 'Faltan dígitos (Min 16)';
                        isValid = false;
                    }

                    // Validar CVC
                    if (this.payment.cvc.length < 3) {
                        this.errors.cvc = 'Inválido (3 dígitos)';
                        isValid = false;
                    }

                    // Validar Fecha y Vencimiento
                    const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                    if (!expiryRegex.test(this.payment.expiry)) {
                        this.errors.expiry = 'Formato MM/YY';
                        isValid = false;
                    } else {
                        // Lógica de año
                        const parts = this.payment.expiry.split('/');
                        const mm = parseInt(parts[0], 10);
                        const yy = parseInt(parts[1], 10); // "25"

                        const now = new Date();
                        const currentYear = now.getFullYear() % 100; // 25
                        const currentMonth = now.getMonth() + 1;

                        if (yy < currentYear || (yy === currentYear && mm < currentMonth)) {
                            this.errors.expiry = 'Tarjeta Vencida';
                            isValid = false;
                        }
                    }
                    return isValid;
                },

                async processPayment() {
                    this.errorMessage = '';

                    // 1. Ejecutar validación local
                    if (!this.validateForm()) {
                        this.errorMessage = 'Corrige los campos en rojo.';
                        return;
                    }

                    this.processing = true;

                    try {
                        const response = await fetch("{{ route('checkout.process') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                            body: JSON.stringify({
                                cart: this.cart.map(item => ({
                                    id: item.id, label: item.name, price: item.price, qty: item.quantity
                                }))
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            alert('¡Pago Exitoso!');
                            localStorage.removeItem('ucss_food_cart');
                            window.location.href = "/";
                        } else {
                            throw new Error(data.message || 'Error del servidor');
                        }
                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.processing = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
