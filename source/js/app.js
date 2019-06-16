// import './vendor/fitvids';
// import _ from './_lodash';
import debounce from 'lodash/debounce';
import tailwind from '../../tailwind.config.js';
// import util from './utils';

'use strict';

// Cache properties.
const $ = window.jQuery || {};
const wp = window.wp || {};
const docElem = document.documentElement; // :root in CSS
const $window = $(window);
const $document = $(document);
const $body = $('body');
const $wpadminbar = $('#wpadminbar');
const enquire = window.enquire || (() => {});
const mq = {
    // NOTE: These should match the `tailwind.config.js`.
    // mobileOnly: `(screen and max-width:599px)`,
    sm: `(screen and min-width:${tailwind.theme.screens.sm})`,
    md: `(screen and min-width:${tailwind.theme.screens.md})`,
    lg: `(screen and min-width:${tailwind.theme.screens.lg})`,
};
let wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;
let scrollTop = $window.scrollTop();

// Setup jQuery AJAX.
$.ajaxSetup({
    headers: {
        // TODO: Add REST API token:
        // Automates the passing of the CSRF token. No need to supply it to every AJAX call.
        // 'X-CSRF-TOKEN': csrfToken
    }
});

// Setup CSS custom properties.
if (docElem.style && docElem.style.setProperty) {
    docElem.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
}

// Listen to scroll event.
$window.on('scroll', debounce(e => {
    scrollTop = $window.scrollTop();
}, 25));

// Listen to resize event.
$window.on('resize', debounce(e => {
    scrollTop = $window.scrollTop();
    wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;
    docElem.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
}, 25));

// Listen to media queries.
enquire.register(mq.sm, {
    deferSetup: true, // defers setup callback until a match occurs
    setup: () => {},
    match: () => {},
    unmatch: () => {},
});

// Bind application events.
// ...
