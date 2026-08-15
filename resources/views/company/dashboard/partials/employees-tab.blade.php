{{-- EMPLOYEES TAB --}}
<div id="employees-content" class="tab-content hidden">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Punonjësit</h1>
            <p class="text-gray-500 mt-1">Menaxhimi i ekipit tuaj</p>
        </div>
        <button type="button" onclick="openModal('addEmployeeModal')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">+ Shto Punonjës</button>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Emri</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Posti</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600">Veprimet</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Agim Krasniqi</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Shofer</td>
                    <td class="px-6 py-4 text-sm text-gray-600">agim.krasniqi</td>
                    <td class="px-6 py-4 text-sm text-gray-600">agim@buslog.com</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button onclick="openModal('editEmployeeModal')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Ndrysho</button>
                        <button class="text-red-600 hover:text-red-700 text-sm font-medium">Fshij</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>