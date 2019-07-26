@extends('app')

@push('app-open')
    @include('components.navbar')
@endpush

@push('main-content')
    <h1>{{ $test }}</h1>
@endpush
