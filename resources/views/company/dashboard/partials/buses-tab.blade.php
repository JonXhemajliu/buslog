{{-- BUSES TAB --}}
<div id="buses-content" class="tab-content hidden">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Autobusët</h1>
            <p class="text-gray-500 mt-1">Menaxhimi i flotës tuaj</p>
        </div>
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">+ Shto Autobus</button>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Tabela</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Modeli</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Statusi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Shofer</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600">Veprimet</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">PR-001</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Mercedes Sprinter</td>
                    <td class="px-6 py-4"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktiv</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Agim Krasniqi</td>
                    <td class="px-6 py-4 text-right"><button class="text-red-600 hover:text-red-700 text-sm font-medium">Shikoni</button></td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">PR-002</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Volvo B11R</td>
                    <td class="px-6 py-4"><span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Servisim</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Besim Gashi</td>
                    <td class="px-6 py-4 text-right"><button class="text-red-600 hover:text-red-700 text-sm font-medium">Shikoni</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>