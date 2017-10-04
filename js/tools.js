'use strict';

window.primeraTools = {

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
            window.primeraTools.isAndroid() ||
            window.primeraTools.isIOS() ||
            window.primeraTools.isOperaMini() ||
            window.primeraTools.isBlackBerry() ||
            window.primeraTools.isIEMobile()
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
    }

};
