// NOTE: Code is wrapped in iife via RollupJS in gulpfile.babel.js.

// import './vendor/fitvids';
import debounce from 'lodash/debounce'
import tailwind from '../../tailwind.config.js'
import { supportsCssCustomProps } from './utils/_utils'

'use strict';

const $ = window.jQuery || {},
    wp = window.wp || {},
    enquire = window.enquire,
    localized = window.primeraFunctionPrefixLocalizedData,
    $document = $(document),
    $window = $(window),
    $html = $('html'),
    $body = $('body'),
    $wpadminbar = $('#wpadminbar'),
    breakpoints = {
        sm: 600,
        md: 900,
        lg: 1200,
    };

let scrollTop = $window.scrollTop(),
    vh = document.body.clientHeight,
    vw = document.body.clientWidth,
    wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;

const app = {

    init : function() {
        this.createElements();
        this.cacheProps();
        this.setupModule();
        this.bindMediaQueries();
        this.bindEvents();
    },

    createElements : function() {
        // this.$anchor = jQuery('<a href="#" />');
    },

    cacheProps : function() {
    },

    setupModule : function() {

        // Indicate JS.
        $html.removeClass('no-js').addClass('js');

        // Setup jQuery AJAX.
        $.ajaxSetup({
            headers: {
                // Automates the passing of the CSRF token. No need to supply it to every AJAX call.
                'X-CSRF-TOKEN': localized.restNonce
            }
        });

        // Setup CSS custom properties.
        if (supportsCssCustomProps) {
            document.documentElement.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
        }
    },

    bindMediaQueries : function() {

        enquire.register(`screen and (min-width:${breakpoints.sm})`, {
            deferSetup: true, // defers setup callback until a match occurs
            setup: () => { console.log('setup'); },
            match: () => { console.log('match'); },
            unmatch: () => { console.log('unmatch'); },
        });
    },

    bindEvents : function() {
        $document.on('click', 'body', $.proxy(this.displayAlert, this));
    },

    bindResizeEvents : function() {
        $window.on('resize orientationchange', debounce(e => {

            vh = document.body.clientHeight;
            vw = document.body.clientWidth;
            scrollTop = $window.scrollTop();

            wpadminbarHeight = $wpadminbar.length ? $wpadminbar.outerHeight() : 0;

            if (supportsCssCustomProps) {
                docElem.style.setProperty('--wpadminbar-height', wpadminbarHeight + 'px');
            }
        }, 25));
    },

    bindScrollEvents : function() {
        $window.on('scroll', debounce(e => {
            scrollTop = $window.scrollTop();
        }, 25));
    },

    displayAlert : function( e ) {
        e.preventDefault();
        alert('Hello World!');
    }
};

app.init();
