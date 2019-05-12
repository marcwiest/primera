@php do_action('get_header')
@endphp<!DOCTYPE html>
<html class="no-js" {!! get_language_attributes() !!}>
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	@php wp_head() @endphp
</head>
<body @php body_class() @endphp>
@php wp_body_open() @endphp
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

@include('partials.footer')

@php wp_footer() @endphp
</body>
</html>
