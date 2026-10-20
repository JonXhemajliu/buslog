@extends('layouts.app')

@section('content')
    @if (auth('company')->check())
        @include('pages.dashboard')
    @elseif (auth('employee')->check())
        @include('pages.employee-dashboard')
    @else
        @include('pages.home')
    @endif
@endsection