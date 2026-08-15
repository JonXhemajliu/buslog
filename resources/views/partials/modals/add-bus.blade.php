{{-- Modal: Shto Autobus --}}
<div id="add-bus-backdrop"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">
    <div class="w-full max-w-sm bg-white rounded-2xl p-6">

        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display font-semibold text-lg">Autobus i ri</h3>
            <button onclick="closeAddBusModal()" class="text-gray-400 hover:text-gray-700">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="add-bus-form" onsubmit="submitAddBus(event)" class="flex flex-col gap-4">
            <div>
                <label class="text-xs font-medium text-gray-600">Emri i autobusit</label>
                <input id="new-bus-name" type="text" required
                       class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="p.sh. Autobusi Nr.4">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">Viti i prodhimit</label>
                <input id="new-bus-year" type="number" min="1980" max="2026" required
                       class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="2020">
            </div>
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition">
                Shto autobusin
            </button>
        </form>

    </div>
</div>