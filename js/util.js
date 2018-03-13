(function( $, wp, localizedData ) {
    'use strict';

    window.primeraUtil = {

        rest : {

            post : function( route, data ) {

                var settings = {
                    type       : 'POST',
                    url        : localizedData.restUrl + route,
                    beforeSend : function( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', localizedData.restNonce );
                    }
                };

                settings = _.extend( settings, { data : data || {} } );

                return $.ajax( settings );
            }

        },

        /**
        * USAGE:
        * primeraUtil.tools.renderModule( 'header-primary', false, function( module ) {
        *     $('body').append( module );
        * });
        */
        renderModule : function( module, moduleData, callback ) {

            var request = wp.ajax.post( 'primeraRenderModule', {
                nonce      : localizedData.ajaxNonce,
                module     : module,
                moduleData : moduleData || {}
            });

            request.fail( function( response ) {
                console.log( 'Ajax request failed:', response );
            });

            request.done( function( response ) {

                if ( response.success ) {

                    if ( typeof callback === 'function' ) {

                        callback( response.module, response );
                    }
                    else {
                        return response;
                    }
                }
            });
        },

        isAndroid : function() {
            return navigator.userAgent.match(/Android/i);
        },

        isBlackBerry : function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },

        isIOS : function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },

        isOperaMini : function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },

        isIEMobile : function() {
            return navigator.userAgent.match(/IEMobile/i);
        },

        isMobile : function() {
            return (
                this.isAndroid() ||
                this.isIOS() ||
                this.isOperaMini() ||
                this.isBlackBerry() ||
                this.isIEMobile()
            );
        },

        /**
        * Check if browser is MS IE.
        */
        isIE : function() {

            var ua   = window.navigator.userAgent,
    	        msie = ua.indexOf("MSIE ");

    	    if ( msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./) ) {
    	        return true;
    	    }
    	    return false;
        },

        /**
        * Check if browser is MS Edge.
        */
        isEdge : function() {

        	if ( document.documentMode || /Edge/.test(navigator.userAgent) ) {
        		return true;
        	}
            return false;
        },

        /**
        * Gets the viewport width, excluding the scrollbars.
        *
        * @since  1.0
        */
        getViewportWidth : function() {
            return document.body.clientWidth;
        },

        /**
        * Gets the viewport height, excluding the scrollbars.
        *
        * @since  1.0
        */
        getViewportHeight : function() {
            return document.body.clientHeight;
        },

        /**
        * Gets the distance of an element to the viewport.
        *
        * @param  jQuery  jQuery element of which to get the viewport offset.
        * @since  1.0
        */
        getViewportOffset : function ( $elem ) {

            var $window    = jQuery(window),
                scrollLeft = $window.scrollLeft(),
                scrollTop  = $window.scrollTop(),
                offset     = $elem.offset();

            return {
                left : offset.left - scrollLeft,
                top  : offset.top - scrollTop
            };
        }

    };

})(
    jQuery,
    window.wp || {},
    window.primeraLocalizedData || {}
);
