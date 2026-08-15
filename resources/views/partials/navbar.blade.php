{{--
    Navbar e ripërdorshme.
    Parametra opsionale:
      $showAuth  (bool) — tregon butonat Kyçu / Regjistrohu (default: false)
      $showLogout (bool) — tregon butonin Dilni (default: false)
--}}
<nav class="border-b border-gray-200">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">

        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-lg bg-red-600 flex items-center justify-center text-white">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="11" rx="2"/>
                    <path d="M3 11h18"/><path d="M7 16v3M17 16v3"/>
                    <circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                </svg>
            </div>
            <span class="font-display font-bold text-xl">BusLog</span>
        </div>

        {{-- Linqet e navigimit --}}
        @if(!empty($showAuth))
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-gray-900">Si funksionon</a>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="goToAuth('login')"
                        class="text-sm font-medium text-gray-700 hover:text-red-600">Kyçu</button>
                <button onclick="goToAuth('register')"
                        class="text-sm font-medium bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                    Regjistrohu
                </button>
            </div>
        @endif

        @if(!empty($showLogout))
            <button onclick="showPage('page-home')"
                    class="text-sm font-medium text-gray-600 hover:text-red-600">Dilni</button>
        @endif

    </div>
</nav>