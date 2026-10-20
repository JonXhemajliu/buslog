@php
    $statusLabels = ['active' => 'Aktiv', 'inactive' => 'Joaktiv', 'maintenance' => 'Mirëmbajtje'];
    $emp = auth('employee')->user();
    $recent = $buses->sortByDesc('updated_at')->take(10);
@endphp

@if ($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
        @foreach ($errors->all() as $error)
            <p class="text-sm text-red-600">{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Autobusët</h1>
        <p class="text-gray-500 mt-1">Menaxhimi i flotës së kompanisë</p>
    </div>
    <div class="flex gap-2">
        <button type="button" onclick="empOpen('empProfileModal')"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">Profili im</button>
        <button type="button" onclick="empOpen('empAddBusModal')"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">+ Shto Autobus</button>
    </div>
</div>

{{-- Tabs --}}
<div class="flex gap-6 border-b border-gray-200 mb-6">
    <button type="button" data-emp-tab="buses" onclick="empTab('buses')"
            class="emp-tab-btn pb-3 font-medium border-b-2 border-red-600 text-red-600">Autobusët</button>
    <button type="button" data-emp-tab="activity" onclick="empTab('activity')"
            class="emp-tab-btn pb-3 font-medium border-b-2 border-transparent text-gray-600 hover:text-red-600">Aktiviteti</button>
</div>

{{-- BUSES TAB --}}
<div id="emp-tab-buses" class="emp-tab">
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left min-w-[700px]">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-3">Tabela</th>
                    <th class="px-4 py-3">Modeli</th>
                    <th class="px-4 py-3">Kapaciteti</th>
                    <th class="px-4 py-3">Viti</th>
                    <th class="px-4 py-3">Statusi</th>
                    <th class="px-4 py-3 text-right">Veprimet</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($buses as $bus)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $bus->plate }}</td>
                        <td class="px-4 py-3">{{ $bus->model }}</td>
                        <td class="px-4 py-3">{{ $bus->capacity }}</td>
                        <td class="px-4 py-3">{{ $bus->year }}</td>
                        <td class="px-4 py-3">{{ $statusLabels[$bus->status] ?? $bus->status }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button type="button" data-bus="{{ json_encode($bus) }}" onclick="empEditBus(this)"
                                    class="text-blue-600 hover:underline mr-3">Ndrysho</button>
                            <form action="{{ route('buses.destroy', $bus->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Je i sigurt?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Fshij</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">Nuk ka autobusë.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ACTIVITY TAB --}}
<div id="emp-tab-activity" class="emp-tab hidden">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Aktiviteti</h2>
        <p class="text-gray-500 mt-1">Ndryshimet e fundit te autobusët</p>
    </div>

    <div class="space-y-4">
        @forelse($recent as $bus)
            @php $isNew = $bus->created_at->eq($bus->updated_at); @endphp
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 {{ $isNew ? 'bg-blue-100' : 'bg-yellow-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                    @if ($isNew)
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    @else
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $isNew ? 'Autobus i shtuar' : 'Autobus i përditësuar' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $bus->plate }} · {{ $bus->model }} · {{ $bus->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-lg border border-gray-200 text-center text-gray-500">
                Nuk ka aktivitet ende.
            </div>
        @endforelse
    </div>
</div>

{{-- Add Bus Modal --}}
<div id="empAddBusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <form action="{{ route('buses.store') }}" method="POST" class="bg-white rounded-lg p-8 max-w-md w-full space-y-3">
        @csrf
        <h2 class="text-2xl font-bold mb-2">Shto Autobus</h2>
        <input name="plate" placeholder="Tabela" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="model" placeholder="Modeli" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="capacity" type="number" min="1" placeholder="Kapaciteti" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="year" type="number" min="1900" placeholder="Viti" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <option value="active">Aktiv</option>
            <option value="inactive">Joaktiv</option>
            <option value="maintenance">Mirëmbajtje</option>
        </select>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Shto</button>
            <button type="button" onclick="empClose('empAddBusModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg font-medium">Anulo</button>
        </div>
    </form>
</div>

{{-- Edit Bus Modal --}}
<div id="empEditBusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <form id="empEditBusForm" method="POST" class="bg-white rounded-lg p-8 max-w-md w-full space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-2xl font-bold mb-2">Ndrysho Autobusin</h2>
        <input name="plate" id="emp_bus_plate" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="model" id="emp_bus_model" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="capacity" id="emp_bus_capacity" type="number" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="year" id="emp_bus_year" type="number" min="1900" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <select name="status" id="emp_bus_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <option value="active">Aktiv</option>
            <option value="inactive">Joaktiv</option>
            <option value="maintenance">Mirëmbajtje</option>
        </select>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Ruaj</button>
            <button type="button" onclick="empClose('empEditBusModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg font-medium">Anulo</button>
        </div>
    </form>
</div>

{{-- Profile Modal --}}
<div id="empProfileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <form action="{{ route('employee.profile.update') }}" method="POST" class="bg-white rounded-lg p-8 max-w-md w-full space-y-3">
        @csrf
        @method('PUT')
        <h2 class="text-2xl font-bold mb-2">Profili im</h2>
        <input name="name" value="{{ $emp->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="surname" value="{{ $emp->surname }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="username" value="{{ $emp->username }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="email" type="email" value="{{ $emp->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="password" type="password" placeholder="Fjalëkalim i ri (opsionale)" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <input name="password_confirmation" type="password" placeholder="Përsërite fjalëkalimin" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Ruaj</button>
            <button type="button" onclick="empClose('empProfileModal')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg font-medium">Anulo</button>
        </div>
    </form>
</div>

<script>
function empOpen(id)  { document.getElementById(id).classList.remove('hidden'); }
function empClose(id) { document.getElementById(id).classList.add('hidden'); }

function empTab(name) {
    document.querySelectorAll('.emp-tab').forEach(el => el.classList.add('hidden'));
    document.getElementById('emp-tab-' + name).classList.remove('hidden');

    document.querySelectorAll('.emp-tab-btn').forEach(btn => {
        const active = btn.dataset.empTab === name;
        btn.classList.toggle('border-red-600', active);
        btn.classList.toggle('text-red-600', active);
        btn.classList.toggle('border-transparent', !active);
        btn.classList.toggle('text-gray-600', !active);
    });
}

function empEditBus(btn) {
    const bus = JSON.parse(btn.dataset.bus);
    document.getElementById('emp_bus_plate').value = bus.plate;
    document.getElementById('emp_bus_model').value = bus.model;
    document.getElementById('emp_bus_capacity').value = bus.capacity;
    document.getElementById('emp_bus_year').value = bus.year;
    document.getElementById('emp_bus_status').value = bus.status;
    document.getElementById('empEditBusForm').action =
        "{{ route('buses.update', ':id') }}".replace(':id', bus.id);
    empOpen('empEditBusModal');
}
</script>