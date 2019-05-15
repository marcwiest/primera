(function () {
    'use strict';

    (function ($, wp, localizedData) {

      window.primeraFunctionPrefixUtil = {
        rest: {
          /**
          * Sends a POST request to a REST endpoint.
          *
          * @since  1.0
          * @param  {(string|object)}  action  The route to send the request to (e.g. 'do-stuff').
          * @param  {object}  data  Optional. The data to populate $_POST with.
          */
          post: function post(route, data) {
            var options;

            if (_.isObject(route)) {
              options = route;
            } else {
              options = {
                data: data || {}
              };
            }

            options = _.defaults(options, {
              type: 'POST',
              url: localizedData.restUrl + route,
              beforeSend: function beforeSend(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', localizedData.restNonce);
              }
            });
            return $.ajax(options);
          }
        },

        /**
        * USAGE:
        * primeraUtil.tools.renderModule( 'header-primary', false, function( module ) {
        *     $('body').append( module );
        * });
        */
        renderModule: function renderModule(module, moduleData, callback) {
          var request = wp.ajax.post('primeraRenderModule', {
            nonce: localizedData.ajaxNonce,
            module: module,
            moduleData: moduleData || {}
          });
          request.fail(function (response) {
            console.log('Ajax request failed:', response);
          });
          request.done(function (response) {
            if (response.success) {
              if (typeof callback === 'function') {
                callback(response.module, response);
              } else {
                return response;
              }
            }
          });
        },
        isAndroid: function isAndroid() {
          return navigator.userAgent.match(/Android/i);
        },
        isBlackBerry: function isBlackBerry() {
          return navigator.userAgent.match(/BlackBerry/i);
        },
        isIOS: function isIOS() {
          return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        isOperaMini: function isOperaMini() {
          return navigator.userAgent.match(/Opera Mini/i);
        },
        isIEMobile: function isIEMobile() {
          return navigator.userAgent.match(/IEMobile/i);
        },
        isMobile: function isMobile() {
          return this.isAndroid() || this.isIOS() || this.isOperaMini() || this.isBlackBerry() || this.isIEMobile();
        },

        /**
        * Check if browser is MS IE.
        */
        isIE: function isIE() {
          var ua = window.navigator.userAgent,
              msie = ua.indexOf("MSIE ");

          if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            return true;
          }

          return false;
        },

        /**
        * Check if browser is MS Edge.
        */
        isEdge: function isEdge() {
          if (document.documentMode || /Edge/.test(navigator.userAgent)) {
            return true;
          }

          return false;
        },

        /**
        * Gets the viewport width, excluding the scrollbars.
        *
        * @since  1.0
        */
        getViewportWidth: function getViewportWidth() {
          return document.body.clientWidth;
        },

        /**
        * Gets the viewport height, excluding the scrollbars.
        *
        * @since  1.0
        */
        getViewportHeight: function getViewportHeight() {
          return document.body.clientHeight;
        },

        /**
        * Gets the distance of an element to the viewport's edge.
        *
        * @param  jQuery  jQuery element of which to get the viewport offset.
        * @since  1.0
        */
        getViewportOffset: function getViewportOffset($elem) {
          var $window = jQuery(window),
              scrollLeft = $window.scrollLeft(),
              scrollTop = $window.scrollTop(),
              offset = $elem.offset();
          return {
            left: offset.left - scrollLeft,
            top: offset.top - scrollTop
          };
        }
      };
    })(jQuery, window.wp || {}, window.primeraFunctionPrefixLocalizedData || {});

    /*jshint browser:true */

    (function ($) {

      $.fn.fitVids = function (options) {
        var settings = {
          customSelector: null,
          ignore: null
        };

        if (!document.getElementById('fit-vids-style')) {
          // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
          var head = document.head || document.getElementsByTagName('head')[0];
          var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
          var div = document.createElement("div");
          div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
          head.appendChild(div.childNodes[1]);
        }

        if (options) {
          $.extend(settings, options);
        }

        return this.each(function () {
          var selectors = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', 'object', 'embed'];

          if (settings.customSelector) {
            selectors.push(settings.customSelector);
          }

          var ignoreList = '.fitvidsignore';

          if (settings.ignore) {
            ignoreList = ignoreList + ', ' + settings.ignore;
          }

          var $allVideos = $(this).find(selectors.join(','));
          $allVideos = $allVideos.not('object object'); // SwfObj conflict patch

          $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

          $allVideos.each(function () {
            var $this = $(this);

            if ($this.parents(ignoreList).length > 0) {
              return; // Disable FitVids on this video.
            }

            if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
              return;
            }

            if (!$this.css('height') && !$this.css('width') && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
              $this.attr('height', 9);
              $this.attr('width', 16);
            }

            var height = this.tagName.toLowerCase() === 'object' || $this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)) ? parseInt($this.attr('height'), 10) : $this.height(),
                width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                aspectRatio = height / width;

            if (!$this.attr('name')) {
              var videoName = 'fitvid' + $.fn.fitVids._count;
              $this.attr('name', videoName);
              $.fn.fitVids._count++;
            }

            $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', aspectRatio * 100 + '%');
            $this.removeAttr('height').removeAttr('width');
          });
        });
      }; // Internal counter for unique video names.


      $.fn.fitVids._count = 0; // Works with either jQuery or Zepto
    })(window.jQuery || window.Zepto);

    (function ($, wp, util, localizedData) {

      var app = {
        /**
        * Initiate.
        *
        * @since  1.0
        */
        init: function init() {
          this.cacheDom();
          this.cacheData();
          this.indicateJavaScript();
          this.indicateBrowser();
          this.accommodateAdminbar();
          this.initFitvids();
          this.bindEvents();
        },

        /**
        * Cache DOM.
        *
        * @since  1.0
        */
        cacheDom: function cacheDom() {
          this.$window = $(window);
          this.$html = $('html');
          this.$body = $('body');
          this.$wpAdminbar = $('#wpadminbar');
          this.$header = $('.primeraCssPrefix-header');
          this.$offCanvasToggle = $('.primeraCssPrefix-off-canvas-toggle');
          this.$wpNavMenu = $('.menu');
          this.$searchForm = $('.search-form');
          this.$searchSubmit = this.$searchForm.find('[type=submit]');
          this.$searchField = this.$searchForm.find('[type=search]');
          this.$fragmentLink = $('a[href^="#"]');
        },

        /**
        * Cache Data.
        *
        * @since  1.0
        */
        cacheData: function cacheData() {
          this.fromTop = this.$window.scrollTop();
          this.vw = util.getViewportWidth();
          this.vh = util.getViewportHeight();
        },

        /**
        * Demo REST API Call.
        *
        * @link  https://stackoverflow.com/a/22980763/830992
        * @since  1.0
        */
        demoRestApiCall: function demoRestApiCall() {
          var request = util.rest.post('route-name', {
            key: 'val'
          });
          request.always(function (response) {
            console.log('always', response);
          });
          request.fail(function (response) {
            console.log('fail', response);
          });
          request.done(function (response) {
            console.log('done', response);
          });
        },

        /**
        * Indicate environment status.
        *
        * @since  1.0
        */
        indicateJavaScript: function indicateJavaScript() {
          this.$html.addClass('js').removeClass('no-js');
        },

        /**
        * Indicate environment status.
        *
        * @since  1.0
        */
        indicateBrowser: function indicateBrowser() {
          if (util.isMobile()) {
            this.$html.addClass('is-mobile');
          } else {
            if (util.isIE()) {
              this.$html.addClass('is-ie');
            }

            if (util.isEdge()) {
              this.$html.addClass('is-edge');
            }
          }
        },

        /**
        * Accommodate WP-Adminbar.
        *
        * @since  1.0
        */
        accommodateAdminbar: function accommodateAdminbar() {
          var displacement = this.$wpAdminbar.outerHeight() - Math.abs(this.$wpAdminbar.css('top'));

          if (this.$wpAdminbar.length && this.fromTop < 60) {
            this.$body.css('top', displacement);
          }
        },

        /**
        * Initalize Fitvids.
        *
        * @since  1.0
        */
        initFitvids: function initFitvids() {
          // github.com/davatron5000/FitVids.js
          this.$body.fitVids();
        },

        /**
        * Bind module events.
        *
        * @since  1.0
        */
        bindEvents: function bindEvents() {
          this.$window.on('resize', $.proxy(this.onWindowResize, this));
          this.$window.on('scroll', $.proxy(this.onWindowScroll, this));
          this.$offCanvasToggle.on('click', $.proxy(this.onOffCanvasToggleClick, this));
          this.$searchSubmit.on('click', $.proxy(this.preventEmptySearches, this));
          this.$fragmentLink.on('click', $.proxy(this.onFragmentLinkClick, this));
        },

        /**
        * On window resize event.
        *
        * @since  1.0
        */
        onWindowResize: _.debounce(function (e) {
          // Update module properties.
          this.vw = util.getViewportWidth();
          this.vh = util.getViewportHeight(); // Adjust Header to height of WP Adminbar.

          this.accommodateAdminbar();
        }, 200),

        /**
        * On window resize event.
        *
        * @since  1.0
        */
        onWindowScroll: function onWindowScroll(e) {
          this.fromTop = this.$window.scrollTop(); // Body classes.

          if (this.fromTop > 250) {
            this.$body.addClass('primeraCssPrefix-elems-are-visible');
          } else {
            this.$body.removeClass('primeraCssPrefix-elems-are-visible');
          }

          this.accommodateAdminbar();
        },

        /**
        * On click on off-canvas toggles event.
        *
        * @since  1.0
        */
        onOffCanvasToggleClick: function onOffCanvasToggleClick(e) {
          e.preventDefault();
          this.$body.toggleClass('primeraCssPrefix-off-canvas-active');
        },

        /**
        * Prevent empty searches.
        *
        * Works on both, mouse-click on submit as well as the enter-key on input.
        *
        * @since  1.0
        */
        preventEmptySearches: function preventEmptySearches(e) {
          if ('' === this.$searchField.val()) {
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
        onFragmentLinkClick: function onFragmentLinkClick(e) {
          e.preventDefault();
          var hash = e.target.hash,
              shouldScroll = $(e.target).data('scroll'),
              $elem = '#top' === hash ? this.$html : $(hash);

          if (shouldScroll && $elem.length && hash.length > 1) {
            var distance = $elem.offset().top - this.$header.outerHeight(),
                offset = '#top' === hash ? 0 : Math.max(0, distance);
            this.$html.add(this.$body).stop().animate({
              'scrollTop': offset
            }, 800, 'swing');
          }
        }
      };
      /**
      * Init app.
      */

      $(document).on('ready', function (e) {
        app.init();
      });
    })(jQuery, window.wp || {}, window.primeraFunctionPrefixUtil || {}, window.primeraFunctionPrefixLocalizedData || {});

}());
//# sourceMappingURL=app.js.map
