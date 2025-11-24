<div class="bg-white border-b border-slate-200 sticky top-16 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="flex items-center justify-start md:justify-center gap-4 overflow-x-auto scrollbar-hide">
            @foreach(['menu_del_dia' => 'Menú del Día', 'ejecutivos' => 'Ejecutivos', 'bebidas' => 'Bebidas', 'postres' => 'Postres'] as $key => $label)
                <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ? 'bg-sky-600 text-white shadow-md transform scale-105'
                            : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-sky-700'"
                        class="flex-shrink-0 rounded-full px-6 py-2 text-sm font-bold transition-all duration-200 whitespace-nowrap border border-transparent">
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>
</div>
