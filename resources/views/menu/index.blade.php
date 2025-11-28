<x-app-layout>
    <div x-data="cafeteriaApp()" x-init="initApp()" class="min-h-screen bg-slate-50 pb-20 font-sans relative">

        @include('menu.partials.tabs_nav')

        <div class="max-w-7xl mx-auto px-4 py-8">

            <div x-show="activeTab === 'menu_del_dia'" x-transition.opacity>
                @include('menu.tabs.menu_del_dia')
            </div>

            <div x-show="activeTab === 'ejecutivos'" style="display: none;" x-transition.opacity>
                @include('menu.tabs.ejecutivos')
            </div>

            <div x-show="activeTab === 'bebidas'" style="display: none;" x-transition.opacity>
                @include('menu.tabs.bebidas')
            </div>

            <div x-show="activeTab === 'postres'" style="display: none;" x-transition.opacity>
                @include('menu.tabs.postres')
            </div>

        </div>

        @include('menu.partials.cart_drawer')

    </div>

    <script>
    function cafeteriaApp() {
        return {
            activeTab: 'menu_del_dia',

            // --- VARIABLES DEL MENÚ DEL DÍA (LO QUE FALTABA) ---
            selectedEntrada: null,
            selectedEntradaPrice: 0, // Nuevo

            selectedFondo: null,
            selectedFondoPrice: 0,   // Nuevo

            selectedRefresco: null,
            selectedRefrescoPrice: 0, // Nuevo

            // --- VARIABLES DEL CARRITO ---
            cart: [],
            isCartOpen: false,

            initApp() {
                // Cargar carrito guardado
                const stored = localStorage.getItem('ucss_food_cart');
                if (stored) {
                    this.cart = JSON.parse(stored);
                }

                this.updateCartCounter();

                window.addEventListener('open-cart-drawer', () => {
                    this.isCartOpen = true;
                });
            },

            // --- ESTA ES LA FUNCIÓN QUE TE FALTABA Y CAUSABA EL ERROR ---
            get totalMenuDelDia() {
                let total = this.selectedEntradaPrice + this.selectedFondoPrice + this.selectedRefrescoPrice;
                return total.toFixed(2);
            },

            addToCart(id, itemName, itemPrice, qty = 1) {
                // Validación: Si es el menú del día, verificar que esté completo
                if (itemName.includes('Menú:') && itemPrice == 0) {
                    alert('Por favor selecciona Entrada, Segundo y Refresco.');
                    return;
                }

                let existingItem = this.cart.find(item => item.id === id);

                if (existingItem) {
                    existingItem.quantity += parseInt(qty);
                } else {
                    this.cart.push({
                        id: id,
                        name: itemName,
                        price: parseFloat(itemPrice),
                        quantity: parseInt(qty)
                    });
                }

                this.saveCart();
                this.isCartOpen = true;

                // Limpiar selección si era un menú armado
                if(this.activeTab === 'menu_del_dia' && itemName.includes('Menú:')) {
                     this.selectedEntrada = null;
                     this.selectedEntradaPrice = 0;
                     this.selectedFondo = null;
                     this.selectedFondoPrice = 0;
                     this.selectedRefresco = null;
                     this.selectedRefrescoPrice = 0;

                     // Truco para desmarcar los radio buttons visualmente
                     document.querySelectorAll('input[type="radio"]').forEach(el => el.checked = false);
                }
            },

            removeFromCart(id) {
                this.cart = this.cart.filter(i => i.id !== id);
                this.saveCart();
            },

            clearCart() {
                this.cart = [];
                this.saveCart();
                this.isCartOpen = false;
            },

            saveCart() {
                localStorage.setItem('ucss_food_cart', JSON.stringify(this.cart));
                this.updateCartCounter();
            },

            updateCartCounter() {
                let count = this.cart.reduce((acc, item) => acc + item.quantity, 0);
                this.$dispatch('update-cart-count', { count: count });
            },

            get total() {
                return this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0).toFixed(2);
            }
        }
    }
</script>
</x-app-layout>
