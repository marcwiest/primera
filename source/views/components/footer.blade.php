
@php do_action('get_footer') @endphp

<footer>
    <div class="auxiliary">
    </div>
    <div class="colophon">
        <p><small>&copy; {{ date_i18n('Y') }} {{ $site['name'] }}</small></p>
    </div>
</footer>
