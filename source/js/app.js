// import './vendor/fitvids';
import debounce from 'lodash/debounce'
import tailwind from '../../tailwind.config.js'
import { supportsCssCustomProps } from './_utils'

'use strict';

// Cache properties.
const localized = window.primeraFunctionPrefixLocalizedData;
const $ = window.jQuery;
const wp = window.wp;
const enquire = window.enquire;
const docElem = document.documentElement;
const $window = $(window);
const $document = $(document);
const $html = $('html');
const $body = $('body');
const $wpadminbar = $('#wpadminbar');
let wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;
let scrollTop = $window.scrollTop();

// Indicate JS.
$html.removeClass('no-js').addClass('js');

// Setup jQuery AJAX.
$.ajaxSetup({
    headers: {
        // Automates the passing of the CSRF token. No need to supply it to every AJAX call.
        'X-CSRF-TOKEN': localized.restNonce
    }
});

// Initialize plugins.
// ...

// Setup CSS custom properties.
if (supportsCssCustomProps) {
    docElem.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
}

// Bind media queries.
enquire.register(`screen and (min-width:${tailwind.theme.screens.sm})`, {
    deferSetup: true, // defers setup callback until a match occurs
    setup: () => { console.log('setup'); },
    match: () => { console.log('match'); },
    unmatch: () => { console.log('unmatch'); },
});

// Bind scroll events.
$window.on('scroll', debounce(e => {
    scrollTop = $window.scrollTop();
}, 25));

// Bind resize events.
$window.on('resize', debounce(e => {

    scrollTop = $window.scrollTop();

    wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;

    if (supportsCssCustomProps) {
        docElem.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
    }
}, 25));

// Bind events.
// ...
