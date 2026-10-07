<div id="editBusModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <form id="editBusForm" method="POST" class="bg-white p-6 rounded-lg w-full max-w-md space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-bold">Edito Autobusin</h2>
        <input name="plate" id="edit_bus_plate" class="border p-2 w-full rounded" required>
        <input name="model" id="edit_bus_model" class="border p-2 w-full rounded" required>
        <input name="capacity" id="edit_bus_capacity" type="number" min="1" class="border p-2 w-full rounded" required>
        <input name="year" id="edit_bus_year" type="number" min="1900" class="border p-2 w-full rounded" required>
        <select name="status" id="edit_bus_status" class="border p-2 w-full rounded">
            <option value="active">active</option>
            <option value="inactive">inactive</option>
            <option value="maintenance">maintenance</option>
        </select>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeEditBus()" class="px-4 py-2 bg-gray-300 rounded">Anulo</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ruaj</button>
        </div>
    </form>
</div>

<script>
function editBus(btn) {
    const bus = JSON.parse(btn.dataset.bus);
    document.getElementById('editBusForm').action = '/buses/' + bus.id;
    document.getElementById('edit_bus_plate').value = bus.plate;
    document.getElementById('edit_bus_model').value = bus.model;
    document.getElementById('edit_bus_capacity').value = bus.capacity;
    document.getElementById('edit_bus_year').value = bus.year;
    document.getElementById('edit_bus_status').value = bus.status;
    const m = document.getElementById('editBusModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
}
function closeEditBus() {
    const m = document.getElementById('editBusModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
}
</script>