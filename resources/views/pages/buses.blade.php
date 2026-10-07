@extends('layouts.app')

@section('content')

<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Autobusët</h1>
        <button onclick="showModal('busAddModal')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Shto Autobus
        </button>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if($buses->count())
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2">Tabela</th>
                    <th class="border border-gray-300 p-2">Modeli</th>
                    <th class="border border-gray-300 p-2">Kapaciteti</th>
                    <th class="border border-gray-300 p-2">Viti</th>
                    <th class="border border-gray-300 p-2">Statusi</th>
                    <th class="border border-gray-300 p-2">Veprimet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $bus->plate }}</td>
                        <td class="border border-gray-300 p-2">{{ $bus->model }}</td>
                        <td class="border border-gray-300 p-2">{{ $bus->capacity }}</td>
                        <td class="border border-gray-300 p-2">{{ $bus->year }}</td>
                        <td class="border border-gray-300 p-2">
                            <span class="px-2 py-1 rounded text-white {{ $bus->status === 'active' ? 'bg-green-500' : ($bus->status === 'maintenance' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ ucfirst($bus->status) }}
                            </span>
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button type="button"
                                    data-bus="{{ json_encode($bus) }}"
                                    onclick="editBus(this)"
                                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>

                            <form action="{{ route('buses.destroy', $bus->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Je i sigurt që dëshiron ta fshish?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Fshi</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">Nuk ka autobusë të regjistruar.</p>
    @endif
</div>

{{-- ===== MODAL: SHTO ===== --}}
<div id="busAddModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <form action="{{ route('buses.store') }}" method="POST" class="bg-white p-6 rounded-lg w-full max-w-md space-y-3">
        @csrf
        <h2 class="text-xl font-bold">Shto Autobus</h2>
        <input name="plate" placeholder="Tabela" class="border p-2 w-full rounded" required>
        <input name="model" placeholder="Modeli" class="border p-2 w-full rounded" required>
        <input name="capacity" type="number" min="1" placeholder="Kapaciteti" class="border p-2 w-full rounded" required>
        <input name="year" type="number" min="1900" placeholder="Viti" class="border p-2 w-full rounded" required>
        <select name="status" class="border p-2 w-full rounded">
            <option value="active">active</option>
            <option value="inactive">inactive</option>
            <option value="maintenance">maintenance</option>
        </select>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="hideModal('busAddModal')" class="px-4 py-2 bg-gray-300 rounded">Anulo</button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Ruaj</button>
        </div>
    </form>
</div>

{{-- ===== MODAL: EDIT ===== --}}
<div id="busEditModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <form id="busEditForm" method="POST" class="bg-white p-6 rounded-lg w-full max-w-md space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-xl font-bold">Edito Autobusin</h2>
        <input name="plate" id="edit_plate" class="border p-2 w-full rounded" required>
        <input name="model" id="edit_model" class="border p-2 w-full rounded" required>
        <input name="capacity" id="edit_capacity" type="number" min="1" class="border p-2 w-full rounded" required>
        <input name="year" id="edit_year" type="number" min="1900" class="border p-2 w-full rounded" required>
        <select name="status" id="edit_status" class="border p-2 w-full rounded">
            <option value="active">active</option>
            <option value="inactive">inactive</option>
            <option value="maintenance">maintenance</option>
        </select>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="hideModal('busEditModal')" class="px-4 py-2 bg-gray-300 rounded">Anulo</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ruaj</button>
        </div>
    </form>
</div>

<script>
function showModal(id) {
    const m = document.getElementById(id);
    m.classList.remove('hidden');
    m.classList.add('flex');
}
function hideModal(id) {
    const m = document.getElementById(id);
    m.classList.add('hidden');
    m.classList.remove('flex');
}
function editBus(btn) {
    const bus = JSON.parse(btn.dataset.bus);
    document.getElementById('busEditForm').action = '/buses/' + bus.id;
    document.getElementById('edit_plate').value = bus.plate;
    document.getElementById('edit_model').value = bus.model;
    document.getElementById('edit_capacity').value = bus.capacity;
    document.getElementById('edit_year').value = bus.year;
    document.getElementById('edit_status').value = bus.status;
    showModal('busEditModal');
}
</script>

@endsection