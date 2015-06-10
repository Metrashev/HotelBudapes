<?php

if (!class_exists('HQTheme_Blog')) {

    class HQTheme_Blog {

        static $instance;
        public $layout;

        function __construct() {
            self::$instance = & $this;

            add_filter('excerpt_length', array($this, 'excerpt_length'));
            add_filter('post_class', array($this, 'check_layout_type'));
        }

        function excerpt_length($length) {

            $the_length = get_theme_mod('hq_blog_excerpt_length');
            $the_output = ( $the_length == '' ) ? 60 : $the_length;

            return $the_output;
        }

        function check_layout_type($class = '') {
            global $hq_blog_layout, $hq_blog_layout_columns;
            if ((!isset($hq_blog_layout) && get_theme_mod('hq_blog_layout') == 'masonry') || (isset($hq_blog_layout) && $hq_blog_layout == 'masonry')) {
                $class[] = 'blog-grid-' . (isset($hq_blog_layout_columns) ? $hq_blog_layout_columns : (get_theme_mod('hq_blog_layout_columns') ? get_theme_mod('hq_blog_layout_columns') : 3));
            }
            return $class;
        }

    }

}