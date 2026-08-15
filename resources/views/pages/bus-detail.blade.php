{{-- ============ BUS DETAIL PAGE ============ --}}
<div id="page-bus-detail" class="page">

    @include('partials.navbar', ['showLogout' => true])

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- Butoni prapa --}}
        <button onclick="showPage('page-dashboard')"
                class="flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 mb-4">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Autobusët e mi
        </button>

        {{-- Header i autobusit --}}
        <div class="flex items-center gap-4 p-5 rounded-2xl border border-gray-200 mb-8">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="11" rx="2"/>
                    <path d="M3 11h18"/><path d="M7 16v3M17 16v3"/>
                    <circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                </svg>
            </div>
            <div>
                <h2 id="detail-name" class="font-display font-semibold text-xl leading-tight"></h2>
                <p id="detail-year" class="text-sm text-gray-500"></p>
            </div>
        </div>

        {{-- Llojet e servisimit --}}
        <h3 class="font-display font-semibold text-lg mb-3">Selekto shërbimin ose defektin</h3>
        <div id="type-grid" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6"></div>

        {{-- Forma e servisimit (shfaqet pas selektimit) --}}
        <form id="service-form" onsubmit="submitService(event)"
              class="hidden bg-gray-50 rounded-2xl border border-gray-200 p-5 mb-10">
            <p class="text-sm mb-4">
                Lloji i zgjedhur:
                <span id="selected-type-label" class="font-semibold text-red-600"></span>
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-xs font-medium text-gray-600">Çmimi (€)</label>
                    <input id="service-price" type="number" min="0" step="0.01" required
                           class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="0.00">
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600">Auto-mekaniku</label>
                    <input id="service-mechanic" type="text" required
                           class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-red-500"
                           placeholder="p.sh. Fatlum Krasniqi">
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600">Data</label>
                    <input id="service-date" type="date" required
                           class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>
            <div class="mb-4">
                <label class="text-xs font-medium text-gray-600">Shënim (opsional)</label>
                <textarea id="service-note" rows="2"
                          class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                                 focus:outline-none focus:ring-2 focus:ring-red-500"
                          placeholder="Detaje shtesë…"></textarea>
            </div>
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                Regjistro servisimin
            </button>
        </form>

        {{-- Historiku i servisimeve (renditet me JS) --}}
        <h3 class="font-display font-semibold text-lg mb-3">Historiku i servisimeve</h3>
        <div id="service-history" class="flex flex-col gap-2"></div>

    </div>
</div>