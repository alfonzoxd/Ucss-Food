{{-- resources/views/checkout/scripts/checkout.js.blade.php --}}
<script>
    function checkoutHandler() {
        return {
            processing: false,
            errorMessage: '',
            cart: [],
            total: 0,
            paymentMethod: 'card', // 'card', 'yape', 'plin'
            payment: {
                // Tarjeta
                cardNumber: '',
                expiry: '',
                cvc: '',
                // Yape
                yapeNumber: '',
                yapeOperation: '',
                // Plin
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
            },

            calculateTotal() {
                this.total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            // ============ VALIDACIÓN DE CAMPOS ============
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

            // ============ VALIDACIÓN POR MÉTODO DE PAGO ============
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

            // ============ PROCESAR PAGO ============
            async processPayment() {
                this.errorMessage = '';

                if (!this.validateForm()) {
                    this.errorMessage = 'Por favor corrige los campos marcados en rojo.';
                    return;
                }

                this.processing = true;

                try {
                    const response = await fetch("{{ route('checkout.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            paymentMethod: this.paymentMethod,
                            cart: this.cart.map(item => ({
                                id: item.id,
                                label: item.name,
                                price: item.price,
                                qty: item.quantity
                            })),
                            paymentData: this.payment
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert(`¡Pago Exitoso con ${this.paymentMethod.toUpperCase()}!`);
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
