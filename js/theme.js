'use strict';

window.primeraTheme = {

    /**
    * Initiate the module.
    *
    * @since  1.0
    */
    init : function() {
        this.defineVars();
        this.indicateEnv();
        this.bindEvents();
    },

    /**
    * Cache DOM elements and other variables.
    *
    * @since  1.0
    */
    defineVars : function() {

        this.tools            = window.primeraTools || {};

        this.$html            = jQuery('html');
        this.$body            = jQuery('body');
        this.$offCanvasToggle = jQuery('.primera-off-canvas-toggle');
        this.$wpNavMenu       = jQuery('.menu');
        this.$searchForm      = jQuery('.search-form');
        this.$searchSubmit    = this.$searchForm.find('[type=submit]');
        this.$searchField     = this.$searchForm.find('[type=search]');
    },

    /**
    * Indicate environment status.
    *
    * @since  1.0
    */
    indicateEnv : function() {

        this.$html.removeClass('no-js').addClass('js');

        if ( this.tools.isMobile() ) {

            this.$html.addClass('is-mobile');
        }
        else {

            if ( this.tools.isIE() ) {
                this.$html.addClass('is-ie');
            }

            if ( this.tools.isEdge() ) {
                this.$html.addClass('is-edge');
            }
        }
    },

    /**
    * Bind module events.
    *
    * @since  1.0
    */
    bindEvents : function() {
        this.$offCanvasToggle.on( 'click', jQuery.proxy( this.toggleOffCanvas, this ) );
        this.$searchSubmit.on( 'click', jQuery.proxy( this.preventEmptySearches, this ) );
        this.$wpNavMenu.on( 'click', '.menu-item a', jQuery.proxy( this.preventMenuItemParentHyperlinking, this ) );
    },

    /**
    * Toggles the off-canvas.
    *
    * @since  1.0
    */
    toggleOffCanvas : function( e ) {
        e.preventDefault();
        this.$body.toggleClass('op-off-canvas-active');
    },

    /**
    * Prevent empty searches.
    *
    * Works on both, mouse-click on submit and enter-key on input.
    *
    * @since  1.0
    */
    preventEmptySearches : function( e ) {
        if ( '' === this.$searchField.val() ) {
            e.preventDefault();
        }
    },

    /**
    * Prevents hyperlinking of menu items that have sub-menus.
    *
    * @since  1.0
    */
    preventMenuItemParentHyperlinking : function( e ) {

        var menuItem           = this.$wpNavMenu.find('.menu-item'),
            menuItemHasSubMenu = menuItem.hasClass('menu-item-has-children').length;

        if ( menuItemHasSubMenu ) {
            e.preventDefault();
        }
    }

};
