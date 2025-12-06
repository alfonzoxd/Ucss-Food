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

        // Variables del Menú del Día
        selectedEntrada: null,
        selectedEntradaPrice: 0,
        selectedEntradaId: null,  // ← NUEVO

        selectedFondo: null,
        selectedFondoPrice: 0,
        selectedFondoId: null,    // ← NUEVO

        selectedRefresco: null,
        selectedRefrescoPrice: 0,
        selectedRefrescoId: null, // ← NUEVO

        cart: [],
        isCartOpen: false,

        initApp() {
            const stored = localStorage.getItem('ucss_food_cart');
            if (stored) {
                this.cart = JSON.parse(stored);
            }
            this.updateCartCounter();

            window.addEventListener('open-cart-drawer', () => {
                this.isCartOpen = true;
            });
        },

        get totalMenuDelDia() {
            let total = this.selectedEntradaPrice + this.selectedFondoPrice + this.selectedRefrescoPrice;
            return total.toFixed(2);
        },

        // ✅ NUEVA FUNCIÓN para el Menú del Día
        addMenuDelDiaToCart() {
            if (!this.selectedEntrada || !this.selectedFondo || !this.selectedRefresco) {
                alert('Por favor selecciona Entrada, Segundo y Refresco.');
                return;
            }

            // Crear nombre descriptivo
            const menuName = `Menú: ${this.selectedEntrada} + ${this.selectedFondo} + ${this.selectedRefresco}`;
            const menuPrice = parseFloat(this.totalMenuDelDia);

            // ID único para este menú específico
            const menuId = `menu_${this.selectedEntradaId}_${this.selectedFondoId}_${this.selectedRefrescoId}`;

            // Buscar si ya existe
            let existingItem = this.cart.find(item => item.id === menuId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.cart.push({
                    id: menuId,
                    name: menuName,
                    price: menuPrice,
                    quantity: 1,
                    // ← IMPORTANTE: Guardar los IDs reales de los productos
                    productIds: [
                        this.selectedEntradaId,
                        this.selectedFondoId,
                        this.selectedRefrescoId
                    ]
                });
            }

            this.saveCart();
            this.isCartOpen = true;

            // Limpiar selección
            this.selectedEntrada = null;
            this.selectedEntradaPrice = 0;
            this.selectedEntradaId = null;
            this.selectedFondo = null;
            this.selectedFondoPrice = 0;
            this.selectedFondoId = null;
            this.selectedRefresco = null;
            this.selectedRefrescoPrice = 0;
            this.selectedRefrescoId = null;

            document.querySelectorAll('input[type="radio"]').forEach(el => el.checked = false);
        },

        // Función para productos individuales
        addToCart(id, itemName, itemPrice, qty = 1) {
            if (!id || isNaN(id)) {
                console.error('ID inválido:', id);
                alert('Error: ID de producto inválido');
                return;
            }

            let existingItem = this.cart.find(item => item.id === id);

            if (existingItem) {
                existingItem.quantity += parseInt(qty);
            } else {
                this.cart.push({
                    id: parseInt(id),
                    name: itemName,
                    price: parseFloat(itemPrice),
                    quantity: parseInt(qty)
                });
            }

            this.saveCart();
            this.isCartOpen = true;
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
