<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (get_theme_mod('hq_woocommerce_single_title')) {
    ?>
    <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
    <?php
}
?>