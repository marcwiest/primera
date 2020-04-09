
@include('components.head')

@stack('before-app')

<div class="app @stack('app-class')" role="document">
    <div class="app-inner">
        @stack('app-header')
        @stack('app-main')
        @stack('app-footer')
    </div>
</div>

@stack('after-app')

@include('components.foot')
