@php
    $lastBus = $buses->sortByDesc('created_at')->first();
    $lastEmployee = $employees->sortByDesc('created_at')->first();
    $activePercent = $totalBuses > 0 ? round(($activeBuses / $totalBuses) * 100) : 0;
    $companyName = auth('company')->user()->name ?? 'Biznesi';
@endphp

{{-- Sidebar --}}
<div class="w-80 bg-gray-100 border-r border-gray-200 fixed inset-y-0 left-0 z-50 flex flex-col shadow-sm">
    <div class="p-6 flex-1 overflow-y-auto ml-4">

        {{-- Logo --}}
        <div class="bg-white rounded-r-lg p-6 mb-4">
            <button type="button" onclick="switchTab('dashboard')"
                    class="w-full flex items-center gap-3 text-left cursor-pointer hover:opacity-80 transition">
                <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center text-white">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="11" rx="2"/><path d="M3 11h18"/><path d="M7 16v3M17 16v3"/><circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                    </svg>
                </div>
                <span class="font-bold text-xl text-gray-900">BusLog</span>
            </button>
        </div>

        {{-- Navigation --}}
        <div class="bg-gray-100 rounded-r-lg p-6 mr-4">
            <nav class="space-y-2">
                <a href="#" data-tab="dashboard" class="nav-tab active flex items-center gap-3 px-4 py-3 rounded-lg bg-red-50 text-red-600 font-medium" onclick="switchTab('dashboard'); return false;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l-7-4m0 0l-2-3m2 3v10a1 1 0 001 1h12a1 1 0 001-1v-10m0 0l2-3"/></svg>
                    Dashboard
                </a>
                <a href="#" data-tab="buses" class="nav-tab flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium" onclick="switchTab('buses'); return false;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12M8 11h12M8 15h12M3 7h.01M3 11h.01M3 15h.01"/></svg>
                    Autobusët
                </a>
                <a href="#" data-tab="employees" class="nav-tab flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium" onclick="switchTab('employees'); return false;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    Punonjësit
                </a>
                <a href="#" data-tab="activity" class="nav-tab flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium" onclick="switchTab('activity'); return false;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Aktiviteti
                </a>
            </nav>
        </div>

        {{-- Sidebar Bottom Section --}}
        <div class="mt-4 space-y-4 mr-4">

            {{-- Quick Tip --}}
            <div class="bg-white border border-red-200 p-4 rounded-lg text-red-600 shadow-sm">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="text-xs font-semibold">Këshillë</p>
                        <p class="text-xs mt-1 text-red-500">Rishikoni defektet çdo ditë</p>
                    </div>
                </div>
            </div>

            {{-- Last Activity (reale) --}}
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
                <p class="text-xs font-semibold text-gray-600 mb-3">AKTIVITETI I FUNDIT</p>
                <div class="space-y-3">
                    @if($lastBus)
                        <div class="flex items-start gap-2 text-xs">
                            <div class="w-2 h-2 mt-1 bg-green-500 rounded-full flex-shrink-0"></div>
                            <div class="min-w-0">
                                <p class="text-gray-700 truncate">Autobus i shtuar: {{ $lastBus->plate }}</p>
                                <p class="text-gray-400">{{ $lastBus->created_at->locale('sq')->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif

                    @if($lastEmployee)
                        <div class="flex items-start gap-2 text-xs">
                            <div class="w-2 h-2 mt-1 bg-blue-500 rounded-full flex-shrink-0"></div>
                            <div class="min-w-0">
                                <p class="text-gray-700 truncate">Punonjës i shtuar: {{ $lastEmployee->name }} {{ $lastEmployee->surname }}</p>
                                <p class="text-gray-400">{{ $lastEmployee->created_at->locale('sq')->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif

                    @if(!$lastBus && !$lastEmployee)
                        <p class="text-xs text-gray-400">Ende pa aktivitet.</p>
                    @endif
                </div>
            </div>

            {{-- Fleet Status (reale) --}}
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
                <p class="text-xs font-semibold text-gray-600 mb-2">FLOTA AKTIVE</p>
                <div class="w-full bg-gray-300 rounded-full h-1.5 mb-2">
                    <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ $activePercent }}%"></div>
                </div>
                <p class="text-xs text-gray-500">{{ $activeBuses }} nga {{ $totalBuses }} autobusë janë aktivë ({{ $activePercent }}%)</p>
            </div>
        </div>
    </div>

    {{-- User Info + Logout --}}
    <div class="mt-auto m-4 bg-white rounded-r-lg p-4 border-t border-gray-200">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($companyName, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ $companyName }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                Dalje
            </button>
        </form>
    </div>
</div>