<!doctype html>
<html class="no-js" {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>

@php
    wp_body_open();
    do_action('get_header')
@endphp

<div class="app" role="document">

    @include('partials.navbar')

    <div class="content">

        <main class="main" role="main">
            @yield('content')
        </main>

        {{-- @if (App\display_sidebar())
            <aside class="sidebar">
                @include('partials.sidebar')
            </aside>
        @endif --}}
    </div>
</div>

    @php do_action('get_footer') @endphp
    @include('partials.colophon')
    @php wp_footer() @endphp
</body>
</html>
