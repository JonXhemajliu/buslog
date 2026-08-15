@extends('layouts.app')

@section('content')
    @if (session('company_id'))
        @include('pages.dashboard')
    @elseif (session('employee_id'))
        @include('pages.employee-dashboard')
    @else
        @include('pages.home')
    @endif
@endsection