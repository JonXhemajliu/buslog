<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusLog - Kyçu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-display {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body>
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

                    {{-- Display Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            @foreach ($errors->all() as $error)
                                <p class="text-sm text-red-600">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div>
                            <label class="text-xs font-medium text-gray-600">Email ose Username</label>
                            <input type="text" name="username" required
                                   class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="biznesi@shembull.com">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Fjalëkalimi</label>
                            <input type="password" name="password" required
                                   class="w-full mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                   placeholder="••••••••">
                        </div>
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg transition">
                            Kyçu
                        </button>
                        <p class="text-center text-xs text-gray-500">
                            S'ke llogari?
                            <a href="{{ route('register') }}"
                               class="text-red-600 font-medium">Regjistrohu</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>