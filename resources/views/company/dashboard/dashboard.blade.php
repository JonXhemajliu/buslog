@extends('layouts.app')

@section('content')

@if (session('success'))
    <div id="toast" class="fixed top-1/6 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[100] max-w-sm px-6 py-4 bg-green-600 text-white text-center rounded-lg shadow-2xl transition-opacity duration-500">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast');
            if (t) { t.style.opacity = '0'; setTimeout(() => t.remove(), 500); }
        }, 3000);
    </script>
@endif

@if ($errors->any())
    <div id="toast-error" class="fixed top-1/6 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[100] max-w-sm px-6 py-4 bg-red-600 text-white text-center rounded-lg shadow-2xl transition-opacity duration-500">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-error');
            if (t) { t.style.opacity = '0'; setTimeout(() => t.remove(), 500); }
        }, 4000);
    </script>
@endif

<style>
    body { margin: 0; padding: 0; }
    nav { display: none !important; }
</style>

<div class="min-h-screen bg-gray-50">
    @include('company.dashboard.partials.sidebar')

    <div class="ml-80 flex-1 overflow-auto">
        @include('company.dashboard.partials.navbar')

        <div class="p-4">
            @include('company.dashboard.partials.stats-card')
            @include('company.dashboard.partials.quick-actions')
            @include('company.dashboard.partials.buses-tab')
            @include('company.dashboard.partials.employees-tab')
            @include('company.dashboard.partials.activity-tab')
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById(tab + '-content').classList.remove('hidden');

        document.getElementById('top-navbar').classList.toggle('hidden', tab !== 'dashboard');

    document.querySelectorAll('.nav-tab').forEach(el => {
        el.classList.remove('active', 'bg-red-50', 'text-red-600');
        el.classList.add('text-gray-600', 'hover:bg-gray-100');
    });

    // Gjej butonin aktiv në sidebar (nëse klikimi erdhi nga sidebar-i, ose nga data-tab)
    const clicked = (typeof event !== 'undefined' && event && event.target && event.target.closest)
        ? event.target.closest('.nav-tab')
        : null;
    const active = clicked || document.querySelector('.nav-tab[data-tab="' + tab + '"]');

    if (active) {
        active.classList.add('active', 'bg-red-50', 'text-red-600');
        active.classList.remove('text-gray-600', 'hover:bg-gray-100');
    }
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

document.addEventListener('click', function (e) {
    if (e.target.id === 'addEmployeeModal' || e.target.id === 'editEmployeeModal') {
        e.target.classList.add('hidden');
    }
    if (e.target.id === 'editBusModal') {
        closeEditBus();
    }
});

// Hap tabin e duhur pas redirect-it (p.sh. pas shtimit të autobusit)
@if(session('tab'))
document.addEventListener('DOMContentLoaded', () => switchTab('{{ session('tab') }}'));
@endif
</script>

@endsection