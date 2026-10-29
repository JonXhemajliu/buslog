{{-- MAINTENANCE TAB: të gjithë autobusët + gjendja e mirëmbajtjes --}}
@php
    $mtReady = $buses instanceof \Illuminate\Database\Eloquent\Collection
        && ($buses->isEmpty() || method_exists($buses->first(), 'records'));

    if ($mtReady && $buses->isNotEmpty()) {
        $buses->loadCount([
            'records as open_defects_count' => fn ($q) => $q->where('type', 'defect')->where('status', '!=', 'resolved'),
        ]);
        $buses->loadMax([
            'records as last_service_date' => fn ($q) => $q->where('type', 'service'),
        ], 'record_date');
        $buses->loadMax([
            'records as next_service_date' => fn ($q) => $q->where('type', 'service')->whereNotNull('next_service_date'),
        ], 'next_service_date');
    }
    $mtToday = now()->startOfDay();
@endphp

<div id="maintenance-content" class="tab-content hidden mt-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Mirëmbajtja</h1>
        <p class="text-gray-500 mt-1">Servisi dhe defektet e çdo autobusi</p>
    </div>

    <button type="button" onclick="bhShowTab('dashboard')"
            class="mb-4 inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kthehu
    </button>

    @unless($mtReady)
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            Mungon marrëdhënia <code>records()</code> te modeli <code>Bus</code>. Shtoje te <code>app/Models/Bus.php</code>:
            <code>public function records() { return $this->hasMany(BusRecord::class); }</code>
        </div>
    @endunless

    <table class="w-full text-left table-fixed min-w-[900px]">
        <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
            <tr>
                <th class="px-4 py-3 w-[20%]">Autobusi</th>
                <th class="px-4 py-3 w-[15%]">Defekte të hapura</th>
                <th class="px-4 py-3 w-[15%]">Servisi i fundit</th>
                <th class="px-4 py-3 w-[18%]">Servisi i radhës</th>
                <th class="px-4 py-3 w-[32%]">Veprimet</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($buses as $bus)
                @php
                    $mtOpen = (int) ($bus->open_defects_count ?? 0);
                    $mtLast = $bus->last_service_date ? \Carbon\Carbon::parse($bus->last_service_date) : null;
                    $mtNext = $bus->next_service_date ? \Carbon\Carbon::parse($bus->next_service_date) : null;
                    $mtOverdue = $mtNext && $mtNext->lt($mtToday);
                @endphp
                <tr data-mt-row="{{ $bus->id }}" class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <p class="font-medium text-gray-900 truncate">{{ $bus->plate }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $bus->model }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <span data-mt-defects class="px-2 py-1 rounded text-xs font-medium {{ $mtOpen ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $mtOpen ? $mtOpen . ' të hapura' : 'Asnjë' }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span data-mt-last class="text-sm text-gray-700">{{ $mtLast ? $mtLast->format('d.m.Y') : '—' }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <span data-mt-next class="text-sm {{ $mtOverdue ? 'text-red-600 font-semibold' : 'text-gray-700' }}">{{ $mtNext ? $mtNext->format('d.m.Y') . ($mtOverdue ? ' · vonuar' : '') : '—' }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <button type="button"
                                    data-bus-add="service" data-bus-id="{{ $bus->id }}" data-bus-name="{{ $bus->plate }}"
                                    class="px-2.5 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                + Servis
                            </button>
                            <button type="button"
                                    data-bus-add="defect" data-bus-id="{{ $bus->id }}" data-bus-name="{{ $bus->plate }}"
                                    class="px-2.5 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50">
                                + Defekt
                            </button>
                            <button type="button"
                                    data-bus-history="{{ $bus->id }}" data-bus-name="{{ $bus->plate }}"
                                    class="px-2.5 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Historiku
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nuk ka autobusë të regjistruar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
// Hap një tab të dashboard-it (robust, pa varësi nga sidebar-i)
window.bhShowTab = function (tab) {
    document.querySelectorAll('.tab-content').forEach(function (el) { el.classList.add('hidden'); });
    var target = document.getElementById(tab + '-content');
    if (target) target.classList.remove('hidden');
    window.scrollTo({ top: 0 });
};
</script>