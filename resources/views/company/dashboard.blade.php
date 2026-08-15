@extends('layouts.app')

@section('content')
@php
    $companyName = auth()->user()->company_name ?? 'Biznesi';
@endphp

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

@include('company.dashboard.partials.modals.add-employee-tab')
@include('company.dashboard.partials.modals.edit-employee-tab')

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById(tab + '-content').classList.remove('hidden');
    
    document.querySelectorAll('.nav-tab').forEach(el => {
        el.classList.remove('active', 'bg-red-50', 'text-red-600');
        el.classList.add('text-gray-600', 'hover:bg-gray-100');
    });
    
    event.target.closest('.nav-tab').classList.add('active', 'bg-red-50', 'text-red-600');
    event.target.closest('.nav-tab').classList.remove('text-gray-600', 'hover:bg-gray-100');
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hidden')) return;
    if (e.target.id === 'addEmployeeModal' || e.target.id === 'editEmployeeModal') {
        e.target.classList.add('hidden');
    }
});
</script>

@endsection