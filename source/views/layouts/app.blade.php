<!DOCTYPE html>
<html class="no-js" {!! get_language_attributes() !!}>
<head>
	<meta charset="utf-8">
	@php wp_head() @endphp
    @stack('head')
</head>
<body @php body_class() @endphp>

@php wp_body_open() @endphp

<noscript id="primera-noscript">This app works best with JavaScript enabled.</noscript>

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

    @include('partials.footer')

</div>

@yield('offsite')

@php wp_footer() @endphp

</body>
</html>
