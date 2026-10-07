{{-- Add Bus Modal --}}
<div id="addBusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Shto Autobus të Ri</h2>
            <button onclick="closeModal('addBusModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="addBusForm" method="POST" action="{{ route('buses.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tabela (Plate)</label>
                    <input type="text" name="plate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="p.sh: AA-123-AA" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modeli</label>
                    <input type="text" name="model" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="p.sh: Volvo B11R" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kapaciteti</label>
                        <input type="number" name="capacity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="p.sh: 50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Viti</label>
                        <input type="number" name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="p.sh: 2023" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statusi</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="active">Aktiv</option>
                        <option value="inactive">Inaktiv</option>
                        <option value="maintenance">Në Mirëmbajtje</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal('addBusModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Anulo</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Shto</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Bus Modal --}}
<div id="editBusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Përditëso Autobusin</h2>
            <button onclick="closeModal('editBusModal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="editBusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tabela (Plate)</label>
                    <input type="text" name="plate" id="editPlate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modeli</label>
                    <input type="text" name="model" id="editModel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kapaciteti</label>
                        <input type="number" name="capacity" id="editCapacity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Viti</label>
                        <input type="number" name="year" id="editYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statusi</label>
                    <select name="status" id="editStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="active">Aktiv</option>
                        <option value="inactive">Inaktiv</option>
                        <option value="maintenance">Në Mirëmbajtje</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal('editBusModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Anulo</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Përditëso</button>
            </div>
        </form>
    </div>
</div>