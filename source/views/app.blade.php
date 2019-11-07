<!DOCTYPE html>
<html class="no-js {{ $html_class_names }}" {!! get_language_attributes() !!}>
<head>
	<meta charset="{!! get_bloginfo('charset') !!}">
	@php wp_head() @endphp
</head>
<body @php body_class() @endphp>

@php wp_body_open() @endphp

@stack('before-app')

<div class="primeraCssPrefix-app @stack('app-class')" role="document">
    <div class="primeraCssPrefix-app-inner">

        @stack('app-open')
        {{-- @include('components.navbar') --}}

        <main class="primeraCssPrefix-app-content" role="main">
            <div class="primeraCssPrefix-app-content-inner">
                @stack('main-content')
            </div>
            {{-- @if (App\display_sidebar())
                <aside class="sidebar">
                    @include('components.sidebar')
                </aside>
            @endif --}}
        </main>

        @stack('app-close')
        {{-- @include('components.footer') --}}

    </div>
</div>

@stack('after-app')

@php wp_footer() @endphp

</body>
</html>
