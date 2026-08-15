<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusLog - Fleet Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
    {{-- TOP NAVBAR --}}
 <div class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="px-4 py-4 flex justify-between items-center">
      <div class="flex items-center gap-3">
    {{-- DASHBOARD/HOME BUTTON --}}
    @if (Auth::guard('company')->check())
     <a href="{{ route('company.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
    Dashboard
</a>
    @elseif (Auth::guard('employee')->check())
        <a href="{{ route('track-buses') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4v4m0 0v2m0-2v-2m9-2v2m0 0v2m0-2v-2"/></svg>
            Dashboard
        </a>
    @else
        <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Home
        </a>
    @endif
</div>
        <div class="flex items-center gap-3">
            {{-- LOGOUT/LOGIN BUTTONS --}}
            @if (Auth::guard('company')->check() || Auth::guard('employee')->check())
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 text-sm font-medium">
                        Dalje
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium">Kyçu</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 text-sm font-medium">Regjistrohu</a>
            @endif
        </div>
    </div>
</div>

    {{-- HOME PAGE CONTENT --}}
    <div id="page-home" class="page active">

        {{-- Hero --}}
        <section class="max-w-6xl mx-auto px-6 pt-16 pb-14 text-center relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-96 h-96 bg-red-50 rounded-full blur-3xl -z-10"></div>
            <span class="inline-block text-xs font-semibold tracking-wide uppercase text-red-600 bg-red-50 px-3 py-1 rounded-full mb-5">
                Për bizneset e transportit
            </span>
            <h1 class="font-display font-bold text-4xl md:text-5xl leading-tight mb-5">
                Menaxho flotën e autobusëve<br class="hidden md:block">
                pa <span class="text-red-600">telashe</span>
            </h1>
            <p class="text-gray-600 max-w-xl mx-auto mb-8">
                BusLog i ndihmon bizneset e transportit të regjistrojnë çdo autobus, të ndjekin
                servisimet e defektet, dhe të kenë gjithmonë historikun e plotë të mirëmbajtjes —
                çmimi, mekaniku dhe data, për çdo intervenim.
            </p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('register') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Regjistro biznesin tënd
                </a>
                <a href="{{ route('login') }}"
                   class="border border-gray-300 hover:border-gray-400 text-gray-700 font-medium px-6 py-3 rounded-lg transition">
                    Kyçu
                </a>
            </div>
        </section>

        {{-- Features --}}
        <section id="features" class="max-w-6xl mx-auto px-6 py-14 border-t border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="p-6 rounded-2xl border border-gray-200">
                    <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="11" rx="2"/>
                            <path d="M3 11h18"/><path d="M7 16v3M17 16v3"/>
                            <circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Regjistro autobusët</h3>
                    <p class="text-sm text-gray-600">Shto çdo autobus me emrin dhe vitin e prodhimit, në më pak se një minutë.</p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-200">
                    <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a4 4 0 00-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 005.4-5.4l-2.1 2.1-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Ndiq servisimet &amp; defektet</h3>
                    <p class="text-sm text-gray-600">Zgjidh llojin e shërbimit — nga ndërrimi i vajit deri te defektet e motorit.</p>
                </div>

                <div class="p-6 rounded-2xl border border-gray-200">
                    <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="6" y="4" width="12" height="16" rx="2"/>
                            <path d="M9 4V3a1 1 0 011-1h4a1 1 0 011 1v1"/>
                            <path d="M9 10h6M9 14h6M9 18h3"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Historik i plotë</h3>
                    <p class="text-sm text-gray-600">Çdo servisim ruhet me çmimin, mekanikun dhe datën — gati për t'u kontrolluar kurdo.</p>
                </div>

            </div>
        </section>

        {{-- Si funksionon --}}
        <section class="max-w-4xl mx-auto px-6 py-16 border-t border-gray-100">
            <h2 class="font-display font-semibold text-2xl text-center mb-12">Si funksionon</h2>
            <div class="relative flex items-start justify-between">
                <div class="route-dash absolute top-5 left-8 right-8 z-0"></div>
                @foreach([['1','Regjistrohu si biznes'], ['2','Shto autobusët e tu'], ['3','Regjistro servisimet']] as $step)
                <div class="relative z-10 flex-1 flex flex-col items-center text-center px-2">
                    <div class="w-10 h-10 rounded-full bg-red-600 text-white font-display font-bold flex items-center justify-center mb-3">
                        {{ $step[0] }}
                    </div>
                    <p class="text-sm font-medium">{{ $step[1] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <footer class="border-t border-gray-100 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} BusLog — Menaxhimi i flotës, thjeshtësuar.
        </footer>

    </div>

</body>
</html>