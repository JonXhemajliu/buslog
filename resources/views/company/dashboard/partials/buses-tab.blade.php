{{-- BUSES TAB --}}
<div id="buses-content" class="tab-content hidden mt-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Autobusët</h1>
            <p class="text-gray-500 mt-1">Menaxhimi i flotës suaj</p>
        </div>
        <button type="button" onclick="openModal('addBusModal')"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
            + Shto Autobus
        </button>
    </div>
<button type="button" onclick="switchTab('dashboard')"
        class="mb-4 inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Kthehu
</button>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

   <table class="w-full text-left table-fixed min-w-[800px]">
    <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
        <tr>
            <th class="px-4 py-3 w-[16%]">Tabela</th>
            <th class="px-4 py-3 w-[22%]">Modeli</th>
            <th class="px-4 py-3 w-[13%]">Kapaciteti</th>
            <th class="px-4 py-3 w-[10%]">Viti</th>
            <th class="px-4 py-3 w-[17%]">Statusi</th>
            <th class="px-4 py-3 w-[22%] text-right">Veprimet</th>
        </tr>
    </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($buses as $bus)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 truncate">{{ $bus->plate }}</td>
                        <td class="px-4 py-4 truncate">{{ $bus->model }}</td>
                        <td class="px-4 py-4">{{ $bus->capacity }}</td>
                        <td class="px-4 py-4">{{ $bus->year }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded text-white text-sm {{ $bus->status === 'active' ? 'bg-green-500' : ($bus->status === 'maintenance' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ ucfirst($bus->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <button type="button"
                                    data-bus="{{ json_encode($bus) }}"
                                    onclick="editBus(this)"
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
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nuk ka autobusë të regjistruar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>