
@include('components.head')

@while(have_posts())
    @php
        the_post();
        the_content();
    @endphp
@endwhile

@include('components.foot')
