<?php

if (!class_exists('HQTheme_WooCommerce')) {

    class HQTheme_WooCommerce {

        static $instance;
        public $layout;

        function __construct() {
            self::$instance = & $this;

            // Turn on Catalog Mode if enabled
            add_filter('woocommerce_is_purchasable', array($this, 'woocommerce_prodcucts_is_purchasable'));
            add_action('init', array($this, 'remove_loop_button'));

            // Price
            add_filter('woocommerce_get_price_html', array($this, 'price'));

            // Prev Next Product
            add_action('woocommerce_after_single_product_summary', array($this, 'product_navigation_prev_next'), 12);
            
            // Thumbnail per row in product details page
            add_filter('woocommerce_product_thumbnails_columns', array($this, 'woocommerce_product_thumbnails_columns'));
        }

        function woocommerce_prodcucts_is_purchasable($purchasable) {
            if (get_theme_mod('hq_woocommerce_catalog_mode')) {
                return false;
            }
            return $purchasable;
        }

        function remove_loop_button() {
            if (get_theme_mod('hq_woocommerce_catalog_mode')) {
                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            }
        }

        function price($price) {
            if (get_theme_mod('hq_woocommerce_catalog_mode') && get_theme_mod('hq_woocommerce_hide_price')) {
                return '';
            }
            return $price;
        }

        function product_navigation_prev_next() {
            if (!get_theme_mod('hq_woocommerce_single_prev_next')) {
                return;
            }
            // Get the current url	
            global $post;
            $current_url = get_permalink($post->ID);
            $next = '';
            $previous = '';

            // Get the previous and next product links
            $previous_post = get_adjacent_post(false, '', true);
            $next_post = get_adjacent_post(false, '', false);

            $previous_link = get_permalink($previous_post);
            $next_link = get_permalink($next_post);


            // Create the two links provided the product exists
            if ($next_link != $current_url) {
                $next = "<a href='" . $next_link . "'>" . $next_post->post_title . "</a>";
            }
            if ($previous_link != $current_url) {
                $previous = "<a href='" . $previous_link . "'>" . $previous_post->post_title . "</a>";
            }

            // Create HTML Output
            $output = '<div class="hq_woocommerce_prev_next_links">';
            if ($previous != '')
                $output .= '<span class="previous">< ' . $previous . '</span>';
            if ($next != '')
                $output .= '<span class="next">' . $next . ' ></span>';
            $output .= '</div>';

            // Display the final output
            echo $output;
        }
        
        public function woocommerce_product_thumbnails_columns($count) {
            return 4;
        }
    }

}