{{-- Top Navbar --}}
<div class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            {{-- HOME BUTTON --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Home
            </a>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 text-sm font-medium">
                Dalje
            </button>
        </form>
    </div>
</div>