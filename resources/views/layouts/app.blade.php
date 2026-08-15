<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusLog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-display {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="11" rx="2"/><path d="M3 11h18"/><path d="M7 16v3M17 16v3"/><circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                    </svg>
                </div>
                <span class="font-display font-bold text-xl">BusLog</span>
            </div>
            <div class="flex gap-3 items-center">
                @if (session('company_id'))
                    <span class="text-sm text-gray-600">Company</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Logout</button>
                    </form>
                @elseif (session('employee_id'))
                    <span class="text-sm text-gray-600">Employee</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium">Kyçu</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">Regjistrohu</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>