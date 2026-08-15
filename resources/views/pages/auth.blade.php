{{-- ============ AUTH PAGE ============ --}}
<div id="page-auth" class="page">
    <div class="min-h-screen bg-red-50 flex items-center justify-center p-6">
        <div class="w-full max-w-sm">

            {{-- Logo --}}
            <div class="flex items-center justify-center gap-2 mb-6">
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

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

                {{-- Tabs --}}
                <div class="flex bg-gray-100 rounded-lg p-1 mb-6">
                    <button id="tab-login" onclick="showAuthTab('login')"
                            class="auth-tab flex-1 text-sm font-medium py-2 rounded-md transition">Kyçu</button>
                    <button id="tab-register" onclick="showAuthTab('register')"
                            class="auth-tab flex-1 text-sm font-medium py-2 rounded-md transition">Regjistrohu</button>
                </div>

                {{-- Login Form --}}
                <form id="form-login"
                      onsubmit="event.preventDefault(); showPage('page-dashboard');"
                      class="flex-col gap-4"
                      style="display:flex">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Email</label>
                        <input type="email" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="biznesi@shembull.com">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Fjalëkalimi</label>
                        <input type="password" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="••••••••">
                    </div>
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition">
                        Kyçu
                    </button>
                    <p class="text-center text-xs text-gray-500">
                        S'ke llogari?
                        <button type="button" onclick="showAuthTab('register')"
                                class="text-red-600 font-medium">Regjistrohu</button>
                    </p>
                </form>

                {{-- Register Form --}}
                <form id="form-register"
                      onsubmit="event.preventDefault(); showPage('page-dashboard');"
                      class="flex-col gap-4"
                      style="display:none">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Emri i biznesit</label>
                        <input type="text" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="p.sh. Transporti Urban SH.P.K.">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Email</label>
                        <input type="email" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="biznesi@shembull.com">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Fjalëkalimi</label>
                        <input type="password" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="••••••••">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Konfirmo fjalëkalimin</label>
                        <input type="password" required
                               class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="••••••••">
                    </div>
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition">
                        Regjistrohu si biznes
                    </button>
                    <p class="text-center text-xs text-gray-500">
                        Ke llogari?
                        <button type="button" onclick="showAuthTab('login')"
                                class="text-red-600 font-medium">Kyçu</button>
                    </p>
                </form>

            </div>
        </div>
    </div>
</div>