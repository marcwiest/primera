<!DOCTYPE html>
<html @php html_class('no-js') @endphp {!! get_language_attributes() !!}>
<head>
	<meta charset="{!! get_bloginfo('charset') !!}">
	@php wp_head() @endphp
</head>
<body @php body_class() @endphp>

@php wp_body_open() @endphp

@stack('before-app')

<div class="app @stack('app-class')" role="document">

    @stack('app-open')
    {{-- @include('components.navbar') --}}

    <div class="@stack('content-class')">
        <main class="@stack('main-class')" role="main">
            @stack('main-content')
        </main>
        {{-- @if (App\display_sidebar())
            <aside class="sidebar">
                @include('components.sidebar')
            </aside>
        @endif --}}
    </div>

    @stack('app-close')
    {{-- @include('components.footer') --}}

</div>

@stack('after-app')

@php wp_footer() @endphp

</body>
</html>
