jQuery(document).ready(function () {
    jQuery(".sb-search").each(function (key, el) {
        new UISearch(el);
    });

    jQuery('.sm-header_topline').smartmenus({
        subMenusSubOffsetX: 6,
        subMenusSubOffsetY: -8
    });

    jQuery('.sm-footer_bottom').smartmenus({
        subMenusSubOffsetX: 6,
        subMenusSubOffsetY: -8,
        bottomToTopSubMenus: true
    });

    // splash
    jQuery('.splash').each(function (i, val) {
        var id = $(this).attr('id');
        setTimeout(function () {
            splash(id)
        }, $(this).attr('data-timeout'));
    });

    function splash(id) {
        $.magnificPopup.open({
            items: {
                src: '#' + id
            },
            type: "inline"
        });
    }

    if (jQuery().waypoint) {
        // Progress Bars
        jQuery('.progress-bar').waypoint(function () {
            jQuery(this).css('visibility', 'visible');
            jQuery('.progress-bar').each(function () {
                var percentage = jQuery(this).find('.progress-bar-content').data('percentage');
                jQuery(this).find('.progress-bar-content').css('width', '0%');
                jQuery(this).find('.progress-bar-content').animate({
                    width: percentage + '%'
                }, 'slow');
            });
        }, {
            triggerOnce: true,
            offset: 'bottom-in-view'
        });

        // Circle Counters
        jQuery('.counter-circle').waypoint(function () {
            $('.counter-circle').easyPieChart({
                easing: 'easeOutBounce',
                size: '200',
                rotate: '45',
                onStep: function (from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                }
            });
        }, {
            triggerOnce: true,
            offset: 'bottom-in-view'
        });
    }

    /*! viewportSize | Author: Tyson Matanich, 2013 | License: MIT */
    (function (n) {
        n.viewportSize = {}, n.viewportSize.getHeight = function () {
            return t("Height")
        }, n.viewportSize.getWidth = function () {
            return t("Width")
        };
        var t = function (t) {
            var f, o = t.toLowerCase(), e = n.document, i = e.documentElement, r, u;
            return n["inner" + t] === undefined ? f = i["client" + t] : n["inner" + t] != i["client" + t] ? (r = e.createElement("body"), r.id = "vpw-test-b", r.style.cssText = "overflow:scroll", u = e.createElement("div"), u.id = "vpw-test-d", u.style.cssText = "position:absolute;top:-1000px", u.innerHTML = "<style>@media(" + o + ":" + i["client" + t] + "px){body#vpw-test-b div#vpw-test-d{" + o + ":7px!important}}<\/style>", r.appendChild(u), i.insertBefore(r, e.head), f = u["offset" + t] == 7 ? i["client" + t] : n["inner" + t], i.removeChild(r)) : f = n["inner" + t], f
        }
    })(this);

    /**
     * How to create a parallax scrolling website
     * Author: Petr Tichy
     * URL: www.ihatetomatoes.net
     * Article URL: http://ihatetomatoes.net/how-to-create-a-parallax-scrolling-website/
     */

    (function ($) {

        // Setup variables
        $window = $(window);
        $slide = $('.paralaxFullPageSlide');
        $body = $('body');

        //FadeIn all sections   
        $body.imagesLoaded(function () {
            setTimeout(function () {

                // Resize sections
                adjustWindow();

                // Fade in sections
                $body.removeClass('loading').addClass('loaded');

            }, 800);
        });

        function adjustWindow() {

            // Init Skrollr
            var s = skrollr.init({
                render: function (data) {

                    //Debugging - Log the current scroll position.
                    //console.log(data.curTop);
                }
            });

            // Get window size
            winH = $window.height();

            // Keep minimum height 550
            if (winH <= 550) {
                winH = 550;
            }

            // Resize our slides
            $slide.height(winH);

            // Refresh Skrollr after resizing our sections
            s.refresh($('.paralaxSlide'));

        }

    })(jQuery);
});

// Optimize infinitescroll for HQTheme
jQuery.extend(jQuery.infinitescroll.prototype, {
    _nearbottom_hqtheme: function () {
        var opts = this.options;
        //this._debug('math:', $('#articles').offset().top);
        if ($('#articles').offset().top + $('#articles').height() < $(window).scrollTop() + $(window).height()) {
            return true;
        }
        return false;
    },
    _callback_hqtheme: function (newElements) {
        $('#articles').masonry('appended', $(newElements));
    }
});