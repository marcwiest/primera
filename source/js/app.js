// import './vendor/fitvids';
// import _ from './_lodash';
import debounce from 'lodash/debounce';
import twConfig from '../../tailwind.config.js';
// import util from './utils';

'use strict';

// Cache properties.
const $ = window.jQuery || {};
const wp = window.wp || {};
const root = document.documentElement;
const $window = $(window);
const $document = $(document);
const $body = $('body');
const $wpadminbar = $('#wpadminbar');
let wpadminbarHeight = $wpadminbar.outerHeight() || 0;
let scrollTop = $window.scrollTop();

// Init app.
initCssProps();

// Bind events.
$window.on('scroll', doWindowScroll);
$window.on('resize', doWindowResize);

// Update CSS custom properties.
let initCssProps = () => {
    root.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
};

// Window scroll event handler.
let doWindowScroll = debounce( e => {
    scrollTop = $window.scrollTop();
}, 10 );

// Window resize event handler.
let doWindowResize = debounce( e => {
    scrollTop = $window.scrollTop();
    wpadminbarHeight = $wpadminbar.outerHeight() || 0;
    root.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
}, 10 );
