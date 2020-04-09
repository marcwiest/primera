
<div class="main" >
    <main class="main-inner" role="main">
        {{ $slot }}
    </main>
    {{-- @if ($display_sidebar ?? false)
        <aside>@include('components.sidebar')</aside>
    @endif --}}
</div>
