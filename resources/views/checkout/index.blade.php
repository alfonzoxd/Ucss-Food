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
