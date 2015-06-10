<?php

if (!class_exists('HQTheme_Layout')) {

    class HQTheme_Layout {

        static $instance;
        public $left_sidebar;
        public $right_sidebar;

        function __construct() {
            self::$instance = & $this;

            add_action('__before_article_container', array($this, 'display_sidebar_before_article'));
            add_action('__after_article_container', array($this, 'display_sidebar_after_article'));

            add_filter('hq_site_content_class', array($this, 'site_content_class'));
        }

        public function display_sidebar_before_article() {
            $main_layout = get_theme_mod('hq_layout_content_layout');
            $portfolio_layout = get_theme_mod('hq_portfolio_sidebar_position');

            if (is_home() || is_category() || is_singular('post')) {
                $this->left_sidebar = get_theme_mod('hq_blog_sidebar_left');
                $this->right_sidebar = get_theme_mod('hq_blog_sidebar_right');
                if (get_theme_mod( 'hq_blog_layout' ) == 'masonry') {
                    wp_enqueue_script( 'imagesloaded' );
                    wp_enqueue_script( 'jquery-masonry' );
                }
                if (get_theme_mod( 'hq_blog_pagination_infinite' )) {
                    wp_enqueue_script( 'imagesloaded' );
                    wp_enqueue_script( 'jquery-infinitescroll' );
                }
            } elseif (function_exists('is_shop') && is_shop()) {
                $this->left_sidebar = get_theme_mod('hq_woocommerce_sidebar_left');
                $this->right_sidebar = get_theme_mod('hq_woocommerce_sidebar_right');
            } elseif (function_exists('is_product') && is_product()) {
                $this->left_sidebar = 0;
                $this->right_sidebar = 0;
            } elseif (is_post_type_archive('hq-portfolio')) {
                $this->left_sidebar = get_theme_mod('hq_portfolio_sidebar_left');
                $this->right_sidebar = get_theme_mod('hq_portfolio_sidebar_right');
            } else {
                $this->left_sidebar = get_theme_mod('hq_layout_sidebar_left');
                $this->right_sidebar = get_theme_mod('hq_layout_sidebar_right');
            }
            $selected_sidebar = get_post_meta(get_the_ID(), 'sbg_selected_sidebar_replacement', true);
            if (isset($selected_sidebar['left']) && $selected_sidebar['left'] != '-') {
                $this->left_sidebar = $selected_sidebar['left'];
            }
            if (isset($selected_sidebar['right']) && $selected_sidebar['right'] != '-') {
                $this->right_sidebar = $selected_sidebar['right'];
            }
        }

        public function display_sidebar_after_article() {
            if ($this->left_sidebar) {
                if ($this->right_sidebar) {
                    generated_dynamic_sidebar($this->left_sidebar);
                } else {
                    generated_dynamic_sidebar($this->left_sidebar, 'col-sm-4 col-sm-pull-8 col-xs-12');
                }
            }
            
            if ($this->right_sidebar) {
                if ($this->left_sidebar) {
                    generated_dynamic_sidebar($this->right_sidebar);
                } else {
                    generated_dynamic_sidebar($this->right_sidebar, 'col-sm-4 col-sm-pull-8 col-xs-12');
                }
            }
        }

        public function site_content_class($value) {
            if ($this->left_sidebar) {
                if ($this->right_sidebar) {
                    return $value . ' ' . 'col-sm-6 col-xs-12';
                }
            } else {
                if (!$this->right_sidebar) {
                    return $value . ' ' . 'col-sm-12';
                }
            }
            return $value . ' ' . 'col-sm-8 col-sm-push-4 col-xs-12';
        }

    }

}