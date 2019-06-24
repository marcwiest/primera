
// export default 'test';
const $  = window.jQuery || {};
const wp = window.wp || {};
const localizedData = window.primeraFunctionPrefixLocalizedData || {};

// gist.github.com/wesbos/8b9a22adc1f60336a699
let supportsCssCustomProps = (function () {
    var color = 'rgb(255, 198, 0)';
    var el = document.createElement('span');

    el.style.setProperty('--color', color);
    el.style.setProperty('background', 'var(--color)');
    document.body.appendChild(el);

    var styles = getComputedStyle(el);
    var doesSupport = styles.backgroundColor === color;
    document.body.removeChild(el);

    return doesSupport;
})();

// (function( $, wp, localizedData ) {
    // 'use strict';

    //window.primeraFunctionPrefixUtil =
    export { supportsCssCustomProps };
    export default {

        rest : {

            /**
            * Sends a POST request to a REST endpoint.
            *
            * @since  1.0
            * @param  {(string|object)}  action  The route to send the request to (e.g. 'do-stuff').
            * @param  {object}  data  Optional. The data to populate $_POST with.
            */
            post : function( route, data ) {

                var options;

                if ( _.isObject(route) ) {
    				options = route;
                }
                else {
                    options = {
                        data : data || {}
                    };
                }

                options = _.defaults( options, {
                    type       : 'POST',
                    url        : localizedData.restUrl + route,
                    beforeSend : function( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', localizedData.restNonce );
                    }
                });

                return $.ajax( options );
            }

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
        * Gets the distance of an element to the viewport's edge.
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

// })(
//     jQuery,
//     window.wp || {},
//     window.primeraFunctionPrefixLocalizedData || {}
// );
