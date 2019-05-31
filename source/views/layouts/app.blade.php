<!DOCTYPE html>
<html class="no-js" {!! get_language_attributes() !!}>
<head>
	<meta charset="utf-8">
	@php wp_head() @endphp
    {{-- @stack('head') --}}
</head>
<body @php body_class() @endphp>

@php wp_body_open() @endphp

@stack('before-app')

<div class="app" role="document">

    @stack('app-open')
    {{-- @include('components.navbar') --}}

    <div class="content">
        <main class="main" role="main">
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
