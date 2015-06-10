<?php
if ( !class_exists( 'HQTheme_Elements' ) ) {

    class HQTheme_Elements {

        /**
         *
         * @var HQTheme_Elements 
         */
        protected static $_instance;

        function __construct() {
            self::$_instance = & $this;
        }

        public static function getInstance() {
            if ( empty( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function display_socials() {

            $socials = HQTheme_Customize::getInstance()->get_social_links();

            //declares some vars
            $target = apply_filters( 'hq_socials_target', 'target=_blank' );
            $html = '';

            foreach ( $socials as $key => $data ) {
                if ( get_theme_mod( 'hq_social_links_' . $key ) != '' ) {
                    $html .= '<a href="' . esc_url( get_theme_mod( 'hq_social_links_' . $key ) ) . '" title="' . $data['link_title'] . '" ' . $target . ' %5$s><span class="social fa ' . (!empty( $data['icon'] ) ? $data['icon'] : '') . '"></span></a>';
                }
            }
            echo $html;
        }

        public function headerFooterLine( $vpos ) {
            $left = get_theme_mod( 'hq_' . $vpos . '_left' );
            $center = get_theme_mod( 'hq_' . $vpos . '_center' );
            $right = get_theme_mod( 'hq_' . $vpos . '_right' );
            $leftCol = 0;
            $centerCol = 0;
            $rightCol = 0;

            $big = array( 'text', 'menu' );

            if ( $center == 'none' ) {
                if ( $left == 'none' ) {
                    $rightCol = 12;
                } else {
                    if ( $right == 'none' ) {
                        $leftCol = 12;
                    } else {
                        if ( in_array( $left, $big ) ) {
                            if ( in_array( $right, $big ) ) {
                                $leftCol = 6;
                                $rightCol = 6;
                            } else {
                                $leftCol = 8;
                                $rightCol = 4;
                            }
                        } else {
                            if ( in_array( $right, $big ) ) {
                                $leftCol = 4;
                                $rightCol = 8;
                            } else {
                                $leftCol = 6;
                                $rightCol = 6;
                            }
                        }
                    }
                }
            } else {
                if ( $left == 'none' && $right == 'none' ) {
                    $centerCol = 12;
                } else {
                    if ( in_array( $left, $big ) || in_array( $right, $big ) ) {
                        if ( in_array( $center, $big ) ) {
                            $centerCol = 4;
                            $leftCol = 4;
                            $rightCol = 4;
                        } else {
                            $centerCol = 2;
                            $leftCol = 5;
                            $rightCol = 5;
                        }
                    } else {
                        if ( in_array( $center, $big ) ) {
                            $centerCol = 8;
                            $leftCol = 2;
                            $rightCol = 2;
                        } else {
                            $centerCol = 4;
                            $leftCol = 4;
                            $rightCol = 4;
                        }
                    }
                }
            }
            echo '<div class="row ' . $vpos . '"><div class="content-wrapper">';
            if ( $leftCol ) {
                echo '<div class="col-xs-12 col-sm-' . $leftCol . ' text-left ' . $left . '">';
                if ( $left != 'none' ) {
                    $this->headerFooterLineElements( $left, $vpos, 'left' );
                }
                echo '</div>';
            }

            if ( $centerCol ) {
                echo '<div class="col-sm-' . $centerCol . ' text-center hidden-xs ' . $center . '">';
                if ( $center != 'none' ) {
                    $this->headerFooterLineElements( $center, $vpos, 'center' );
                }
                echo '</div>';
            }

            if ( $rightCol ) {
                echo '<div class="col-xs-12 col-sm-' . $rightCol . ' text-right ' . $right . '">';
                if ( $right != 'none' ) {
                    $this->headerFooterLineElements( $right, $vpos, 'right' );
                }
                echo '</div>';
            }
            echo '</div></div>';
        }

        public function headerFooterLineElements( $type, $vpos, $pos ) {
            switch ( $type ) {
                case 'text':
                    echo do_shortcode( get_theme_mod( 'hq_' . $vpos . '_' . $pos . '_text' ) );
                    break;
                case 'socials':
                    $this->display_socials();
                    break;
                case 'search':
                    get_search_form();
                    break;
                case 'socials-search':
                    $this->display_socials();
                    get_search_form();
                    break;
                case 'logo':
                    $saved_path = get_theme_mod( 'hq_header_logo_upload' );
                    if ( $saved_path ) {
                        $upload_dir = wp_upload_dir();
                        if ( false !== strpos( $saved_path, '/wp-content/' ) ) {
                            $logo_src = $saved_path;
                        } else {
                            $logo_src = $upload_dir['baseurl'] . $saved_path;
                        }

                        $width = '';
                        $height = '';
                        if ( @getimagesize( $logo_src ) ) {
                            list( $width, $height ) = getimagesize( $logo_src );
                        }

                        $logo_resize_style = 'style="height: ' . get_theme_mod( 'hq_' . $vpos . '_height' ) . 'px"';
                        printf( '<a class="site-logo" href="%1$s" title="%2$s | %3$s"><img src="%4$s" alt="%5$s" width="%6$s" height="%7$s" %8$s /></a>', esc_url( home_url( '/' ) ), esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo( 'description' ) ), $logo_src, __( 'Back Home', HQTheme::THEME_SLUG ), $width, $height, $logo_resize_style );
                    }
                    break;
                case 'menu':
                    if ( has_nav_menu( $vpos . '-' . $pos ) ) {
                        $menu_args = array(
                            'menu' => $vpos . '-' . $pos,
                            'theme_location' => $vpos . '-' . $pos,
                            'depth' => 0,
                            'container' => 'div',
                            'container_class' => '',
                            'menu_class' => 'sm sm-' . $vpos,
                            'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                //'walker' => new HQTheme_NavigationWalker(),
                        );
                        wp_nav_menu( $menu_args );
                    } else {
                        echo '<a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php" target="_blank">' . __( 'Assign a Menu', HQTheme::THEME_SLUG ) . '</a>';
                    }
                    break;
                case 'woo-cart':
                    if ( class_exists( 'Woocommerce' ) && !get_theme_mod( 'hq_woocommerce_catalog_mode' ) ) {
                        if ( function_exists( 'wc_print_notices' ) ) {
                            global $woocommerce;
                            ?>
                            <div class="cart-inner">
                                <?php // Edit this content in inc/template-tags.php. Its gets relpaced with Ajax!      ?>
                                <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="cart-link">
                                    <div class="fa fa-shopping-cart"></div>
                                    <strong class="cart-name hide-for-small"><?php _e( 'Cart', 'woocommerce' ); ?></strong>
                                    <span class="cart-price hide-for-small">/ <?php echo $woocommerce->cart->get_cart_total(); ?></span>
                                </a>
                                <div class="nav-dropdown">
                                    <div class="nav-dropdown-inner">
                                        <!-- Add a spinner before cart ajax content is loaded -->
                                        <?php
                                        if ( $woocommerce->cart->cart_contents_count == 0 ) {
                                            echo '<p class="empty">' . __( 'No products in the cart.', 'woocommerce' ) . '</p>';
                                            ?>
                                        <?php } else { //add a spinner   ?>
                                            <div class="loading"></div>
                                        <?php } ?>
                                    </div><!-- nav-dropdown-innner -->
                                </div><!-- .nav-dropdown -->
                            </div><!-- .cart-inner -->
                            <?php
                        }
                    }
                    break;

                case 'widgets':
                    generated_dynamic_sidebar( 'widgets-' . $vpos . '-' . $pos, '' );
                    break;
            }
        }

    }

}