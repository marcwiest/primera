@extends('app')

@push('app-header')
    @include('components.navbar')
@endpush

@push('app-footer')
    @include('components.footer')
@endpush

@push('app-main')
    @component('components.main')
        <h1>{{ $test }}</h1>
    @endcomponent
@endpush
