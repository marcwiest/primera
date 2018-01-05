(function( $, wp, primera ) {
    'use strict';

    var script = {

        /**
        * Initiate.
        *
        * @since  1.0
        */
        init : function() {

            this.cacheDom();
            this.cacheData();
            this.indicateJavaScript();
            this.indicateBrowser();
            this.accommodateAdminbar();
            this.bindEvents();
            // this.restApiCall();
        },

        /**
        * Cache DOM.
        *
        * @since  1.0
        */
        cacheDom : function() {

            this.$window          = $(window);
            this.$html            = $('html');
            this.$body            = $('body');
            this.$wpAdminbar      = $('#wpadminbar');
            this.$header          = $('.primera-header');
            this.$offCanvasToggle = $('.primera-off-canvas-toggle');
            this.$wpNavMenu       = $('.menu');
            this.$searchForm      = $('.search-form');
            this.$searchSubmit    = this.$searchForm.find('[type=submit]');
            this.$searchField     = this.$searchForm.find('[type=search]');
            this.$fragmentLink    = $('a[href^="#"]');
        },

        /**
        * Cache Data.
        *
        * @since  1.0
        */
        cacheData : function() {

            this.fromTop = this.$window.scrollTop();
            this.vw      = primera.tools.getViewportWidth();
            this.vh      = primera.tools.getViewportHeight();
        },

        /**
        * Indicate environment status.
        *
        * @since  1.0
        */
        indicateJavaScript : function() {

            this.$html.removeClass('no-js').addClass('js');
        },

        /**
        * Indicate environment status.
        *
        * @since  1.0
        */
        indicateBrowser : function() {

            if ( primera.tools.isMobile() ) {

                this.$html.addClass('is-mobile');
            }
            else {

                if ( primera.tools.isIE() ) {
                    this.$html.addClass('is-ie');
                }

                if ( primera.tools.isEdge() ) {
                    this.$html.addClass('is-edge');
                }
            }
        },

        /**
        * Accommodate WP-Adminbar.
        *
        * @since  1.0
        */
        accommodateAdminbar : function() {

            var displacement = this.$wpAdminbar.outerHeight() - Math.abs( this.$wpAdminbar.css('top') );

            if ( this.$wpAdminbar.length && this.fromTop < 60 ) {
                this.$body.css( 'top', displacement );
            }
        },

        // /**
        // * REST API Call.
        // *
        // * @since  1.0
        // */
        // restApiCall : function() {
        //
        //     var request = primera.rest.post( 'get-something', {
        //         key : 'val'
        //     });
        //
        //     request.fail( function( response ) {
        //         console.log( 'Ajax request failed:', response );
        //     });
        //
        //     request.done( function( response ) {
        //         console.log( 'Success:', response );
        //     });
        // }

        /**
        * Bind module events.
        *
        * @since  1.0
        */
        bindEvents : function() {

            this.$window.on( 'resize', $.proxy( this.onWindowResize, this ) );
            this.$window.on( 'scroll', $.proxy( this.onWindowScroll, this ) );
            this.$offCanvasToggle.on( 'click', $.proxy( this.onOffCanvasToggleClick, this ) );
            this.$searchSubmit.on( 'click', $.proxy( this.preventEmptySearches, this ) );
            this.$fragmentLink.on( 'click', $.proxy( this.onFragmentLinkClick, this ) );
        },

        /**
        * On window resize event.
        *
        * @since  1.0
        */
        onWindowResize : _.debounce( function( e ) {

            // Update module properties.
            this.vw = primera.tools.getViewportWidth();
            this.vh = primera.tools.getViewportHeight();

            // Adjust Header to height of WP Adminbar.
            this.accommodateAdminbar();

        }, 200 ),

        /**
        * On window resize event.
        *
        * @since  1.0
        */
        onWindowScroll : function( e ) {

            this.fromTop = this.$window.scrollTop();

            // Body classes.
            if ( this.fromTop > 250 ) {
                this.$body.addClass('mw-elems-are-visible');
            } else {
                this.$body.removeClass('mw-elems-are-visible');
            }

            this.accommodateAdminbar();
        },

        /**
        * On click on off-canvas toggles event.
        *
        * @since  1.0
        */
        onOffCanvasToggleClick : function( e ) {
            e.preventDefault();
            this.$body.toggleClass('mw-off-canvas-active');
        },

        /**
        * Prevent empty searches.
        *
        * Works on both, mouse-click on submit as well as the enter-key on input.
        *
        * @since  1.0
        */
        preventEmptySearches : function( e ) {
            if ( '' === this.$searchField.val() ) {
                e.preventDefault();
            }
        },

        /**
        * On scroll anchor click event.
        *
        * To allow the location hash to be appended to the URL, use: window.location.hash = target; via
        * the "complete" parameter of the jQuery.animate function.
        *
        * @since  1.0
        */
        onFragmentLinkClick : function( e ) {

            e.preventDefault();

            var hash         = e.target.hash,
                shouldScroll = $(e.target).data('scroll'),
                $elem        = '#top' === hash ? this.$html : $(hash);

            if ( shouldScroll && $elem.length && hash.length > 1 ) {

                var distance = $elem.offset().top - ( this.$header.outerHeight() ),
                    offset   = '#top' === hash ? 0 : Math.max( 0, distance );

                this.$html.add( this.$body )
                    .stop()
                    .animate({
                        'scrollTop' : offset
                    }, 800, 'swing' );
            }
        }

    };

    /**
    * Init primera.
    */
    $(document).on( 'ready', function( e ) {
        script.init();
    });

})( jQuery, (window.wp || {}), (window.primera || {}) );
