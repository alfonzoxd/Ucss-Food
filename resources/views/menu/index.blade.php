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
                selectedEntrada: null,
                selectedFondo: null,
                selectedRefresco: null,
                cart: [],
                isCartOpen: false,

                initApp() {
                    // Escuchar evento desde el Navbar (navigation.blade.php)
                    window.addEventListener('open-cart-drawer', () => {
                        this.isCartOpen = true;
                    });
                },

                addToCart(itemName, itemPrice, qty = 1) {
                    let existingItem = this.cart.find(item => item.name === itemName);
                    if (existingItem) {
                        existingItem.quantity += parseInt(qty);
                    } else {
                        this.cart.push({
                            id: Date.now(),
                            name: itemName,
                            price: parseFloat(itemPrice),
                            quantity: parseInt(qty)
                        });
                    }
                    this.updateCartCounter();
                    // Abrimos el carrito automáticamente al agregar (opcional)
                    this.isCartOpen = true;

                    // Reseteamos selecciones del menú del día para que puedan armar otro
                    if(this.activeTab === 'menu_del_dia') {
                         this.selectedEntrada = null;
                         this.selectedFondo = null;
                         this.selectedRefresco = null;
                    }
                },

                removeFromCart(id) {
                    this.cart = this.cart.filter(i => i.id !== id);
                    this.updateCartCounter();
                },

                clearCart() {
                    this.cart = [];
                    this.updateCartCounter();
                    this.isCartOpen = false;
                },

                updateCartCounter() {
                    let count = this.cart.reduce((acc, item) => acc + item.quantity, 0);
                    // Enviamos el evento hacia arriba para que lo capture el Navbar
                    this.$dispatch('update-cart-count', { count: count });
                },

                get total() {
                    return this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0).toFixed(2);
                }
            }
        }
    </script>
</x-app-layout>
