<div class="bg-white border-b border-slate-200 sticky top-16 z-30 shadow-sm backdrop-blur-sm bg-white/95">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <nav class="flex items-center justify-start md:justify-center gap-2 sm:gap-3 overflow-x-auto scrollbar-hide">
            @foreach([
                'menu_del_dia' => ['label' => 'Menú del Día', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'sky'],
                'ejecutivos' => ['label' => 'Ejecutivos', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'color' => 'amber'],
                'bebidas' => ['label' => 'Bebidas', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'blue'],
                'postres' => ['label' => 'Postres', 'icon' => 'M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z', 'color' => 'pink']
            ] as $key => $data)
                <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ? 'bg-{{ $data['color'] }}-600 text-white shadow-lg shadow-{{ $data['color'] }}-200 scale-105 ring-2 ring-{{ $data['color'] }}-200'
                            : 'bg-white text-slate-600 hover:bg-slate-50 hover:text-{{ $data['color'] }}-600 border-slate-200'"
                        class="flex-shrink-0 rounded-xl px-3 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-bold transition-all duration-300 whitespace-nowrap border-2 flex items-center gap-1.5 sm:gap-2 group">

                    <!-- Icono -->
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-transform duration-300"
                         :class="activeTab === '{{ $key }}' ? 'rotate-0' : 'group-hover:scale-110'"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"/>
                    </svg>

                    <!-- Label -->
                    <span>{{ $data['label'] }}</span>

                    <!-- Indicador activo -->
                    <div x-show="activeTab === '{{ $key }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-0"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="w-1.5 h-1.5 rounded-full bg-white ml-1 animate-pulse">
                    </div>
                </button>
            @endforeach
        </nav>

        <!-- Indicador de scroll en móvil -->
        <div class="md:hidden flex justify-center mt-2">
            <div class="flex gap-1">
                @foreach(['menu_del_dia', 'ejecutivos', 'bebidas', 'postres'] as $index => $key)
                    <div class="h-1 rounded-full transition-all duration-300"
                         :class="activeTab === '{{ $key }}' ? 'w-6 bg-sky-600' : 'w-1 bg-slate-300'">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
