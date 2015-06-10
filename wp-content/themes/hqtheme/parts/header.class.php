<?php
if (!class_exists('HQTheme_Header')) {

    class HQTheme_Header {

        /**
         *
         * @var HQTheme_Header
         */
        static $instance;

        function __construct() {
            self::$instance = & $this;

            add_action('wp_head', array($this, 'favicon_display'));
            add_action('__before_main_container', array($this, 'header_display'), 20);
        }

        /**
         * Render favicon from options
         */
        function favicon_display() {

            $saved_path = get_theme_mod('hq_header_logo_fav_upload');
            if (!$saved_path || is_null($saved_path))
                return;

            //rebuild the path : check if the full path is already saved in DB. If not, then rebuild it.
            $upload_dir = wp_upload_dir();

            if (false !== strpos($saved_path, '/wp-content/')) {
                $url = $saved_path;
            } else {
                $url = $upload_dir['baseurl'] . $saved_path;
            }

            if ($url != null) {
                $type = "image/x-icon";
                if (strpos($url, '.png'))
                    $type = "image/png";
                if (strpos($url, '.gif'))
                    $type = "image/gif";
                $html = '<link rel="shortcut icon" href="' . $url . '" type="' . $type . '">';
                echo apply_filters('hq_favicon_display', $html);
            }
        }

        /**
         * Displays the tagline.
         */
        function topline_display() {
            $html = '';

            $display = get_theme_mod('hq_header_topline_display');

            if ($display) {
                ob_start();
                HQTheme_Elements::getInstance()->headerFooterLine('header_topline');
                $html = ob_get_clean();
            }

            echo apply_filters('hq_topline_display', $html);
        }

        /**
         * Displays the header.
         */
        function header_display() {
            echo '<header>';
            $this->topline_display();

            $header_position = get_theme_mod('hq_header_position');

            if (get_theme_mod('hq_header_position') != 'hidden') {
                $nav_position = get_theme_mod('hq_header_navigation_position');
                $logo_position = get_theme_mod('hq_header_logo_position');
                echo '<div class="row ' . $header_position . ' main_header"><div class="content-wrapper">';

                switch ($logo_position) {
                    case 'hidden':
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-xs-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'left':
                    if ($nav_position == 'hidden') {
                        ?>
                        <div class="col-xs-12 text-left">
                            <?php $this->display_logo(); ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-sm-4 col-xs-10 p-lr-8">
                            <?php $this->display_logo(); ?>
                        </div>
                        <div class="col-sm-8 col-xs-2 header-navigation text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'center':
                    if ($nav_position == 'hidden') {
                        ?>
                        <div class="col-xs-12 text-center">
                            <?php $this->display_logo(); ?>
                        </div>
                        <?php
                    } elseif ($nav_position == 'left') {
                        ?>
                        <div class="col-sm-4 col-xs-2 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <div class="col-sm-4 col-xs-10">
                            <?php $this->display_logo(); ?>
                        </div>
                        <div class="col-sm-4 hidden-xs"></div>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-4 hidden-xs"></div>
                        <div class="col-md-4 col-xs-10">
                            <?php $this->display_logo(); ?>
                        </div>
                        <div class="col-md-4 col-xs-2 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'right':
                    if ($nav_position == 'hidden') {
                        ?>
                        <div class="col-sm-12 text-right">
                            <?php $this->display_logo(); ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-sm-8 col-xs-2 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <div class="col-sm-4 col-xs-10">
                            <?php $this->display_logo(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'left-above':
                    ?>
                    <div class="col-sm-12 text-left">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'center-above':
                    ?>
                    <div class="col-sm-12 text-center">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;
                    case 'right-above':
                    ?>
                    <div class="col-sm-12 text-right">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    break;

                    case 'left-below':
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 col-xs-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                            <div class="hidden-sm hidden-md hidden-lg absolute-logo-xs">
                                <?php $this->display_logo(); ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-sm-12 hidden-xs text-left">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    break;
                    case 'center-below':
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-sm-12 text-center">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    break;
                    case 'right-below':
                    if ($nav_position != 'hidden') {
                        ?>
                        <div class="col-sm-12 text-<?php echo $nav_position; ?>">
                            <?php $this->display_primary_nav(); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-sm-12 text-right">
                        <?php $this->display_logo(); ?>
                    </div>
                    <?php
                    break;

                    default:
                    break;
                }
                echo '</div></div>'; // Close header div row
            }

            echo '</header>';
        }

        function display_primary_nav() {
            if (has_nav_menu('primary')) {
                ?>
                <?php
                $menu_args = array(
                    'menu' => 'primary',
                    'theme_location' => 'primary',
                    'depth' => 0,
                    'walker' => new Mega_Menu_Walker(),
                    );
                wp_nav_menu($menu_args);
                ?>
                <?php
            } else {
                echo '<a href="' . home_url('/') . 'wp-admin/nav-menus.php" target="_blank">' . __('Assign a Menu', HQTheme::THEME_SLUG) . '</a>';
            }
        }

        /**
         * Displays the logo or blog name.
         */
        function display_logo() {
            ob_start();
            $saved_path = get_theme_mod('hq_header_logo_upload');
            if ($saved_path) {
                $upload_dir = wp_upload_dir();
                if (false !== strpos($saved_path, '/wp-content/')) {
                    $logo_src = $saved_path;
                } else {
                    $logo_src = $upload_dir['baseurl'] . $saved_path;
                }

                $width = '';
                $height = '';
                if (@getimagesize($logo_src)) {
                    list( $width, $height ) = getimagesize($logo_src);
                }

                $logo_resize_style = '';
                if (get_theme_mod('hq_header_logo_resize')) {
                    $logo_resize_width = get_theme_mod('hq_header_logo_resize_width');
                    $logo_resize_height = get_theme_mod('hq_header_logo_resize_height');
                    $logo_resize_style = 'style="';
                    if ($logo_resize_width) {
                        $logo_resize_style .= 'width: ' . $logo_resize_width . 'px;';
                    }
                    if ($logo_resize_height) {
                        $logo_resize_style .= 'height: ' . $logo_resize_height . 'px;';
                    }
                    $logo_resize_style .= '"';
                }
                printf('<a class="site-title" href="%1$s" title="%2$s | %3$s"><img src="%4$s" alt="%5$s" %6$s /></a>', esc_url(home_url('/')), esc_attr(get_bloginfo('name')), esc_attr(get_bloginfo('description')), $logo_src, __('Back Home', HQTheme::THEME_SLUG), $logo_resize_style);
            } else {
                echo '<h1 class="site-title"><a  href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . ' | ' . esc_attr(get_bloginfo('description')) . '">' . get_bloginfo('name') . '</a></h1>';
            }

            $html = ob_get_contents();
            if ($html)
                ob_end_clean();
            echo apply_filters('hq_logo_display', $html);
        }

    }

}