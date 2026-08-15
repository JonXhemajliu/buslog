{{-- Quick Actions --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Veprimet e Shpejta</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <button onclick="switchTab('buses')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <p class="text-sm font-medium text-gray-900">Shto Autobus</p>
        </button>
        <button onclick="switchTab('employees')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <p class="text-sm font-medium text-gray-900">Shto Punonjës</p>
        </button>
        <button class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium text-gray-900">Shikoni Raportet</p>
        </button>
        <button class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-sm font-medium text-gray-900">Cilësimet</p>
        </button>
    </div>
</div>