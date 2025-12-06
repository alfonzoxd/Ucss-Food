{{-- resources/views/checkout/scripts/checkout-js.blade.php --}}
<script>
    function checkoutHandler() {
        return {
            processing: false,
            errorMessage: '',
            showSuccessToast: false, // ⬅️ Toast en lugar de modal
            redirectCountdown: 5, // ⬅️ Contador de 5 segundos
            cart: [],
            total: 0,
            paymentMethod: 'card',
            payment: {
                cardNumber: '',
                expiry: '',
                cvc: '',
                yapeNumber: '',
                yapeOperation: '',
                plinNumber: '',
                plinOperation: ''
            },
            errors: {
                cardNumber: '',
                expiry: '',
                cvc: '',
                yapeNumber: '',
                plinNumber: ''
            },

            init() {
                const storedCart = localStorage.getItem('ucss_food_cart');
                this.cart = storedCart ? JSON.parse(storedCart) : [];
                this.calculateTotal();

                console.log('Carrito cargado:', JSON.stringify(this.cart, null, 2));
            },

            calculateTotal() {
                this.total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            filterNumbers(field, max) {
                let val = this.payment[field].replace(/\D/g, '');
                this.payment[field] = val.slice(0, max);
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

            validateCard() {
                let isValid = true;
                this.errors = { cardNumber: '', expiry: '', cvc: '', yapeNumber: '', plinNumber: '' };

                if (this.payment.cardNumber.length < 16) {
                    this.errors.cardNumber = 'Faltan dígitos (Mín 16)';
                    isValid = false;
                }

                if (this.payment.cvc.length < 3) {
                    this.errors.cvc = 'Inválido (3 dígitos)';
                    isValid = false;
                }

                const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                if (!expiryRegex.test(this.payment.expiry)) {
                    this.errors.expiry = 'Formato MM/YY';
                    isValid = false;
                } else {
                    const parts = this.payment.expiry.split('/');
                    const mm = parseInt(parts[0], 10);
                    const yy = parseInt(parts[1], 10);
                    const now = new Date();
                    const currentYear = now.getFullYear() % 100;
                    const currentMonth = now.getMonth() + 1;

                    if (yy < currentYear || (yy === currentYear && mm < currentMonth)) {
                        this.errors.expiry = 'Tarjeta Vencida';
                        isValid = false;
                    }
                }
                return isValid;
            },

            validateYape() {
                let isValid = true;
                this.errors = { cardNumber: '', expiry: '', cvc: '', yapeNumber: '', plinNumber: '' };

                if (this.payment.yapeNumber.length !== 9) {
                    this.errors.yapeNumber = 'Número inválido (9 dígitos)';
                    isValid = false;
                }

                return isValid;
            },

            validatePlin() {
                let isValid = true;
                this.errors = { cardNumber: '', expiry: '', cvc: '', yapeNumber: '', plinNumber: '' };

                if (this.payment.plinNumber.length !== 9) {
                    this.errors.plinNumber = 'Número inválido (9 dígitos)';
                    isValid = false;
                }

                return isValid;
            },

            validateForm() {
                if (this.paymentMethod === 'card') {
                    return this.validateCard();
                } else if (this.paymentMethod === 'yape') {
                    return this.validateYape();
                } else if (this.paymentMethod === 'plin') {
                    return this.validatePlin();
                }
                return false;
            },

            async processPayment() {
                this.errorMessage = '';

                if (!this.validateForm()) {
                    this.errorMessage = 'Por favor corrige los campos marcados en rojo.';
                    return;
                }

                this.processing = true;

                try {
                    const cartFormatted = this.cart.map(item => {
                        const cartItem = {
                            id: item.id,
                            label: item.name,
                            price: item.price,
                            qty: item.quantity
                        };

                        if (item.productIds && Array.isArray(item.productIds)) {
                            cartItem.productIds = item.productIds;
                        }

                        return cartItem;
                    });

                    console.log('Carrito formateado para envío:', JSON.stringify(cartFormatted, null, 2));

                    const payload = {
                        paymentMethod: this.paymentMethod,
                        cart: cartFormatted,
                        paymentData: this.payment
                    };

                    console.log('Payload completo:', JSON.stringify(payload, null, 2));

                    const response = await fetch("{{ route('checkout.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();
                    console.log('Respuesta del servidor:', data);

                    if (data.success) {
                        // Mostrar el toast
                        this.showSuccessToast = true;

                        // Limpiar el carrito
                        localStorage.removeItem('ucss_food_cart');
                        this.cart = [];

                        // Iniciar cuenta regresiva de 5 segundos
                        this.startRedirectCountdown();

                    } else {
                        throw new Error(data.message || 'Error del servidor');
                    }
                } catch (error) {
                    console.error('Error en processPayment:', error);
                    this.errorMessage = error.message;
                } finally {
                    this.processing = false;
                }
            },

            // ⬇️ NUEVA FUNCIÓN: Contador regresivo
            startRedirectCountdown() {
                this.redirectCountdown = 5;

                const interval = setInterval(() => {
                    this.redirectCountdown--;

                    if (this.redirectCountdown <= 0) {
                        clearInterval(interval);
                        this.redirectToOrders();
                    }
                }, 1000); // Cada 1 segundo
            },

            // ⬇️ NUEVA FUNCIÓN: Redirigir a Mis Pedidos
            redirectToOrders() {
                window.location.href = "{{ route('orders.index') }}";
            }
        }
    }
</script>
