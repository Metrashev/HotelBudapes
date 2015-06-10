<?php
if ( !class_exists( 'HQTheme_Options' ) ) {

    class HQTheme_Options {

        /**
         *
         * @var HQTheme_CssOptions 
         */
        static $instance;

        function __construct() {
            self::$instance = & $this;

            add_action( 'wp_head', array( $this, 'print_css_styles' ), 500 );
            add_action( 'wp_footer', array( $this, 'print_js_scripts' ), 500 );
        }

        public function print_css_styles() {
            $precompile = array();
            //var_dump($_POST);
            //return;
            ?>
            <style type="text/css" media="screen">
            <?php
            $custom_fonts = get_theme_mod( 'hq_typography_custom_fonts' );
            if ( get_theme_mod( 'hq_layout_site_layout' ) == 'boxed' ) {
                echo '#main-wrapper{' . (get_theme_mod( 'hq_layout_site_max_width' ) ? 'max-width: ' . get_theme_mod( 'hq_layout_site_max_width' ) . 'px;' : '') . ' width: ' . (get_theme_mod( 'hq_layout_site_width' ) ? get_theme_mod( 'hq_layout_site_width' ) : 100) . '%;margin: auto;}';
            } else {
                echo '#primary, .content-wrapper{' . (get_theme_mod( 'hq_layout_site_max_width' ) ? 'max-width: ' . get_theme_mod( 'hq_layout_site_max_width' ) . 'px;' : '') . ' width: ' . (get_theme_mod( 'hq_layout_site_width' ) ? get_theme_mod( 'hq_layout_site_width' ) : 100) . '%;margin: auto;}';
            }

            if ( get_theme_mod( 'hq_header_navigation_position' ) == 'fixed-left' ) {
                echo 'body{padding-left: ' . get_theme_mod( 'hq_header_side_width' ) . 'px;}';
            } elseif ( get_theme_mod( 'hq_header_navigation_position' ) == 'fixed-right' ) {
                echo 'body{padding-right: ' . get_theme_mod( 'hq_header_side_width' ) . 'px;}';
            }
            ?>
                body{
            <?php
            if ( get_theme_mod( 'hq_layout_background_image' ) ) {
                echo 'background-image: url("' . get_theme_mod( 'hq_layout_background_image' ) . '");';
            }
            $this->_printBackgroundoptions( get_theme_mod( 'hq_layout_background' ) );

            $this->_printTextoptions( get_theme_mod( 'hq_typography_body' ) );
            ?>
                }
                a{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_links' ) ); ?> }
                a:hover{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_links_hover' ) ); ?> }
                ::selection {
                    background: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>;
                    color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>;
                }
                ::-moz-selection {
                    background: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>;
                    color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>;
                }
                .site-title{<?php $this->_printBoxoptions( get_theme_mod( 'hq_header_logo_box' ) ); ?>}
                .site-title, .site-title a{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_logo' ) ); ?> }
                h1, h1 a, h2, h2 a, h3, h3 a, h4, h4 a, h5, h5 a, h6, h6 a{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_headings' ) ); ?> }
                .navbar-default .navbar-nav > li > a{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_navigation' ) ); ?> }
                .navbar-default .navbar-nav > .open > a:hover,
                .navbar-default .navbar-nav > .active > a:hover,
                .navbar-default .navbar-nav > .active > a{ <?php $this->_printTextoptions( get_theme_mod( 'hq_typography_navigation_active' ) ); ?> }
                header .header_topline{
            <?php
            if ( get_theme_mod( 'hq_header_topline_height' ) )
                echo 'height: ' . get_theme_mod( 'hq_header_topline_height' ) . 'px;';
            if ( get_theme_mod( 'header_topline_background_image' ) ) {
                echo 'background-image: url("' . get_theme_mod( 'header_topline_background_image' ) . '");';
            }
            $this->_printBackgroundoptions( get_theme_mod( 'header_topline_background' ) );
            $this->_printBoxoptions( get_theme_mod( 'hq_header_topline_box' ) );
            $this->_printTextoptions( get_theme_mod( 'header_topline_text' ) );
            ?>
                }
                header .header_topline a{
            <?php $this->_printTextoptions( get_theme_mod( 'header_topline_links' ) ); ?>
                }
                header .header_topline a:hover{
            <?php $this->_printTextoptions( get_theme_mod( 'header_topline_links_hover' ) ); ?>
                }
                header .static-top,
                header .fixed-top {
                    height: <?php echo get_theme_mod( 'hq_header_main_height' ); ?>px;
                }
                .main_header {
            <?php
            if ( get_theme_mod( 'hq_header_background_image' ) ) {
                echo 'background-image: url("' . get_theme_mod( 'hq_header_background_image' ) . '");';
            }
            $this->_printBackgroundoptions( get_theme_mod( 'hq_header_background' ) );
            ?>
                }
                footer .footer_bottom{
            <?php
            if ( get_theme_mod( 'hq_footer_bottom_background_image' ) ) {
                echo 'background-image: url("' . get_theme_mod( 'hq_footer_bottom_background_image' ) . '");';
            }
            $this->_printBackgroundoptions( get_theme_mod( 'hq_footer_bottom_background' ) );
            $this->_printBoxoptions( get_theme_mod( 'hq_footer_bottom_box' ) );
            $this->_printTextoptions( get_theme_mod( 'hq_footer_bottom_text' ) );
            ?>
                }
                                                                                                                                                                                                                                                                        																																																																																		
                header .fixed-left,
                header .fixed-right {
                    width: <?php echo get_theme_mod( 'hq_header_side_width' ); ?>px;
                }
                blockquote{ border-bottom-color: <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?> }
                blockquote:before { color: <?php echo get_theme_mod( 'hq_branding_colors_main_secondary' ); ?> }
                table td { border-color: <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>;}
                ins{
                    background-color: <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>;
                    color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>;
                }
                pre{
                    background-color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>;
                    color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_primary' ); ?>
                }
                .footer_bottom,
                .header_topline,
                .footer_bottom a,
                .header_topline a{
                    color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>
                }
                .fooret-widgets{
            <?php
            if ( get_theme_mod( 'hq_footer_widgets_background_image' ) ) {
                echo 'background-image: url("' . get_theme_mod( 'hq_footer_widgets_background_image' ) . '");';
            }
            $this->_printBackgroundoptions( get_theme_mod( 'hq_footer_widgets_background' ) );
            $this->_printBoxoptions( get_theme_mod( 'hq_footer_widgets_box' ) );
            $this->_printTextoptions( get_theme_mod( 'hq_footer_widgets_text' ) );
            ?>
                }
                .fooret-widgets h1, .fooret-widgets h1 a, .fooret-widgets h2, .fooret-widgets h2 a, .fooret-widgets h3, .fooret-widgets h3 a, .fooret-widgets h4, .fooret-widgets h4 a, .fooret-widgets h5, .fooret-widgets h5 a, .fooret-widgets h6, .fooret-widgets h6 a{
            <?php $this->_printTextoptions( get_theme_mod( 'hq_footer_widgets_headings' ) ); ?>
                }
                .fooret-widgets a{
            <?php $this->_printTextoptions( get_theme_mod( 'hq_footer_widgets_links' ) ); ?>
                }
                .fooret-widgets a:hover{
            <?php $this->_printTextoptions( get_theme_mod( 'hq_footer_widgets_links_hover' ) ); ?>
                }
                .sm-header_topline a { color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                .sm-header_topline li.current-menu-item { border-top-color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                .sm-footer_bottom a { color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                .sm-footer_bottom li.current-menu-item { border-bottom-color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                .sb-icon-search {
                    color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>;
                    background-color: <?php echo get_theme_mod( 'hq_branding_colors_main_secondary' ); ?>;
                }
                .sb-search.sb-search-open .sb-icon-search, .no-js .sb-search .sb-icon-search { background: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                .sb-icon-search{ color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>; }
                                                                                                                                                                                                                                                                        																									
                .comment-list .comment-body .time { color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_primary' ); ?>; }
                .comment-list .comment-body .comment-info { background-color: <?php echo get_theme_mod( 'hq_branding_colors_main_secondary' ); ?>; }
                .comment-list .comment-body .comment-info b {color: <?php echo get_theme_mod( 'hq_branding_colors_main_primary' ); ?>;}
                .comment-list .comment-body .comment-content{background-color: <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>;}
                .comment-list .comment table th, .comment-list .comment table td{ border: 1px solid <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>; }
                                                                                                                                                                                                                                                                        																						
                #commentform .form-submit input{ color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>; };
                                                                                                                                                                                                                                                                        																			
                #commentform input[type="text"],
                #commentform textarea{
                    &::-moz-placeholder           { color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_secondary' ); ?>;   // Firefox
                                                    opacity: 1; } // See https://github.com/twbs/bootstrap/pull/11526
                    &:-ms-input-placeholder       { color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_secondary' ); ?>; } // Internet Explorer 10+
                    &::-webkit-input-placeholder  { color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_secondary' ); ?>; } // Safari and Chrome
                }
                .comment-reply-title{ border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_main_secondary' ); ?>;} 
                                                                                                                                                                                                                                                                        										
                /** BLOG */
                .entry-title{ border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                footer.entry-meta{
                    border-top: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>;
                    border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>;
                }
                .gallery .gallery-item figcaption{ background-color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>; }
                                                                                                                                                                                                                                                                        										
                /** WIDGETS */
                .widget .heading{
                    //color: @color-sup-primary;
                    //border-bottom: 1px solid @color-sup-secondary;
                }
                .widget li { border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                .widget li:before { color: <?php echo get_theme_mod( 'hq_branding_colors_neutral_primary' ); ?>; }
                .widget_nav_menu li { border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                .widget_nav_menu li ul.sub-menu li:first-of-type { border-top: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                .widget_pages li { border-bottom: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                .widget_pages ul.children li:first-of-type { border-top: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                                                                                                                
                .fooret-widgets .widget_tag_cloud a { border-color: <?php echo get_theme_mod( 'hq_layout_background_color' ); ?>; }
                .fooret-widgets .widget li:before{ color: <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
                                                                                                                                                                                                                          							
                /** Page / Post Backgrounds Slider */
            <?php
            $background_enable_grayscale = get_field( 'background_enable_grayscale' );
            if ( isset( $background_enable_grayscale ) && $background_enable_grayscale == 'yes' ) {
                ?>
                    .background-superslides  img { 
                        filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); /* Firefox 10+, Firefox on Android */
                        filter: gray; /* IE6-9 */
                        -webkit-filter: grayscale(100%); /* Chrome 19+, Safari 6+, Safari 6+ iOS */ 
                    }
                <?php
            }
            ?>
                .entry-meta{
                    display: none;
                }
                @media only screen and (max-width : 992px) {
                    .header_topline .text-left{
                        display:none;
                    }
                }
                                                                                                                                                                                                                                                                        							
                /** WooCommerce */
                .widget_shopping_cart .total{ border-top: 1px solid <?php echo get_theme_mod( 'hq_branding_colors_sup_secondary' ); ?>; }
            </style>
            <?php
        }

        public function print_js_scripts() {
            global $hq_blog_layout;
            ?>
            <script type="text/javascript">
                (function ($) {
            <?php if ( (!isset( $hq_blog_layout ) && get_theme_mod( 'hq_blog_layout' ) == 'masonry') || (isset( $hq_blog_layout ) && $hq_blog_layout == 'masonry') ) : ?>
                        $('#articles').imagesLoaded(function () {
                            $('#articles').masonry({
                                itemSelector: 'article',
                                //isRTL: true,
                                isAnimated: true,
                                animationOptions: {
                                    duration: 750,
                                    easing: 'linear',
                                    queue: false
                                }
                            });
                        });
            <?php endif; ?>
            <?php if ( get_theme_mod( 'hq_blog_pagination_infinite' ) ) : ?>
                        $('#articles').infinitescroll({
                            navSelector: "nav.paging-navigation",
                            // selector for the paged navigation (it will be hidden)

                            nextSelector: "div.nav-previous a",
                            // selector for the NEXT link (to page 2)

                            itemSelector: "#articles article",
                            // selector for all items you'll retrieve

                            debug: true,
                            // enable debug messaging ( to console.log )

                            //loadingImg: "/img/loading.gif",
                            // loading image.
                            // default: "http://www.infinite-scroll.com/loading.gif"

                            loadingText: "Loading new posts...",
                            // text accompanying loading image
                            // default: "<em>Loading the next set of posts...</em>"

                            animate: true,
                            // boolean, if the page will do an animated scroll when new content loads
                            // default: false

                            extraScrollPx: 150,
                            // number of additonal pixels that the page will scroll 
                            // (in addition to the height of the loading div)
                            // animate must be true for this to matter
                            // default: 150

                            donetext: "All items loaded.",
                            // text displayed when all items have been retrieved
                            // default: "<em>Congratulations, you've reached the end of the internet.</em>"

                            bufferPx: 40,
                            // increase this number if you want infscroll to fire quicker
                            // (a high number means a user will not see the loading message)
                            // new in 1.2
                            // default: 40

                            behavior: 'hqtheme',
                            errorCallback: function () {
                            },
                            // called when a requested page 404's or when there is no more content
                            // new in 1.2                   

                            localMode: true
                                    // enable an overflow:auto box to have the same functionality
                                    // demo: http://paulirish.com/demo/infscr
                                    // instead of watching the entire window scrolling the element this plugin
                                    //   was called on will be watched
                                    // new in 1.2
                                    // default: false

                        },
                        // Trigger Masonry as a callback
                        function (newElements) {
                            var $newElems = $(newElements).css({opacity: 0});
                            $('#articles').imagesLoaded(function () {
                                $newElems.animate({opacity: 1});
                                $('#articles').masonry({
                                    itemSelector: 'article',
                                    //isRTL: true,
                                    isAnimated: true,
                                    animationOptions: {
                                        duration: 750,
                                        easing: 'linear',
                                        queue: false
                                    }
                                });
                            });
                        });
            <?php endif; ?>
                })(jQuery);
            </script>
            <?php
        }

        protected function _printTextoptions( $value ) {
            $options = explode( ';', $value );
            foreach ( $options as $option ) {
                $tmp = explode( ':', $option );
                if ( empty( $tmp[1] ) ) {
                    continue;
                }
                echo $option;
                if ( in_array( $tmp[0], array( 'font-size', 'letter-spacing' ) ) ) {
                    echo 'px';
                }
                echo ';';
            }
        }

        protected function _printBoxoptions( $value ) {
            $options = explode( ';', $value );
            foreach ( $options as $option ) {
                $tmp = explode( ':', $option );
                if ( empty( $tmp[1] ) ) {
                    continue;
                }
                echo $option;
                if ( strpos( $tmp[0], '-style' ) === false && strpos( $tmp[0], '-color' ) === false ) {
                    echo 'px';
                }
                echo ';';
            }
        }

        protected function _printBackgroundoptions( $value ) {
            echo $value;
        }

    }

}